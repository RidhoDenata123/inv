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
            $table->string('customer_id')->primary(); // Ubah tipe data menjadi string dan jadikan primary key
            $table->string('customer_name');
            $table->string('customer_description')->nullable();
            $table->string('customer_address');
            $table->string('customer_phone');
            $table->string('customer_email')->unique();
            $table->string('customer_website')->nullable();
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