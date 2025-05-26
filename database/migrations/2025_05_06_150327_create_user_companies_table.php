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
        Schema::create('user_companies', function (Blueprint $table) {
            $table->string('company_id', 30)->primary();           // max 30 karakter, cukup untuk kode company
            $table->string('company_name', 100);                   // max 100 karakter
            $table->string('company_description', 100)->nullable();// max 100 karakter, nullable
            $table->string('company_address', 100);                // max 100 karakter
            $table->string('company_phone', 20);                   // max 20 karakter
            $table->string('company_fax', 20);                     // max 20 karakter
            $table->string('company_email', 100)->unique();        // max 100 karakter
            $table->string('company_website', 100)->nullable();    // max 100 karakter, nullable
            $table->string('company_img', 255)->nullable();        // max 255 karakter, nullable
            $table->string('company_currency', 10)->nullable();    // max 10 karakter, nullable (misal: IDR, USD)
            $table->string('company_bank_account', 50)->nullable();// max 50 karakter, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_companies');
    }
};
