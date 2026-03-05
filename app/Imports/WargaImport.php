<?php

namespace App\Imports;

use App\Models\Warga;
use App\Models\Family;
use App\Models\Rukun;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class WargaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $successes = [];
    public array $errors    = [];

    private array $validNoKk  = [];
    private array $rukunCache = [];

    public function __construct()
    {
        $this->validNoKk = Family::pluck('no_kk')->toArray();

        Rukun::all()->each(function ($r) {
            $key = strtoupper($r->type) . '-' . $r->no;
            $this->rukunCache[$key] = $r->id;
        });
    }

    public function sheets(): array
    {
        return [0 => $this];
    }

    public function collection(Collection $rows)
    {
        // pake no kk
        foreach ($rows as $rowNumber => $row) {
            $actualRow   = $rowNumber + 2;
            $buatKkBaru  = strtolower(trim((string) ($row['buat_kk_baru'] ?? '')));
            $isBuatBaru  = in_array($buatKkBaru, ['ya', 'yes', '1', 'true']);

            $data = [
                'nik'            => trim((string) ($row['nik'] ?? '')),
                'name'           => trim((string) ($row['nama'] ?? '')),
                'gender'         => strtoupper(trim((string) ($row['jenis_kelamin'] ?? ''))),
                'birth_place'    => trim((string) ($row['tempat_lahir'] ?? '')),
                'birth_date'     => $this->parseDate($row['tanggal_lahir'] ?? null),
                'religious'      => trim((string) ($row['agama'] ?? '')) ?: null,
                'education'      => trim((string) ($row['pendidikan'] ?? '')) ?: null,
                'married_status' => trim((string) ($row['status_pernikahan'] ?? '')) ?: null,
                'occupation'     => trim((string) ($row['pekerjaan'] ?? '')) ?: null,
                'blood_type'     => strtoupper(trim((string) ($row['golongan_darah'] ?? ''))) ?: null,
                'living_status'  => strtolower(trim((string) ($row['status_kehidupan'] ?? ''))) ?: 'hidup',
                'no_kk'          => trim((string) ($row['no_kk'] ?? '')) ?: null,
            ];

            $rtNo     = trim((string) ($row['rt'] ?? ''));
            $rwNo     = trim((string) ($row['rw'] ?? ''));
            $alamatKk = trim((string) ($row['alamat_kk'] ?? ''));

            if (empty($data['nik'])) continue;

            $wargaRules = [
                'nik'            => 'required|string|size:16|unique:warga,nik',
                'name'           => 'required|string|max:255',
                'gender'         => 'required|in:L,P',
                'birth_place'    => 'required|string|max:255',
                'birth_date'     => 'required|date',
                'religious'      => 'nullable|string|max:255',
                'education'      => 'nullable|string|max:255',
                'married_status' => 'nullable|string|max:255',
                'occupation'     => 'nullable|string|max:255',
                'blood_type'     => 'nullable|string|max:5',
                'living_status'  => 'nullable|in:hidup,meninggal,pindah,tidak_diketahui',
                'no_kk'          => 'nullable|string|size:16',
            ];

            $validator = Validator::make($data, $wargaRules, [
                'nik.required'         => 'NIK wajib diisi',
                'nik.size'             => 'NIK harus 16 digit',
                'nik.unique'           => 'NIK sudah terdaftar di sistem',
                'name.required'        => 'Nama wajib diisi',
                'gender.required'      => 'Jenis kelamin wajib diisi',
                'gender.in'            => 'Jenis kelamin harus L atau P',
                'birth_place.required' => 'Tempat lahir wajib diisi',
                'birth_date.required'  => 'Tanggal lahir wajib diisi',
                'birth_date.date'      => 'Format tanggal tidak valid (gunakan YYYY-MM-DD)',
                'no_kk.size'           => 'No. KK harus 16 digit',
            ]);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row'     => $actualRow,
                    'nik'     => $data['nik'] ?: '-',
                    'name'    => $data['name'] ?: '-',
                    'message' => implode(', ', $validator->errors()->all()),
                ];
                continue;
            }

            if ($isBuatBaru) {

                if (empty($data['no_kk'])) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => 'Kolom no_kk wajib diisi jika buat_kk_baru = ya',
                    ];
                    continue;
                }

                if (in_array($data['no_kk'], $this->validNoKk)) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => "No. KK '{$data['no_kk']}' sudah ada di sistem. Gunakan no_kk berbeda atau kosongkan buat_kk_baru",
                    ];
                    continue;
                }

                if (empty($rtNo) || empty($rwNo) || empty($alamatKk)) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => 'Kolom rt, rw, dan alamat_kk wajib diisi jika buat_kk_baru = ya',
                    ];
                    continue;
                }

                $rtKey = 'RT-' . str_pad($rtNo, 3, '0', STR_PAD_LEFT);
                $rwKey = 'RW-' . str_pad($rwNo, 3, '0', STR_PAD_LEFT);

                $rtId = $this->rukunCache[$rtKey]
                    ?? $this->rukunCache['RT-' . $rtNo]
                    ?? null;
                $rwId = $this->rukunCache[$rwKey]
                    ?? $this->rukunCache['RW-' . $rwNo]
                    ?? null;

                if (!$rtId) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => "RT '{$rtNo}' tidak ditemukan di sistem",
                    ];
                    continue;
                }

                if (!$rwId) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => "RW '{$rwNo}' tidak ditemukan di sistem",
                    ];
                    continue;
                }

                try {
                    DB::transaction(function () use ($data, $rtId, $rwId, $alamatKk) {
                        $family = Family::create([
                            'no_kk'   => $data['no_kk'],
                            'rt_id'   => $rtId,
                            'rw_id'   => $rwId,
                            'address' => $alamatKk,
                        ]);

                        $warga = Warga::create($data);

                        $family->update(['family_head_id' => $warga->id]);
                    });

                    $this->validNoKk[] = $data['no_kk'];

                    $this->successes[] = [
                        'row'  => $actualRow,
                        'nik'  => $data['nik'],
                        'name' => $data['name'] . ' (+ KK baru dibuat)',
                    ];
                } catch (\Exception $e) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => 'Gagal simpan: ' . $e->getMessage(),
                    ];
                }

            // tanpa no kk
            } else {

                if ($data['no_kk'] && !in_array($data['no_kk'], $this->validNoKk)) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => "No. KK '{$data['no_kk']}' tidak ditemukan di sistem",
                    ];
                    continue;
                }

                try {
                    Warga::create($data);
                    $this->successes[] = [
                        'row'  => $actualRow,
                        'nik'  => $data['nik'],
                        'name' => $data['name'],
                    ];
                } catch (\Exception $e) {
                    $this->errors[] = [
                        'row'     => $actualRow,
                        'nik'     => $data['nik'],
                        'name'    => $data['name'],
                        'message' => 'Gagal simpan: ' . $e->getMessage(),
                    ];
                }
            }
        }
    }

    private function parseDate($value): ?string
    {
        if (empty($value)) return null;

        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}