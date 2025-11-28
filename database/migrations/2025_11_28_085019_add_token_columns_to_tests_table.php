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
        Schema::table('tests', function (Blueprint $table) {
            $table->string('token')->nullable()->after('use_token');
            $table->timestamp('token_expires_at')->nullable()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn(['token', 'token_expires_at']);
        });
    }
};
