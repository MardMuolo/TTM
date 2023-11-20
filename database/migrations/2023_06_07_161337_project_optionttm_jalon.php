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
        Schema::create('project_optionttm_jalon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('option_ttm_id');
            $table->unsignedBigInteger('jalon_id');
            $table->date('debutDate')->nullable();
            $table->date('echeance')->nullable();
            $table->string('status')->default('en attente');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('option_ttm_id')->references('id')->on('option_ttms')->onDelete('cascade');
            $table->foreign('jalon_id')->references('id')->on('jalons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_optionttm_jalon');
    }
};
