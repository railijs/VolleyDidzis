<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tournaments', function (Blueprint $table) {
        $table->unsignedBigInteger('creator_id')->nullable()->after('status');
        $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('tournaments', function (Blueprint $table) {
        $table->dropForeign(['creator_id']);
        $table->dropColumn('creator_id');
    });
}

};
