<?php

namespace Database\Seeders;

use App\Models\CategoryDemande;
use App\Models\Demande;
use App\Models\Jalon;
use Illuminate\Database\Seeder;

class AllDemandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Demande::query()->delete();
        $csvData = fopen(public_path('demandes.csv'), 'r');
        $transRow = true;

        while (($data = fgetcsv($csvData, 555, ';')) !== false) {
            if (!$transRow && count($data) >= 3) {
                $jalon = Jalon::where('id', $data[2])->first();
                $category_demande = CategoryDemande::where('id', $data[1])->first();

                if ($jalon && $category_demande) {
                    $demande = new Demande();
                    $demande->title = $data[0];
                    $demande->jalon_id = $jalon->id;
                    $demande->category_demande_id = $category_demande->id;
                    $demande->save();
                }
            }
            $transRow = false;
        }
        fclose($csvData);
    }
}
