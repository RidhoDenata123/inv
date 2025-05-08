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
        Schema::create('stock_change_logs', function (Blueprint $table) {
            $table->string('stock_change_log_id')->primary();
            $table->string('stock_change_type');
            $table->string('product_id');
            $table->string('reference_id');
            $table->integer('qty_before')->default(0);
            $table->integer('qty_changed')->default(0);
            $table->integer('qty_after')->default(0);
            $table->string('changed_at')->nullable();
            $table->string('changed_by')->nullable();
            $table->string('change_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_change_logs');
    }
};
