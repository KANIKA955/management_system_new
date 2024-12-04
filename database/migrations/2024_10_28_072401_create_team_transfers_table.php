<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('from_team_id')->nullable()->constrained('teams');
            $table->foreignId('to_team_id')->constrained('teams');
            $table->enum('previous_position', ['manager', 'team_lead', 'executive']);
            $table->enum('new_position', ['manager', 'team_lead', 'executive']);
            $table->foreignId('transferred_by')->constrained('users');
            $table->text('reason')->nullable();
            $table->date('transfer_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_transfers');
    }
};
