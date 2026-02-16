<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rukun', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['RT', 'RW']);
            $table->string('no', 255);
            $table->timestamps(); // otomatis created_at & updated_at (nullable)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rukun');
    }
};
