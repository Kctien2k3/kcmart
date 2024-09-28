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
        Schema::create('menu', function (Blueprint $table) {
            $table->id('menu_id');
            $table->string('menu_title', 255);
            $table->text('menu_url');
            $table->enum('menu_status', ['published', 'draft'])->default('draft');
            $table->string('creator', 100);
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('page_id')->on('pages')->onDelete('cascade');
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
        Schema::dropIfExists('menu');
    }
};
