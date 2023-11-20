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
        Schema::create('direction_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->OnDelete('cascade');
            $table->foreignId('direction_id')->constrained()->onDelete('cascade');
            $table->boolean('is_director');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direction_users');
    }
};
