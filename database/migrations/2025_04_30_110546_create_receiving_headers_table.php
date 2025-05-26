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
        Schema::create('receiving_headers', function (Blueprint $table) {
            $table->string('receiving_header_id', 30)->primary();           // max 30 karakter, cukup untuk kode header
            $table->string('receiving_header_name', 100);                   // max 100 karakter
            $table->string('receiving_header_description', 255)->nullable();// max 255 karakter, nullable
            $table->string('created_by', 20);                               // max 20 karakter (ID user)
            $table->string('receiving_header_status', 20);                  // max 20 karakter (misal: Confirmed/Pending)
            $table->string('confirmed_by', 20)->nullable();                 // max 20 karakter (ID user), nullable
            $table->timestamp('confirmed_at')->nullable();                  // waktu konfirmasi, nullable
            $table->string('receiving_document', 255)->nullable();          // path/file name, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiving_headers');
    }
};
