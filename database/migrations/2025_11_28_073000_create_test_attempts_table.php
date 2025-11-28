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
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('submitted_at')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->json('answers')->nullable();
            $table->enum('status', ['in_progress', 'submitted', 'graded'])->default('in_progress');
            $table->timestamps();

            // Indexes for better query performance
            $table->index(['user_id', 'test_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};
