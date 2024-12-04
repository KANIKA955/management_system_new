<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Foreign key to employees table
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade'); // Foreign key to teams table
            $table->enum('role', ['manager', 'team_lead', 'executive'])->default('executive'); // Role of the employee in the team
            $table->timestamp('joined_at')->default(DB::raw('CURRENT_TIMESTAMP')); // When the employee joined the team
            $table->timestamp('left_at')->nullable(); // When the employee left the team (null if still part of the team)
            $table->text('remarks')->nullable(); // Additional notes about the team history
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_histories');
    }
};
