<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_log', function (Blueprint $table) {
            $table->id();
            $table->json('detail');
            $table->string('doc_type'); 
            $table->string('local_file'); 
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_log');
    }
};