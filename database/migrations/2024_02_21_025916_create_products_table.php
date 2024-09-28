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
            $table->id('product_id');
            $table->string('product_code', 120);
            $table->string('product_title', 120);
            $table->string('product_slug', 120);
            $table->string('product_desc', 255);
            $table->text('product_details');
            $table->Integer('product_price');
            $table->Integer('product_oldPrice');
            $table->Integer('stock_quantity');
            $table->tinyInteger('is_featured');
            $table->enum('product_status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('product_categories')->onDelete('cascade');
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
