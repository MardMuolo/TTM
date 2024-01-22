<?php

use App\Models\Jalon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jalons', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->softDeletes();
            $table->timestamps();
        });

        Jalon::create(['designation' => 'T-1']);
        Jalon::create(['designation' => 'T0']);
        Jalon::create(['designation' => 'T1']);
        Jalon::create(['designation' => 'T2']);
        Jalon::create(['designation' => 'T3']);
        Jalon::create(['designation' => 'T4']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalons');
    }
};
