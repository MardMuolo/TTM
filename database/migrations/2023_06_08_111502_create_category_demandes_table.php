<?php

use App\Models\CategoryDemande;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_demandes', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->timestamps();
        });

        $categories = [
            'Introduction générale au projet',
            'Eléments du projet',
            'Offre et service',
            'Eléments financiers',
            'Mise en œuvre tech SI-process',
            'Juridique, Réglementaire, RSE',
            'Expérience client',
            'Achats',
        ];

        foreach ($categories as $category) {
            CategoryDemande::create([
                'title' => $category,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_demandes');
    }
};
