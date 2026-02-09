<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jabatan')->insert([
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => 'Admin sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
