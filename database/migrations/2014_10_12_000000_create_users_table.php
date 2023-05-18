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
            $table->string('password');
            $table->string('year_level');
            $table->string('full_name');
            $table->string('academic_performance')->nullable();
            $table->string('program')->nullable();
            $table->string('skills')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('birthday');
            $table->string('gender');
            $table->string('relationship');
            $table->string('nationality');
            $table->string('contact_number');
            $table->string('home_address');
            $table->string('zip_code');
            $table->string('guardian_name');
            $table->string('guardian_contact');
            $table->boolean('is_admin')->default(0);
            $table->boolean('approved')->default(false);
            $table->boolean('recommended')->default(false);
            $table->boolean('choosen_institution')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
