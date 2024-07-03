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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');

            $table->string('year_level');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('address');
            $table->string('contact_number');
            $table->foreignId('course_id'); 
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
