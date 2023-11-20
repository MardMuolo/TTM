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
        Schema::create('project_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId("project_id")->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('role');
            $table->string('status')->default('En Attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_users');
    }
};
