<?php

namespace Database\Seeders;

use App\Models\ComplexityItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplexityItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
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
}
