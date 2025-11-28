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
        Schema::table('test_subjects', function (Blueprint $table) {
            $table->tinyInteger('question_type')->nullable()->comment('1=Multiple Choice, 2=Essay, 3=Short Answer');
            $table->tinyInteger('difficulty_level')->nullable()->comment('1=Easy, 2=Medium, 3=Hard');
            $table->integer('question_count')->default(10)->comment('Number of questions to display');
            $table->integer('options_count')->nullable()->comment('Number of answer options (for multiple choice)');
            $table->boolean('randomize_questions')->default(false)->comment('Shuffle questions order');
            $table->boolean('randomize_answers')->default(false)->comment('Shuffle answer options order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_subjects', function (Blueprint $table) {
            $table->dropColumn([
                'question_type',
                'difficulty_level',
                'question_count',
                'options_count',
                'randomize_questions',
                'randomize_answers',
            ]);
        });
    }
};
