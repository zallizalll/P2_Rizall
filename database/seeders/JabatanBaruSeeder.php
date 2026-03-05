<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanBaruSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jabatan')->insert([
            [
                'name' => 'Kepala Lurah',
                'slug' => 'kepala_lurah',
                'description' => 'Kepala Lurah dengan akses view/lihat arsip surat dan laporan warga. Dapat melihat semua data tapi tidak bisa edit atau hapus.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sekretaris Lurah',
                'slug' => 'sekre_lurah',
                'description' => 'Sekretaris Lurah yang mengelola surat. Bisa edit format/isi surat, impor data warga, tapi tidak bisa hapus/delete warga dan tidak bisa mengatur template surat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff Pelayanan Umum',
                'slug' => 'staff_pelayanan',
                'description' => 'Staff yang melayani warga untuk pembuatan surat. Bisa membuat surat untuk warga, input data pemohon, dan cetak surat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}