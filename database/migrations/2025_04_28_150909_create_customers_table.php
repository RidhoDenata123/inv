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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('customer_id', 30)->primary();           // max 30 karakter, cukup untuk kode customer
            $table->string('customer_name', 100);                   // max 100 karakter
            $table->string('customer_description', 100)->nullable();// max 100 karakter, nullable
            $table->string('customer_address', 100);                // max 100 karakter
            $table->string('customer_phone', 20);                   // max 20 karakter
            $table->string('customer_email', 100)->unique();        // max 100 karakter
            $table->string('customer_website', 100)->nullable();    // max 100 karakter, nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};