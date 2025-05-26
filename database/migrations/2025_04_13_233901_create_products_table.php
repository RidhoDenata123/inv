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
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id', 30)->primary(); // max 30 karakter, sesuaikan kebutuhan kode produk
            $table->string('product_name', 100);         // max 100 karakter
            $table->string('product_category', 30);      // max 30 karakter (ID kategori)
            $table->text('product_description')->nullable();
            $table->integer('product_qty')->default(0);
            $table->bigInteger('purchase_price');
            $table->bigInteger('selling_price');
            $table->string('product_unit', 20);          // max 20 karakter (ID/unit)
            $table->string('product_img', 255)->nullable(); // path/file name, nullable
            $table->string('supplier_id', 30);           // max 30 karakter (ID supplier)
            $table->string('product_status', 20);        // max 20 karakter (misal: active/inactive)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};