<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mail_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('mail_id');

            $table->enum('folder', ['inbox', 'sent', 'both'])->default('inbox'); // which box it belongs to
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_deleted')->default(false);

            $table->timestamps();

            // relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mail_id')->references('id')->on('mails')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_user');
    }
};
