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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->nullable();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('fullname', 100)->nullable();
            $table->enum('status', ['actived', 'inactived', 'banned'])->default('actived');
            // $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_login_time')->nullable();
            $table->string('last_login_ip', 45)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
