<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lurah_config', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('pos_code');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lurah_config');
    }
};