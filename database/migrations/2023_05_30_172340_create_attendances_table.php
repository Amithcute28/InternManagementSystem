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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->Date('date');
            $table->enum('status', ['on_time', 'late', 'missed'])->default('missed');
            $table->time('sign_in_time')->nullable();
            $table->time('sign_off_time')->nullable();
            $table->string('notes')->nullable();
            $table->string('journal')->nullable();
            $table->boolean('is_manually_filled')->default(false); // when employees take attendance themselves
            $table->unique(['student_id', 'date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.php art
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
