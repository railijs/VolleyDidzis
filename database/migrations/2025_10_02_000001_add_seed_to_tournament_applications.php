<?php

// database/migrations/2025_10_02_000001_add_seed_to_tournament_applications.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tournament_applications', function (Blueprint $table) {
            $table->unsignedInteger('seed')->nullable()->after('email');
            // Optional: prevent accidental duplicate team rows per tournament
            $table->unique(['tournament_id', 'team_name']);
        });
    }
    public function down(): void
    {
        Schema::table('tournament_applications', function (Blueprint $table) {
            $table->dropUnique(['tournament_id', 'team_name']);
            $table->dropColumn('seed');
        });
    }
};
