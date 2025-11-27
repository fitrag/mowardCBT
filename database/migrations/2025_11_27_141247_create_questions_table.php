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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->text('question');
            $table->tinyInteger('question_type')->comment('1=Multiple Choice, 2=Essay, 3=Short Answer');
            $table->tinyInteger('difficulty_level')->comment('1=Easy, 2=Medium, 3=Hard');
            $table->boolean('status')->default(true)->comment('Active/Inactive');
            $table->string('audio_file')->nullable();
            $table->integer('timer')->nullable()->comment('Timer in seconds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
