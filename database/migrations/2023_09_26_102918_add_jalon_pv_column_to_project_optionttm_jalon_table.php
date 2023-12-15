<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJalonPvColumnToProjectOptionttmJalonTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_optionttm_jalon', function (Blueprint $table) {
            $table->string('jalonPv')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_optionttm_jalon', function (Blueprint $table) {
            $table->dropColumn('jalonPv');
        });
    }
}
