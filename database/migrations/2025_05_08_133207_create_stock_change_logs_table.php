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
        Schema::create('stock_change_logs', function (Blueprint $table) {
            $table->string('stock_change_log_id', 30)->primary();    // max 30 karakter, cukup untuk kode log
            $table->string('stock_change_type', 30);                 // max 30 karakter (misal: Restock, Adjustment, dll)
            $table->string('product_id', 30);                        // max 30 karakter, relasi ke produk
            $table->string('reference_id', 30)->nullable();          // max 30 karakter, nullable
            $table->integer('qty_before')->default(0);
            $table->integer('qty_changed')->default(0);
            $table->integer('qty_after')->default(0);
            $table->timestamp('changed_at')->nullable();             // gunakan timestamp, nullable
            $table->string('changed_by', 20)->nullable();            // max 20 karakter (ID user), nullable
            $table->string('change_note', 100)->nullable();          // max 100 karakter, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_change_logs');
    }
};
