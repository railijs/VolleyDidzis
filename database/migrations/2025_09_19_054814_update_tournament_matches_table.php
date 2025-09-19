<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tournament_matches', function (Blueprint $table) {
            // Remove old score column
            $table->dropColumn('score');

            // Add new scoring system
            $table->unsignedInteger('team_a_score')->nullable();
            $table->unsignedInteger('team_b_score')->nullable();

            // Winner + Advancement
            $table->string('winner')->nullable(); // "team_a" or "team_b"
            $table->unsignedInteger('round')->default(1);
            $table->unsignedBigInteger('next_match_id')->nullable();

            $table->foreign('next_match_id')->references('id')->on('tournament_matches')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tournament_matches', function (Blueprint $table) {
            // Rollback changes
            $table->dropForeign(['next_match_id']);
            $table->dropColumn(['team_a_score', 'team_b_score', 'winner', 'round', 'next_match_id']);

            $table->string('score')->nullable(); // restore old column
        });
    }
};
