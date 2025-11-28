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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('duration')->comment('Duration in minutes');
            $table->boolean('show_results')->default(true);
            $table->boolean('show_result_details')->default(true);
            $table->decimal('correct_score', 5, 2)->default(1.00);
            $table->decimal('wrong_score', 5, 2)->default(0.00);
            $table->decimal('unanswered_score', 5, 2)->default(0.00);
            $table->decimal('max_score', 8, 2)->nullable();
            $table->boolean('use_token')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
