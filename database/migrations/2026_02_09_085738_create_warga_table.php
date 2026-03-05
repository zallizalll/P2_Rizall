<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('no_kk');
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('religious')->nullable();
            $table->string('education')->nullable();
            $table->enum('living_status', ['hidup', 'meninggal', 'pindah', 'tidak_diketeahui'])->default('Hidup');
            $table->string('married_status')->nullable();
            $table->string('occupation')->nullable();
            $table->string('blood_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
