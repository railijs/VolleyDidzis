<?php
// database/migrations/2025_10_02_000002_update_tournament_matches_for_bracket_ids.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1) Add / keep columns (idempotent)
        Schema::table('tournament_matches', function (Blueprint $table) {
            if (!Schema::hasColumn('tournament_matches', 'round')) {
                $table->unsignedInteger('round')->default(1)->after('tournament_id');
            }
            if (!Schema::hasColumn('tournament_matches', 'index_in_round')) {
                $table->unsignedInteger('index_in_round')->default(0)->after('round');
            }

            if (!Schema::hasColumn('tournament_matches', 'participant_a_application_id')) {
                $table->unsignedBigInteger('participant_a_application_id')->nullable()->after('index_in_round');
            }
            if (!Schema::hasColumn('tournament_matches', 'participant_b_application_id')) {
                $table->unsignedBigInteger('participant_b_application_id')->nullable()->after('participant_a_application_id');
            }

            if (!Schema::hasColumn('tournament_matches', 'score_a')) {
                $table->unsignedInteger('score_a')->nullable()->after('participant_b_application_id');
            }
            if (!Schema::hasColumn('tournament_matches', 'score_b')) {
                $table->unsignedInteger('score_b')->nullable()->after('score_a');
            }

            if (!Schema::hasColumn('tournament_matches', 'winner_slot')) {
                $table->string('winner_slot', 1)->nullable()->after('score_b'); // 'A' | 'B' | null
            }

            if (!Schema::hasColumn('tournament_matches', 'next_match_id')) {
                $table->unsignedBigInteger('next_match_id')->nullable()->after('winner_slot');
            }
            if (!Schema::hasColumn('tournament_matches', 'next_slot')) {
                $table->string('next_slot', 1)->nullable()->after('next_match_id'); // 'A' | 'B' | null
            }

            if (!Schema::hasColumn('tournament_matches', 'status')) {
                $table->string('status', 20)->default('pending')->after('next_slot'); // pending|in_progress|completed
            }
            if (!Schema::hasColumn('tournament_matches', 'scheduled_at')) {
                $table->timestamp('scheduled_at')->nullable()->after('status');
            }
        });

        // 2) Copy legacy data → new fields (guarded)
        if (Schema::hasColumn('tournament_matches', 'team_a_score')) {
            DB::statement('UPDATE tournament_matches SET score_a = team_a_score WHERE score_a IS NULL');
        }
        if (Schema::hasColumn('tournament_matches', 'team_b_score')) {
            DB::statement('UPDATE tournament_matches SET score_b = team_b_score WHERE score_b IS NULL');
        }
        if (Schema::hasColumn('tournament_matches', 'winner') && Schema::hasColumn('tournament_matches', 'winner_slot')) {
            DB::statement("UPDATE tournament_matches
                           SET winner_slot = CASE winner WHEN 'team_a' THEN 'A' WHEN 'team_b' THEN 'B' ELSE NULL END
                           WHERE winner_slot IS NULL");
        }
        DB::statement("UPDATE tournament_matches SET round = COALESCE(round, 1)");

        // 3) Foreign keys — ADD ONLY IF the FK name does not already exist
        if (
            Schema::hasColumn('tournament_matches', 'participant_a_application_id') &&
            !$this->fkExists('tournament_matches', 'tm_fk_a_app')
        ) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->foreign('participant_a_application_id', 'tm_fk_a_app')
                    ->references('id')->on('tournament_applications')->nullOnDelete();
            });
        }
        if (
            Schema::hasColumn('tournament_matches', 'participant_b_application_id') &&
            !$this->fkExists('tournament_matches', 'tm_fk_b_app')
        ) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->foreign('participant_b_application_id', 'tm_fk_b_app')
                    ->references('id')->on('tournament_applications')->nullOnDelete();
            });
        }
        if (
            Schema::hasColumn('tournament_matches', 'next_match_id') &&
            !$this->fkExists('tournament_matches', 'tm_fk_next_match')
        ) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->foreign('next_match_id', 'tm_fk_next_match')
                    ->references('id')->on('tournament_matches')->nullOnDelete();
            });
        }

        // 4) Normalize index_in_round to be unique per (tournament_id, round)
        DB::statement('SET @prev_t := NULL, @prev_r := NULL, @rn := -1');
        DB::statement("
            UPDATE tournament_matches tm
            JOIN (
                SELECT id, tournament_id, round,
                       IF(@prev_t = tournament_id AND @prev_r = round, @rn := @rn + 1, @rn := 0) AS rn,
                       (@prev_t := tournament_id) AS _t,
                       (@prev_r := round) AS _r
                FROM tournament_matches
                ORDER BY tournament_id, round, id
            ) x ON x.id = tm.id
            SET tm.index_in_round = x.rn
        ");

        // 5) Indexes / unique keys (add only if missing)
        if (!$this->indexExists('tournament_matches', 'tm_unique_round_index')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->unique(['tournament_id', 'round', 'index_in_round'], 'tm_unique_round_index');
            });
        }
        if (!$this->indexExists('tournament_matches', 'tournament_matches_tournament_id_round_index')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->index(['tournament_id', 'round']);
            });
        }

        // 6) Drop legacy columns after copying values
        Schema::table('tournament_matches', function (Blueprint $table) {
            if (Schema::hasColumn('tournament_matches', 'team_a')) {
                $table->dropColumn('team_a');
            }
            if (Schema::hasColumn('tournament_matches', 'team_b')) {
                $table->dropColumn('team_b');
            }
            if (Schema::hasColumn('tournament_matches', 'team_a_score')) {
                $table->dropColumn('team_a_score');
            }
            if (Schema::hasColumn('tournament_matches', 'team_b_score')) {
                $table->dropColumn('team_b_score');
            }
            if (Schema::hasColumn('tournament_matches', 'winner')) {
                $table->dropColumn('winner');
            }
        });
    }

    public function down(): void
    {
        // Drop FKs if present (names we used)
        if ($this->fkExists('tournament_matches', 'tm_fk_a_app')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->dropForeign('tm_fk_a_app');
            });
        }
        if ($this->fkExists('tournament_matches', 'tm_fk_b_app')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->dropForeign('tm_fk_b_app');
            });
        }
        if ($this->fkExists('tournament_matches', 'tm_fk_next_match')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->dropForeign('tm_fk_next_match');
            });
        }

        // Drop indexes if present
        if ($this->indexExists('tournament_matches', 'tm_unique_round_index')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->dropUnique('tm_unique_round_index');
            });
        }
        if ($this->indexExists('tournament_matches', 'tournament_matches_tournament_id_round_index')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->dropIndex('tournament_matches_tournament_id_round_index');
            });
        }

        // Drop our added columns (except round/next_match_id, which may have preexisted in your schema)
        Schema::table('tournament_matches', function (Blueprint $table) {
            foreach (
                [
                    'index_in_round',
                    'participant_a_application_id',
                    'participant_b_application_id',
                    'score_a',
                    'score_b',
                    'winner_slot',
                    'next_slot',
                    'status',
                    'scheduled_at'
                ] as $col
            ) {
                if (Schema::hasColumn('tournament_matches', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    /** INFORMATION_SCHEMA helpers (no doctrine/dbal needed) */
    private function indexExists(string $table, string $indexName): bool
    {
        $row = DB::selectOne(
            'SELECT COUNT(*) AS c
             FROM INFORMATION_SCHEMA.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND INDEX_NAME = ?',
            [$table, $indexName]
        );
        return (int)($row->c ?? 0) > 0;
    }

    private function fkExists(string $table, string $constraintName): bool
    {
        $row = DB::selectOne(
            'SELECT COUNT(*) AS c
             FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?',
            [$table, $constraintName]
        );
        return (int)($row->c ?? 0) > 0;
    }
};
