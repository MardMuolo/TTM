<?php

namespace App\Http\Controllers;

use App\Models\ProjectOptionttmJalon;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Project::all();
        $alljalon = ProjectOptionttmJalon::all()->count();
        $jalonEnCours = ProjectOptionttmJalon::where('status', env('jalonEnCours'))->count();
        $jalonEnAttente = ProjectOptionttmJalon::where('status', env('jalonEnAttente'))->count();
        $jalonCloturer = ProjectOptionttmJalon::where('status', env('jalonCloturer'))->count();
        $jalonEnRetard=[];
        $projectJalon=ProjectOptionttmJalon::get("echeance");
        // var_dump(count($projectJalon));

        foreach($projectJalon as $jalon){
            $echeance=Carbon::parse($jalon->echeance);
            if($echeance->isPast()){
                $jalonEnRetard[]=$echeance;
            }
        }
        // var_dump(count($jalonEnRetard));
        // dd(($jalonEnCours * 100) / $alljalon);

        // Tableaux pour stocker le nombre de projets soumis, en cours et terminés par mois
        $submittedProjectsPerMonth = [];
        $ongoingProjectsPerMonth = [];
        $completedProjectsPerMonth = [];

        // Créer un tableau avec tous les mois de l'année

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = 0;
        }
        // dd($months);
        // Parcourir les projets et compter le nombre de projets par mois pour chaque statut
        foreach ($projects as $project) {
            // Extraire le mois de la date de début et de fin du projet
            $startMonth = Carbon::parse($project->startDate)->month;
            $endMonth = Carbon::parse($project->endDate)->month;

            // dd($endMonth);
            // Incrémenter le nombre de projets pour les mois correspondants et les statuts correspondants
            for ($month = $startMonth; $month <= $startMonth; $month++) {
                $ongoing = 0;
                $ongoing++;
                if ($project->status === env('projetSoumis')) {
                    $submittedProjectsPerMonth[$month] = $ongoing;
                } elseif ($project->status === env('projetenCours')) {
                    $submittedProjectsPerMonth[$month] = $ongoing;
                    $ongoingProjectsPerMonth[$month] = $ongoing;
                }
            }
            for ($month = $endMonth; $month <= $endMonth; $month++) {
                $ongoing = 0;
                $ongoing++;
                if ($project->status === env('projetTerminer')) {

                    $submittedProjectsPerMonth[$month - 1] = $ongoing;
                    $completedProjectsPerMonth[$month] = $ongoing;
                }
            }


        }
        // dd($ongoing);
        // dd($ongoingProjectsPerMonth);

        // Ajouter les valeurs au tableau des projets par mois pour chaque statut
        $submittedProjects = [];
        $ongoingProjects = [];
        $completedProjects = [];

        foreach ($months as $monthIndex => $numberOfProjects) {
            // dd( $ongoingProjectsPerMonth[$monthIndex]);
            $submittedProjects[] = $submittedProjectsPerMonth[$monthIndex] ?? 0;
            $ongoingProjects[] = $ongoingProjectsPerMonth[$monthIndex] ?? 0;
            $completedProjects[] = $completedProjectsPerMonth[$monthIndex] ?? 0;
        }
        // dd($ongoingProjects, $submittedProjects, $completedProjects);
        // Labels pour l'axe des X (mois)
        $labels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        $projetSoumis = Project::where('status', env('projetSoumis'))->get()->count();
        $projetEncours = Project::where('status', env('projetenCours'))->get()->count();
        $projetFinis = Project::where('status', env('projetTerminer'))->get()->count();
        $projets = Project::all()->count();
        // // $livrables=


        // $projets = DB::table('projects')
        //     ->join('project_users', 'projects.id','=','project_users.project_id')
        //     ->join('users', 'users.id','=','project_users.user_id')
        //     ->join('direction_users', 'users.id', '=','direction_users.user_id')
        //     ->join('directions', 'directions.id', '=','direction_users.user_id')
        //     ->groupBy('directions.name')
        //     ->select(DB::raw('count(*) as nb_projet, directions.name'))


        //     ->get() ;

        // die($projets);


        $directions = DB::table('directions')
            ->select(
                'id',
                'name',
                DB::raw("(SELECT COUNT(pu.project_id) FROM direction_users du, users u,
                     project_users pu WHERE directions.id = du.direction_id AND du.user_id = u.id AND u.id = pu.user_id AND pu.role = 'projectOwner' GROUP BY du.direction_id) AS nb_projet"),
                DB::raw("(SELECT COUNT(pu.project_id) FROM direction_users du, users u, project_users pu, projects p WHERE directions.id = du.direction_id 
                     AND du.user_id = u.id AND u.id = pu.user_id AND pu.project_id = p.id AND pu.role = 'projectOwner' AND p.status = 'Terminé' GROUP BY du.direction_id) AS nb_projetFinis")
            )->get()
        ;

        // die($directions);

        $users = User::all();
        $annee = date('Y');
        $annePrec = $annee - 1;

        $janv = Project::whereBetween('endDate', [$annee . '-01-01', $annee . '-01-30'])->get()->count();
        $fev = Project::whereBetween('enDdate', [$annee . '-02-01', $annee . '-02-30'])->get()->count();
        $mars = Project::whereBetween('endDate', [$annee . '-03-01', $annee . '-03-30'])->get()->count();
        $avril = Project::whereBetween('endDate', [$annee . '-04-01', $annee . '-04-30'])->get()->count();
        $mai = Project::whereBetween('endDate', [$annee . '-05-01', $annee . '-05-30'])->get()->count();
        $juin = Project::whereBetween('endDate', [$annee . '-06-01', $annee . '-06-30'])->get()->count();
        $juillet = Project::whereBetween('endDate', [$annee . '-07-01', $annee . '-07-30'])->get()->count();
        $aout = Project::whereBetween('endDate', [$annee . '-08-01', $annee . '-08-30'])->get()->count();
        $sep = Project::whereBetween('endDate', [$annee . '-09-01', $annee . '-09-30'])->get()->count();
        $oct = Project::whereBetween('endDate', [$annee . '-10-01', $annee . '-10-30'])->get()->count();
        $nov = Project::whereBetween('endDate', [$annee . '-11-01', $annee . '-11-30'])->get()->count();
        $dec = Project::whereBetween('endDate', [$annee . '-12-01', $annee . '-12-30'])->get()->count();

        $janv2 = Project::whereBetween('endDate', [$annePrec . '-01-01', $annePrec . '-01-30'])->get()->count();
        $fev2 = Project::whereBetween('enDdate', [$annePrec . '-02-01', $annePrec . '-02-30'])->get()->count();
        $mars2 = Project::whereBetween('endDate', [$annePrec . '-03-01', $annePrec . '-03-30'])->get()->count();
        $avril2 = Project::whereBetween('endDate', [$annee . '-04-01', $annePrec . '-04-30'])->get()->count();
        $mai2 = Project::whereBetween('endDate', [$annePrec . '-05-01', $annePrec . '-05-30'])->get()->count();
        $juin2 = Project::whereBetween('endDate', [$annePrec . '-06-01', $annePrec . '-06-30'])->get()->count();
        $juillet2 = Project::whereBetween('endDate', [$annePrec . '-07-01', $annePrec . '-07-30'])->get()->count();
        $aout2 = Project::whereBetween('endDate', [$annePrec . '-08-01', $annePrec . '-08-30'])->get()->count();
        $sep2 = Project::whereBetween('endDate', [$annePrec . '-09-01', $annePrec . '-09-30'])->get()->count();
        $oct2 = Project::whereBetween('endDate', [$annePrec . '-10-01', $annePrec . '-10-30'])->get()->count();
        $nov2 = Project::whereBetween('endDate', [$annePrec . '-11-01', $annePrec . '-11-30'])->get()->count();
        $dec2 = Project::whereBetween('endDate', [$annePrec . '-12-01', $annePrec . '-12-30'])->get()->count();



        $datadonut = json_encode([$projetSoumis, $projetEncours, $projetFinis]);

        $data = json_encode([$janv, 6, $mars, 10, $mai, $juin, 5, $aout, $sep, $oct, $nov, 10]);

        $data2 = json_encode([15, $fev2, 8, 10, $mai2, $juin2, 20, $aout2, $sep2, $oct2, 15, $dec2]);

        $projetsEncours = Project::whereBetween('endDate', [$annee . '-01-01', $annee . '-12-31'])->get()->count();
        $projetsPrec = Project::whereBetween('endDate', [$annePrec . '-01-01', $annePrec . '-12-31'])->get()->count();


        return view(
            'home',
            compact(
                'jalonEnRetard',
                'alljalon',
                'jalonEnCours',
                'jalonEnAttente',
                'jalonCloturer',
                'submittedProjects',
                'ongoingProjects',
                'completedProjects',
                'labels',
                'data',
                'projets',
                'projetSoumis',
                'projetEncours',
                'projetFinis',
                'data',
                'data2',
                'datadonut',
                'directions',
                'users',
                'projetsEncours',
                'projetsPrec',
                'annee',
                'annePrec'
            )
        );
    }
}
