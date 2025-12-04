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
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->dropColumn('elapsed_time_seconds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->integer('elapsed_time_seconds')->default(0)->after('duration_seconds');
        });
    }
};
