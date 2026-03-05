<?php

namespace App\Repository;

use App\Models\DocumentLog;
use App\Models\Warga;
use App\Models\LurahConfig;

class SktmRepository
{
    /**
     * Cari warga by NIK atau nama untuk autocomplete
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
     * Simpan SKTM ke document_log
     */
    public function save(array $detail): DocumentLog
    {
        return DocumentLog::create([
            'doc_type'   => 'SKTM',
            'detail'     => $detail,
            'local_file' => '',   // kolom NOT NULL, isi string kosong dulu
        ]);
    }

    /**
     * Ambil semua arsip SKTM
     */
    public function getAll()
    {
        return DocumentLog::where('doc_type', 'SKTM')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Ambil konfigurasi kelurahan
     */
    public function getConfig(): ?LurahConfig
    {
        return LurahConfig::first();
    }

    /**
     * Generate nomor surat otomatis
     * Format: SKTM/[BULAN-ROMAWI]/[TAHUN]/[URUTAN]
     */
    public function generateNomorSurat(): string
    {
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        $bulan = (int) now()->format('n');
        $tahun = now()->format('Y');

        $count = DocumentLog::where('doc_type', 'SKTM')
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->count();

        $urutan = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return "474/{$urutan}/SKTM/{$bulanRomawi[$bulan]}/{$tahun}";
    }
}