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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name', 60);
            $table->string('category_slug', 60);
            $table->text('category_desc');
            $table->unsignedBigInteger('user_id');
            $table->enum('category_status', ['published', 'draft'])->default('draft');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('parent_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
