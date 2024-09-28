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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id('product_image_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('image_id');
            $table->foreign('image_id')->references('image_id')->on('images')->onDelete('cascade');
            $table->enum('pin', [1, 0])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
