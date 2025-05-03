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
        Schema::create('dispatching_details', function (Blueprint $table) {
            $table->string('dispatching_detail_id')->primary();
            $table->string('dispatching_header_id');
            $table->string('product_id');
            $table->integer('dispatching_qty')->default(0);
            $table->string('dispatching_detail_status');
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('dispatching_details');
    }
};
