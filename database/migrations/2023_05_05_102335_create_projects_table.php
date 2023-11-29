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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->string('target');
            $table->string('type');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->integer('score');
            $table->integer('coast');
            $table->string('projectOwner');
            $table->string('sponsor');
            $table->string('status')->default(env('projetSoumis'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
