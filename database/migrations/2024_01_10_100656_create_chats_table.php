<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('chat_id')->unique();
            $table->string('client_id');
            $table->foreignId('department_id')->constrained();
            $table->enum('status', ['pending', 'active', 'closed'])->default('pending');
            $table->boolean('is_high_priority')->default(false);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'status']);
            $table->index(['department_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
};
