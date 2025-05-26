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
        Schema::create('units', function (Blueprint $table) {
            $table->string('unit_id', 30)->primary(); // max 30 karakter, cukup untuk kode kategori
            $table->string('unit_name', 100); // max 100 karakter
            $table->string('unit_description', 100)->nullable(); // max 100 karakter, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};