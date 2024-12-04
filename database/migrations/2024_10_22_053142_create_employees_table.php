<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('marital_status', ['unmarried', 'married', 'divorced']);
            $table->string('blood_group')->nullable();
            $table->string('disability')->nullable();
            $table->string('city');
            $table->string('country');

            // Contact Information
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile');
            $table->string('alternate_number')->nullable();
            $table->text('address');

            // Professional Information
            $table->foreignId('department_id');
            $table->string('designation');
            $table->string('reporting_manager');
            $table->time('shift_start_time');
            $table->time('shift_end_time');
            $table->boolean('profile_status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
