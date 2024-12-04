<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->string('old_status')->default('created'); // Add default value
            $table->string('new_status');
            $table->string('changed_by');
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->index(['chat_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_status_logs');
    }
};
