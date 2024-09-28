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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_code', 100);
            $table->integer('product_quantity');
            $table->integer('total_amount');
            $table->timestamp('order_date')->nullable();
            $table->enum('payment_method', ['COD', 'Online Payment'])->default('COD');
            $table->string('shipping_address', 255)->nullable();
            $table->string('note', 255)->nullable();
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'canceled'])->default('pending');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
