<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->enum('sender_type', ['client', 'agent', 'system']);
            $table->string('sender_id');
            $table->text('content');
            $table->string('attachment_path')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['chat_id', 'created_at']);
            $table->index(['sender_type', 'sender_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
};
