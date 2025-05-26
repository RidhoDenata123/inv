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
        Schema::create('dispatching_details', function (Blueprint $table) {
            $table->string('dispatching_detail_id', 30)->primary();      // max 30 karakter, cukup untuk kode detail
            $table->string('dispatching_header_id', 30);                 // max 30 karakter, relasi ke header
            $table->string('product_id', 30);                            // max 30 karakter, relasi ke produk
            $table->integer('dispatching_qty')->default(0);
            $table->string('dispatching_detail_status', 20);             // max 20 karakter (misal: Confirmed/Pending)
            $table->string('created_by', 20)->nullable();                // max 20 karakter (ID user)
            $table->string('confirmed_by', 20)->nullable();              // max 20 karakter (ID user)
            $table->timestamp('confirmed_at')->nullable();               // waktu konfirmasi, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatching_details');
    }
};
