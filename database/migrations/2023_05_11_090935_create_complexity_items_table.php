<?php

use App\Models\ComplexityItem;
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
        Schema::create('complexity_items', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $items=[
            'Terminaux',
            'Réseaux',
            'Platformes',
            'Process Metiers & Si',
            'Technologies',
            'Canaux de distribution',
            'Organisation',
            'Integration',
            'Reglementation',
            'International',
            'Partenaires',
            'Contenus'
        ];
        foreach ($items as $item) {
            ComplexityItem::create([
                'name'=>$item
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complexity_items');
    }
};
