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
            $table->string('receiving_header_id')->primary();
            $table->string('receiving_header_name');
            $table->string('receiving_header_description')->nullable();
            $table->string('created_by');
            $table->string('receiving_header_status');
            $table->string('confirmed_by')->nullable();
            $table->string('confirmed_at')->nullable();
            $table->string('receiving_document')->nullable();
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
