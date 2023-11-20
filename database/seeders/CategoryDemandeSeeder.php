<?php

namespace Database\Seeders;

use App\Models\CategoryDemande;
use Illuminate\Database\Seeder;

class CategoryDemandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
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
}
