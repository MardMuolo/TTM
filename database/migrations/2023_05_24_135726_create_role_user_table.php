<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->onDelete('cascade');
            $table->foreignId('user_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->id();
            $table->dropForeign('role_user_role_id_foreing');
            $table->dropForeign('role_user_user_id_foreing');
        });
    }
};
