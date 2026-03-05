<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk')->unique();
            $table->foreignId('rt_id')->constrained('rukun')->onDelete('cascade');
            $table->foreignId('rw_id')->constrained('rukun')->onDelete('cascade');
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family');
    }
};