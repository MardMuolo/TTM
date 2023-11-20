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
        Schema::create('optionttm_jalon', function (Blueprint $table) {
            $table->foreignId('option_ttm_id')->constrained('option_ttms')->onDelete('cascade');
            $table->foreignId('jalon_id')->constrained('jalons')->onDelete('cascade');
            $table->primary(['option_ttm_id', 'jalon_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optionttm_jalon');
    }
};
