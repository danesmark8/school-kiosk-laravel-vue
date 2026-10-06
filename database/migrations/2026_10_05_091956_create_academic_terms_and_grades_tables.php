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
        Schema::create('academic_terms', function (Blueprint $table) {
            $table->id();
            $table->string('school_year', 20);
            $table->string('semester', 20);
            $table->boolean('is_current')->default(false);
            $table->timestamps();

            $table->unique(['school_year', 'semester']);
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('title', 150);
            $table->decimal('units', 3, 1)->default(3.0);
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('academic_term_id')->constrained('academic_terms')->cascadeOnDelete();
            $table->string('midterm_grade', 10)->nullable();
            $table->string('final_grade', 10);
            $table->string('remarks', 50)->nullable();
            $table->boolean('is_released')->default(false)->index();
            $table->timestamp('released_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'academic_term_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('academic_terms');
    }
};
