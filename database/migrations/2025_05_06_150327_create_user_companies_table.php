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
            $table->string('company_id')->primary();
            $table->string('company_name');
            $table->string('company_description')->nullable();
            $table->string('company_address');
            $table->string('company_phone');
            $table->string('company_fax');
            $table->string('company_email')->unique();
            $table->string('company_website')->nullable();
            $table->string('company_img')->nullable();
            $table->string('company_currency')->nullable();
            $table->string('company_bank_account')->nullable();
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
