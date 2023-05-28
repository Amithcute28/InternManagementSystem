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
        Schema::create('schoolbseds', function (Blueprint $table) {
            $table->id();
            $table->string('namebsed');
            $table->string('address');
            $table->string('school_logo');
            $table->string('required_programs')->nullable();
            $table->text('skills')->nullable();
            $table->text('required_academic_performance')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schoolbseds');
    }
};