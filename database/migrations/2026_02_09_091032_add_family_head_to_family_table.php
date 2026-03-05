<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('family', function (Blueprint $table) {
            $table->foreignId('family_head_id')
                  ->nullable()
                  ->constrained('warga')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('family', function (Blueprint $table) {
            $table->dropForeign(['family_head_id']);
            $table->dropColumn('family_head_id');
        });
    }
};