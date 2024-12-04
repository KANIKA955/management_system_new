<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('webhook_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('webhook_url');
            $table->json('events_config');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['client_id', 'webhook_url']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_configurations');
    }
};
