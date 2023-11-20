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
        Schema::create('historique_date', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_optionttm_jalon_id');
            $table->date('date_initiale');
            $table->date('date_repouser');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_optionttm_jalon_id')->references('id')->on('project_optionttm_jalon')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_date');
    }
};
