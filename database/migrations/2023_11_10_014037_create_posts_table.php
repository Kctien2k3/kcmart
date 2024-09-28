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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->string('post_title', 120);
            $table->string('post_slug', 120);
            $table->string('post_excerpt', 120);
            $table->text('post_content');
            $table->enum('post_status', ['draft','published']);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('post_categories')->onDelete('cascade');
            $table->unsignedBigInteger('image_id');
            $table->foreign('image_id')->references('image_id')->on('images')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
