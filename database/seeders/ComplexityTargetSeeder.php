<?php

namespace Database\Seeders;

use App\Models\ComplexityItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplexityTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $targets=[
        //     "Terminaux"=>[
        //         "Inconnu",
        //         "Aucun impact sur les terminaux",
        //         "Terminaux disponibles avec provisionning",
        //         "Téléchargement de nouveaux logiciels ou ajout sur terminaux existants",
        //         "Déploiement de nouveau terminaux",
        //         "Conception & Deploiement de nouveaux terminaux ou MAJ Terminaux"
        //     ],
        //     "Réseaux"=>[
        //         "Inconnu",
        //         "Aucun impact sur les Réseau",
        //         "Modification de paramètre du réseau",
        //         "Modification des paramtres du réseau nécessitant des tests de compatibilité entre les CPE et les équipements réseau",
        //         "Déploiement d'équipement Réseau Coeur ou nouvelle technologie d'accès sur équipements existants",
        //         "Deploiement Accs Réseau"
        //     ],
        //     "Platformes"=>[
        //         "Inconnu",
        //         "Pas de nouvelles plate-formes",
        //         "Modification de paramtres sur plate-formes existants",
        //         "Mise à jour du matériel/logiciel des plate-formes existant",
        //         "Evolution de l'architecture",
        //         "Deploiement Nouvelle Plateforme"
        //     ],
        //     "Process Metiers & Si"=>[
        //         "Inconnu",
        //         "Aucune modification sur les Process Metier & SI",
        //         "Modification de paramètres SI avec impact mineur sur le processus",
        //         "Modification majeure sur les applications SI aqvec impact significatif sur les processus",
        //         "Swap d'application SI avec impact majeur sur les process"
        //     ],
        //     "Technologies"=>[
        //         "Inconnu",
        //         "Techologies existantes ou standardisées",
        //         "Solution Prioritaire non imposé par le roupe Orange",
        //         "Solution Prioritaire, imposé du groupe Orange",
        //         "Solution du Groupe Orange"
        //     ],
        //     "Canaux de distribution"=>[
        //         "Inconnu",
        //         "Pas d'outils specifique pour la vente",
        //         "Nouvelle Option necessitant formation ou information de la FDV",
        //         "Nouveau Produit ayant un impact sur l'organisation de la FDV"
        //     ],
        //     "Organisation"=>[
        //         "Inconnu",
        //         "Une seule Direction",
        //         "Multiples Directions"
        //     ],
        //     "Integration"=>[
        //         "Inconnu",
        //         "Developpement et integration sur une seue plateforme",
        //         "Developpement et integrationn sur plusieurs plateformes",
        //         "Integration (applications, plateformes de services, middleware)"
        //     ],
        //     "Reglementation"=>[
        //         "Inconnu",
        //         "Pas d'impact Reglementaire",
        //         "Impacts Reglementaire"
        //     ],
        //     "International"=>[
        //         "Inconnu",
        //         "Lancement Pays",
        //         "Lancement Multi Pays",
        //     ],
        //     "Partenaires"=>[
        //         "Inconnu",
        //         "Aucun partenaire",
        //         "Partenaire unique",
        //         "Partenaire Multiples"
        //     ],
        //     "Contenus"=>[
        //         "Inconnu",
        //         "Aucun contenu",
        //         "Contenu intégré dans le produit/service"
        //     ]
        // ];
        $targets = [
            "Terminaux" => [
                "Inconnu",
                "Aucun impact sur les terminaux",
                "Terminaux disponibles avec provisionning",
                "Téléchargement de nouveaux logiciels ou ajout sur terminaux existants",
                "Déploiement de nouveau terminaux",
                "Conception & Deploiement de nouveaux terminaux ou MAJ Terminaux"
            ],
            "Réseaux" => [
                "Inconnu",
                "Aucun impact sur les Réseau",
                "Modification de paramètre du réseau",
                "Modification des paramtres du réseau nécessitant des tests de compatibilité entre les CPE et les équipements réseau",
                "Déploiement d'équipement Réseau Coeur ou nouvelle technologie d'accès sur équipements existants",
                "Deploiement Accs Réseau"
            ],
            "Platformes" => [
                "Inconnu",
                "Pas de nouvelles plate-formes",
                "Modification de paramtres sur plate-formes existants",
                "Mise à jour du matériel/logiciel des plate-formes existant",
                "Evolution de l'architecture",
                "Deploiement Nouvelle Plateforme"
            ],
            "Process Metiers & Si" => [
                "Inconnu",
                "Aucune modification sur les Process Metier & SI",
                "Modification de paramètres SI avec impact mineur sur le processus",
                "Modification majeure sur les applications SI aqvec impact significatif sur les processus",
                "Swap d'application SI avec impact majeur sur les process"
            ],
            "Technologies" => [
                "Inconnu",
                "Techologies existantes ou standardisées",
                "Solution Prioritaire non imposé par le roupe Orange",
                "Solution Prioritaire, imposé du groupe Orange",
                "Solution du Groupe Orange"
            ],
            "Canaux de distribution" => [
                "Inconnu",
                "Pas d'outils specifique pour la vente",
                "Nouvelle Option necessitant formation ou information de la FDV",
                "Nouveau Produit ayant un impact sur l'organisation de la FDV"
            ],
            "Organisation" => [
                "Inconnu",
                "Une seule Direction",
                "Multiples Directions"
            ],
            "Integration" => [
                "Inconnu",
                "Developpement et integration sur une seue plateforme",
                "Developpement et integrationn sur plusieurs plateformes",
                "Integration (applications, plateformes de services, middleware)"
            ],
            "Reglementation" => [
                "Inconnu",
                "Pas d'impact Reglementaire",
                "Impacts Reglementaire"
            ],
            "International" => [
                "Inconnu",
                "Lancement Pays",
                "Lancement Multi Pays",
            ],
            "Partenaires" => [
                "Inconnu",
                "Aucun partenaire",
                "Partenaire unique",
                "Partenaire Multiples"
            ],
            "Contenus" => [
                "Inconnu",
                "Aucun contenu",
                "Contenu intégré dans le produit/service"
            ]
        ];
        $complexityItems = ComplexityItem::all();
        foreach ($complexityItems as $item) {
            foreach($targets[$item->name] as $index=>$target){
                $item->complexityTargets()->create([
                    'name'=>$target,
                    'value'=>$index,
                ]);
            }

        }
    }
}
