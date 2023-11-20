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
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->string('nom_directeur')->nullable();
            $table->text('description');
            $table->string('avis');
            $table->unsignedBigInteger('livrable_id');
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('livrable_id')->references('id')->on('livrables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validations');
    }
};
