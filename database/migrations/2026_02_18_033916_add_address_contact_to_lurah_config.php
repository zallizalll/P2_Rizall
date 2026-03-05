<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lurah_config', function (Blueprint $table) {
            $table->string('address')->nullable()->after('pos_code');
            $table->string('contact')->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('lurah_config', function (Blueprint $table) {
            $table->dropColumn(['address', 'contact']);
        });
    }
};