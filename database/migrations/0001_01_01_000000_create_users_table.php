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
            $table->id(); // big integer PK (best default in Laravel)
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('password'); // 255 by default
            $table->string('reset_token', 255)->nullable()->index();
            $table->dateTime('reset_token_expiry')->nullable();
            $table->rememberToken(); // handy for "remember me" later; safe to keep
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
