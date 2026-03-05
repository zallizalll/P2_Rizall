<?php

namespace App\Repository;

use App\Models\DocumentLog;
use App\Models\Warga;
use App\Models\LurahConfig;

class PindahKeluarRepository
{
    /**
     * Cari warga yang masih hidup dan belum pindah
     */
    public function searchWarga(string $keyword)
    {
        return Warga::where('living_status', 'hidup')
            ->where(function ($q) use ($keyword) {
                $q->where('nik', 'like', '%' . $keyword . '%')
                  ->orWhere('name', 'like', '%' . $keyword . '%');
            })
            ->with(['family.rt', 'family.rw'])
            ->limit(10)
            ->get()
            ->map(function ($w) {
                $family = $w->family;
                return [
                    'id'             => $w->id,
                    'nik'            => $w->nik,
                    'name'           => $w->name,
                    'gender'         => $w->gender,
                    'birth_place'    => $w->birth_place,
                    'birth_date'     => $w->birth_date?->format('Y-m-d'),
                    'birth_date_fmt' => $w->birth_date?->format('d F Y'),
                    'no_kk'          => $w->no_kk ?? '-',
                    'address'        => $family?->address ?? '-',
                    'rt'             => $family?->rt?->no ?? '-',
                    'rw'             => $family?->rw?->no ?? '-',
                    'occupation'     => $w->occupation ?? '-',
                    'married_status' => $w->married_status ?? '-',
                    'religious'      => $w->religious ?? '-',
                ];
            });
    }

    /**
     * Update status warga menjadi pindah
     */
    public function updateStatusPindah(int $wargaId): void
    {
        Warga::where('id', $wargaId)->update(['living_status' => 'pindah']);
    }

    public function save(array $detail): DocumentLog
    {
        return DocumentLog::create([
            'doc_type'   => 'PINDAH_KELUAR',
            'detail'     => $detail,
            'local_file' => '',
        ]);
    }

    public function getConfig(): ?LurahConfig
    {
        return LurahConfig::first();
    }

    public function generateNomorSurat(): string
    {
        $bulanRomawi = [
            1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',
            7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'
        ];

        $bulan  = (int) now()->format('n');
        $tahun  = now()->format('Y');
        $count  = DocumentLog::where('doc_type', 'PINDAH_KELUAR')
                    ->whereYear('created_at', $tahun)
                    ->whereMonth('created_at', $bulan)
                    ->count();

        $urutan = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return "474/{$urutan}/PK/{$bulanRomawi[$bulan]}/{$tahun}";
    }
}