<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_id')->constrained('webhook_configurations')->onDelete('cascade');
            $table->json('payload');
            $table->boolean('success');
            $table->integer('status_code');
            $table->text('response');
            $table->timestamp('attempt_at');
            $table->timestamps();

            $table->index(['webhook_id', 'success']);
            $table->index('attempt_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_logs');
    }
};
