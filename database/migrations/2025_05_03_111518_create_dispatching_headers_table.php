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
            $table->string('dispatching_header_id')->primary();
            $table->string('dispatching_header_name');
            $table->string('customer_id');
            $table->string('dispatching_header_description')->nullable();
            $table->string('created_by');
            $table->string('dispatching_header_status');
            $table->string('confirmed_by')->nullable();
            $table->string('confirmed_at')->nullable();
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