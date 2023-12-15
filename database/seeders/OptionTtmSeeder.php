<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OptionTtm;
use App\Models\Jalon;

class OptionTtmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $option1 = OptionTtm::create([
            'nom' => 'Super Fast Track',
            'minComplexite' => 0,
            'maxComplexite' => 15,
        ]);
        $option2 = OptionTtm::create([
            'nom' => 'Fast Track',
            'minComplexite' => 15,
            'maxComplexite' => 30,
        ]);
        $option3 = OptionTtm::create([
            'nom' => 'Full Track',
            'minComplexite' => 30,
            'maxComplexite' => 30000,
        ]);

        // Attache des jalons aux options TTM
        $jalonIds = Jalon::pluck('id')->toArray();

        // Option 1 est attachée à 6 jalons
        $option1->jalons()->attach(array_slice($jalonIds, 0, 6));

        // Option 2 est attachée aux jalons 1, 2 5,6
        $option2->jalons()->attach([1, 2, 5,6]);

        // Option 3 est attachée aux jalons 2, 5 et 6
        $option3->jalons()->attach([2, 5, 6]);
    }
}