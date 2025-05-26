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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->string('account_id', 30)->primary();    // max 30 karakter, cukup untuk kode/nomor unik akun
            $table->string('account_name', 100);            // max 100 karakter, nama pemilik akun
            $table->string('bank_name', 100);               // max 100 karakter, nama bank
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
