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
        Schema::create('dispatching_headers', function (Blueprint $table) {
            $table->string('dispatching_header_id', 30)->primary();           // max 30 karakter, cukup untuk kode header
            $table->string('dispatching_header_name', 100);                   // max 100 karakter
            $table->string('customer_id', 30);                                // max 30 karakter, relasi ke customer
            $table->string('dispatching_header_description', 100)->nullable();// max 100 karakter, nullable
            $table->string('created_by', 20);                                 // max 20 karakter (ID user)
            $table->string('dispatching_header_status', 20);                  // max 20 karakter (misal: Confirmed/Pending)
            $table->string('confirmed_by', 20)->nullable();                   // max 20 karakter (ID user), nullable
            $table->timestamp('confirmed_at')->nullable();                    // waktu konfirmasi, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatching_headers');
    }
};