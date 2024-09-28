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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id('slider_id');
            $table->unsignedBigInteger('image_id');
            $table->foreign('image_id')->references('image_id')->on('images')->onDelete('cascade');
            $table->string('slider_title', 120);
            $table->string('slider_desc', 255);
            $table->text('slider_url');
            $table->tinyInteger('display_order');
            $table->enum('slider_status', ['published', 'draft'])->default('draft');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
