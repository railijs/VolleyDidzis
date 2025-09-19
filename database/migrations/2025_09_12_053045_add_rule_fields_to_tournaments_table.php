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
        Schema::table('tournaments', function (Blueprint $table) {
            // team & composition rules
            $table->integer('team_size')->nullable()->after('max_teams');
            $table->string('gender_type')->default('men')->after('team_size'); // men | women | mix
            $table->integer('min_boys')->nullable()->after('gender_type');
            $table->integer('min_girls')->nullable()->after('min_boys');

            // age rules and extras
            $table->integer('min_age')->nullable()->after('min_girls');
            $table->integer('max_age')->nullable()->after('min_age');
            $table->text('recommendations')->nullable()->after('max_age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn([
                'team_size',
                'gender_type',
                'min_boys',
                'min_girls',
                'min_age',
                'max_age',
                'recommendations',
            ]);
        });
    }
};
