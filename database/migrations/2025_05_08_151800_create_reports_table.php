<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->string('report_id', 30)->primary();           // max 30 karakter, cukup untuk kode report
            $table->string('report_type', 30);                    // max 30 karakter (misal: Receiving, Dispatching, dll)
            $table->string('report_title', 100);                  // max 100 karakter
            $table->string('report_description', 100);            // max 100 karakter, cukup untuk deskripsi singkat
            $table->string('report_document', 100)->nullable();   // max 100 karakter, path/file name, nullable
            $table->string('generated_by', 20);                   // max 20 karakter (ID user)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};