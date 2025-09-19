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
        $table->string('status')->default('pending'); // default is pending
    });
}

public function down(): void
{
    Schema::table('tournaments', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
