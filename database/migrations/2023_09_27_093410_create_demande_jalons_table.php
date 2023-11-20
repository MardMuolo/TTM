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
        Schema::create('demande_jalons', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('pathTask');
            $table->unsignedBigInteger('contributeur'); // Champs pour la clé étrangère
            $table->string('deadLine');
            $table->date('date_prevue');
            $table->date('date_reelle')->nullable();
            $table->string('status')->default('Attendu');
            $table->foreignId('demande_id')->constrained('demandes')->onDelete('cascade');
            $table->unsignedBigInteger('project_optionttm_jalon_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('contributeur')->references('id')->on('users'); // Relation avec la table users
            $table->foreign('project_optionttm_jalon_id')->references('id')->on('project_optionttm_jalon')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_jalons');
    }
};
