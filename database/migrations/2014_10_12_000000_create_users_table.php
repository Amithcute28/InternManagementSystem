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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('profile')->nullable();
            $table->string('password');
            $table->string('full_name');
            $table->string('academic_performance')->nullable();
            
            // Change the 'program' column to use the json type
            $table->string('program')->nullable(); 
            $table->string('school_name')->nullable(); 
            $table->string('school_code')->nullable()->unique();
            $table->string('ste_shift')->nullable();  
            $table->string('skills')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('relationship')->nullable();
            $table->string('nationality')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('home_address')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->string('student_school_name')->nullable();
            $table->string('student_school_code')->nullable();
            $table->string('student_shift')->nullable();
            $table->boolean('is_ste')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->boolean('approved')->default(false);
            $table->boolean('new_intern')->default(false);
            $table->boolean('choosen_institution')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('applications')->default(false);
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
