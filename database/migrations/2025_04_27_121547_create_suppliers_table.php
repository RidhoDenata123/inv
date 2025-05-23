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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->string('supplier_id')->primary(); // Ubah tipe data menjadi string dan jadikan primary key
            $table->string('supplier_name');
            $table->string('supplier_description')->nullable();
            $table->string('supplier_address');
            $table->string('supplier_phone');
            $table->string('supplier_email')->unique();
            $table->string('supplier_website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};