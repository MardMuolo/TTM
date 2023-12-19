<?php

/*
Author: emmenuel badibanga
 emmanuelbadidanga250@gmail.com

*/

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Jalon;
use App\Models\Demande;
use App\Models\Project;
use App\Models\Livrable;
use App\Models\Direction;
use App\Models\OptionTtm;
use App\Models\MessageMail;
use App\Models\ProjectFile;
use App\Models\ProjectUser;
use App\Models\DemandeJalon;
use Illuminate\Http\Request;
use App\Models\ComplexityItem;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Models\ComplexityTarget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\ProjectOptionttmJalon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use App\Models\ProjectComplexityTarget;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Response;
use App\Notifications\EasyTtmNotification;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request->filter ?? null;
        if (isset(Auth()->user()->direction_user->is_director)) {
            $projects = Project::isDirector();
        } else {
            // Variable project: nous permet de recuperer tous les projets selon le rôle de l'utilisateur connecté
            $projects = isset($filter) ? Project::where('status', $filter)->get() : Project::get(Project::isAdmin());
        }
        //dd($projects[0]->with('users', 'optionsJalons')->get());
        Cache::forever('projects', count($projects));

        $i = 1;

        $tab = ['yellow', 'orange', 'secondary'];
        return view('projects.index', compact('projects', 'i', 'filter', 'tab'));
    }

    // cette methode permet d'afficher un projet en particulier et de l'injeter dans la vue single
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $project = Project::findOrFail($id);
        $statusColor = [
            'create' => 'fas fa-user-tie',
            'update' => 'fas fa-edit',
            'add' => 'fas fa-chart-line',
            'addUser' => 'fas fa-user-plus',
            'deleteUser' => 'fas fa-user-minus',
            'updateUser' => 'fas fa-user-cog',
            'addFile' => 'fas fa-file-upload',
            'updateDate' => 'fas fa-clock',
            'addDate' => 'fas fa-clock',
            'updateTask' => 'fas fa-random',
            'edit' => 'fas fa-edit',
            'endTask' => 'fas fa-clock',
            'createTask' => 'fas fa-edit',
            'deleteTask' => 'fas fa-user-minus',
        ];



        // Récuperation des documents du projets
        $demandes = Demande::orderBy('id', 'desc')->paginate(5);
        $file = ProjectFile::all()->where('project_id', $project->id);
        $project = Project::findorFail($project->id);
        $jalons = $project->optionsJalons;

        $option_ttm = $project->optionttm()->get()->first();
        $options = $project->optionttm()->get()->first();
        $complexity_targets = ProjectComplexityTarget::all()->where('project_id', $project->id);
        $complexity_items = ComplexityItem::all();
        $complexityTargets = ComplexityTarget::all();
        $directions = Direction::all();
        $members = $project->users;
        $i = 1;
        $users = User::all();

        $jalonsProgress = [];
        $demandesProject = collect();
        $contributeurs = [];

        foreach ($jalons as $jalon) {
            $projectOptionttmJalon = ProjectOptionttmJalon::where('jalon_id', $jalon->id)
                ->where('option_ttm_id', $options->id)
                ->where('project_id', $project->id)
                ->first();

            if ($projectOptionttmJalon) {
                $demandes = $projectOptionttmJalon->demandeJalons()->get();
                // dd($demandes);

                $demandesProject = $demandesProject->concat($demandes);

                $demandesByProjectId = $demandes->groupBy('project_optionttm_jalon_id');

                foreach ($demandesByProjectId as $projectId => $projectDemandes) {
                    $contributeurs = $projectDemandes->pluck('contributeur')->unique();
                }

                $totalDemandes = $demandes->count();
                $demandesSoumises = $demandes->where('status', env('demandeSoumise'))->count();
                // dd($demandesSoumises);

                $progressionJalon = $totalDemandes > 0 ? ($demandesSoumises / $totalDemandes) * 100 : 0;

                if ($projectOptionttmJalon->debutDate && $projectOptionttmJalon->echeance) {
                    if ($projectOptionttmJalon->status !== env('jalonCloturer')) {
                        // Le statut n'est pas "Finis"
                        if ($totalDemandes > 0 && $totalDemandes == $demandesSoumises) {
                            $status = env('jalonEnAttente');
                        } else {
                            $status = env('jalonEnCours');
                        }
                    } else {
                        // Le statut est "Finis"
                        $status = env('jalonCloturer');
                    }
                } else {
                    $status = 'En attente';
                }

                $projectOptionttmJalon->status = $status;
                $projectOptionttmJalon->save();

                $jalonsProgress[] = [
                    'jalon' => $jalon,
                    'progression' => $progressionJalon,
                    'status' => $status,
                ];

                $debutDate = $projectOptionttmJalon->debutDate;
                $echeance = $projectOptionttmJalon->echeance;
            }
        }
        $echeance = $project->optionsJalons[0]->pivot->echeance ?? null;
        if ($echeance != null) {
            $exit = false;
        } else {
            $exit = true;
        }

        // Recuperer la somme des scores relatifs au projet
        $score = $project->score;

        // Recuperer l'option ttm adéquate
        $option_ttm = OptionTtm::where('minComplexite', '<=', $score, 'and', 'maxComplexite', '>=', $score);
        $optionTtm = $option_ttm->get()->first();
        $today = Carbon::now();

        $activity = Activity::orderBy('id', 'desc')->where('subject_id', $project->id)->get();

        $projectOptionttmJalon = ProjectOptionttmJalon::where('project_id', $project->id)->get();

        $demandeByJalon = DemandeJalon::join('project_optionttm_jalon', 'demande_jalons.project_optionttm_jalon_id', '=', 'project_optionttm_jalon.id')
            ->get();
        $titleOfDemandes = Demande::join('demande_jalons', 'demande_jalons.demande_id', '=', 'demandes.id')->get();




        /*$demandeByJalon = DB::table('project_optionttm_jalon')
                     ->join('demandes', 'demandes.project_optionttm_jalon_id', '=', 'project_optionttm_jalon.id')
                     ->select('demandes.*','project_optionttm_jalon.jalon_id')
                     ->get();*/

        // dd($exit);
        // dd($demandesSoumises);

        // $demandes_soumis=

        return view('projects.single', compact('statusColor', 'project', 'optionTtm', 'projectOptionttmJalon', 'file', 'score', 'option_ttm', 'jalons', 'options', 'jalonsProgress', 'members', 'i', 'activity', 'exit', 'demandeByJalon', 'contributeurs', 'titleOfDemandes', 'demandesProject', 'today', 'directions', 'users', 'complexityTargets', 'complexity_items'));
    }

    // cette methode permet la rediction au formulaire de création projet
    public function create()
    {
        $users = User::all();

        $complexity_items = ComplexityItem::all();

        return view('projects.create', compact('complexity_items', 'users'));
    }


    public function addStaff(User $user, Project $project, $role)
    {
        // dd($user);
        // $user = User::find($user->id);
        ProjectUser::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => $role,
            'status' => env('membreApprouver'),
        ]);
        // $sms=[
        //     'projectOwner'=>SendMailController::to_projectOwner($user->email, "text","teplate"),
        //     'sponsor'=>SendMailController::to_sponsor($user->email, "text","teplate")
        // ];
        // $mail=[
        //     'projectOwner'=>SendSmsController::to_projectOwner("0844297349"),
        //     'sponsor'=>SendSmsController::to_sponsor("0844297349")
        // ];
        // //envoi du mail 
        // $response1=$sms[$role];
        // $response2=$mail[$role];



        // //sauvegardage de l'activite
        // Log::alert($response1);
        // Log::alert($response2);

    }



    // cette methode permet la création du projet dans la base des données
    public function store(Request $request)
    {
        try {
            $owner = User::where('id', auth()->user()->id)->first();
            $sponsor = User::where('username', $request->sponsor_username)->first();
            // dd($sponsor);

            if (!$sponsor) {
                $sponsor = User::create([
                    'name' => $request->sponsor_name,
                    'username' => $request->sponsor_username,
                    'email' => $request->sponsor_Email,
                    'phone_number' => $request->sponsor_phone_number,
                    'password' => Hash::make('password')
                ]);
            }
            // dd($request->all());


            //Processus de création du projet
            $project = Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'target' => $request->target,
                'type' => $request->type,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'score' => array_sum($request->score),
                'coast' => $request->coast,
                'projectOwner' => $owner['name'],
                'sponsor' => $sponsor['name'],
            ]);
            // dd($owner);
            // ajout et notification du premier membre qui est  l'initiateur du projet
            $this->addStaff($owner, $project, 'projectOwner');
            SendSmsController::to_projectOwner("0844297349");


            // ajout et notification du deuxieme membre qui est  le sponsor du projet
            $this->addStaff($sponsor, $project, 'sponsor');
            SendSmsController::to_sponsor("0844297349");




            $folder_name = $project->id;


            //Enregistrement des documents constitutifs et descriptifs du projet
            if ($request->hasFile('file')) {
                foreach ($request->file as $file) {
                    $namefile = $folder_name . '' . date('ymdhis') . '.' . $file->extension();
                    $path = $file->storeAs('projets/' . $folder_name . '/documents', $namefile);
                    $publicPath = public_path('storage/projets/' . $folder_name . '/documents');
                    // File::ensureDirectoryExists($publicPath);
                    // File::delete($publicPath . '/' . $namefile);
                    // File::link(storage_path('app/' . $path), $publicPath . '/' . $namefile);
                    $project->projectFile()->create([
                        'filePath' => $path,
                    ]);
                }
            }

            // Get all items in the project
            // $items = ComplexityTarget::find(2);
            // store all targets for one project
            $complexityTarget = $request->input('target_id');

            foreach ($complexityTarget as $target_id) {
                $project->projectComplexityTargets()->create(
                    ['complexity_target_id' => $target_id]
                );
            }
            $complexityItem = $request->input('item_id');
            // dd($complexityItem);

            foreach ($complexityItem as $item_id) {
                $project->projectComplexityItems()->create(
                    ['complexity_item_id' => $item_id]
                );
            }

            activity()
                ->causedBy(auth()->user()->id)
                ->performedOn($project)
                ->event('create')
                ->log(
                    auth()->user()->name . ' a crée le projet '
                );

            return redirect()->route('projects.dates', $project->id)->with('score')->with('message', 'création du projet avec success');

            // return redirect()->route('projects.show', $project->id)->with('score');
        } catch (\Throwable $th) {
            return $th;
            Log::error($th->getMessage());
            return redirect()->back()->withErrors(['projet' => 'Echec de création du projet']);
        }
    }

    // public function save_activity($project, $action,$event){
    //     activity()
    //             ->causedBy(auth()->user()->id)
    //             ->performedOn($project)
    //             ->event($event)
    //             ->log(
    //                 auth()->user()->name . $action
    //             );

    // }

    // public function mail_to_ttmOfficer($message)
    // {
    //     $notification = new NotificationController();
    //     $role = Role::where('name', 'admin')->get()->first();
    //     $ttmOfficer = $role->users()->get()->first;
    //     $user = User::where('id', $ttmOfficer->id)->get()->first();
    //     $notification->sendSms($user->phone_number, $message);
    // }

    public function addDates(Jalon $jalon, OptionTtm $optionTtm, Project $project)
    {
        // Récuperation des documents du projets

        $project = Project::findorFail($project->id);
        $users = Project::find($project->id)->users;
        $option_ttm = $project->optionttm()->get()->first();
        $projectOptionttmJalon = ProjectOptionttmJalon::where('jalon_id', $jalon->id)->where('option_ttm_id', $optionTtm->id)->where('project_id', $project->id)->first();
        $jalons = $project->optionsJalons;
        $option_ttm = $project->optionttm()->get()->first();
        $options = $project->optionttm()->get()->first();
        $complexity_targets = ProjectComplexityTarget::all()->where('project_id', $project->id);
        $complexity_items = ComplexityItem::all();
        $complexityTargets = ComplexityTarget::all();
        $directions = Direction::all();
        $i = 1;
        $users = User::all();

        $jalonsProgress = [];
        $demandesProject = collect();

        foreach ($jalons as $jalon) {
            $projectOptionttmJalon = ProjectOptionttmJalon::where('jalon_id', $jalon->id)
                ->where('option_ttm_id', $options->id)
                ->where('project_id', $project->id)
                ->first();

            if ($projectOptionttmJalon) {
                $demandes = $projectOptionttmJalon->demandeJalons()->get();
                $demandesProject = $demandesProject->concat($demandes);
                $totalDemandes = $demandes->count();
                $demandesSoumises = $demandes->where('status', env('demandeSoumise'))->count();

                $progressionJalon = $totalDemandes > 0 ? ($demandesSoumises / $totalDemandes) * 100 : 0;

                if ($projectOptionttmJalon->debutDate && $projectOptionttmJalon->echeance) {
                    if ($projectOptionttmJalon->status !== env('jalonCloturer')) {
                        // Le statut n'est pas "Finis"
                        if ($totalDemandes > 0 && $totalDemandes == $demandesSoumises) {
                            $status = env('jalonEnAttente');
                        } else {
                            $status = env('jalonEnCours');
                        }
                    } else {
                        // Le statut est "Finis"
                        $status = env('jalonCloturer');
                    }
                } else {
                    $status = 'En attente';
                }

                $projectOptionttmJalon->status = $status;
                $projectOptionttmJalon->save();

                $jalonsProgress[] = [
                    'jalon' => $jalon,
                    'progression' => $progressionJalon,
                    'status' => $status,
                ];

                $debutDate = $projectOptionttmJalon->debutDate;

                $echeance = $projectOptionttmJalon->echeance;
            }
        }
        $echeance = $project->optionsJalons[0]->pivot->echeance ?? null;
        if ($echeance != null) {
            $exit = false;
        } else {
            $exit = true;
        }

        // Recuperer la somme des scores relatifs au projet
        $score = $project->score;

        // Recuperer l'option ttm adéquate
        $option_ttm = OptionTtm::where('minComplexite', '<=', $score, 'and', 'maxComplexite', '>=', $score);
        $optionTtm = $option_ttm->get()->first();
        $today = Carbon::now();

        $activity = Activity::orderBy('id', 'desc')->where('subject_id', $project->id)->get();

        // dd($exit);
        return view('projects.dates', compact('project', 'echeance', 'optionTtm', 'score', 'option_ttm', 'jalons', 'options', 'jalonsProgress', 'i', 'exit', 'today', 'directions', 'projectOptionttmJalon', 'complexityTargets', 'complexity_items'));
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $project = Project::findOrFail($id);
        $users = User::all();
        $complexity_items = ComplexityItem::all();

        return view('projects.edit', compact('project', 'complexity_items', 'users'));
    }

    public function getProjectToRepport(Request $request)
    {
        if ($request->is_comite) {

            $projects = Project::where('id', 1);
        }
        //    dd($request);

        // Faites ce que vous voulez avec les données récupérées
        // ...

        // $response = [
        //     'message' => 'Requête AJAX GET traitée avec succès',
        //     'param1' => $param1,
        //     'param2' => $param2
        // ];

        return response()->json($projects);
    }

    public function update(Request $request, $id)
    {
        $project_id = Crypt::decrypt($id);
        $project = Project::findOrFail($project_id);

        try {
            $owner = User::where('id', $request->owner)->first();
            $project->update([
                'name' => $request->name,
                'description' => $request->description,
                'target' => $request->target,
                'type' => $request->type,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'score' => array_sum($request->score),
                'coast' => $request->coast,
                'projectOwner' => $owner['name'],
            ]);
            ProjectUser::where('project_id', $project->id)
                ->update([
                    'user_id' => $request->owner,
                    'project_id' => $project->id,
                    'role' => 'projectOwner',
                ]);
            if ($request->file != null) {
                foreach ($request->file as $file) {
                    if ($request->hasFile('file')) {
                        $namefile = substr(str_replace([' ', "'"], '', $request->name), 0, 6) . '' . date('ymdhis') . '.' . $file->extension();
                        $fichier = $file->storeAs('documents', $namefile, 'public');
                        activity()
                            ->causedBy(auth()->user()->id)
                            ->performedOn($project)
                            ->event('add')
                            ->log(auth()->user()->name . ' a modifié un fichier  du projet ');
                    } else {
                        $fichier = null;
                    }
                    $project->projectFile()->update([
                        'filePath' => $fichier,
                    ]);
                }
            }

            activity()
                ->causedBy(auth()->user()->id)
                ->performedOn($project)
                ->event('edit')
                ->log(auth()->user()->name . 'a modifié  le projet');

            return redirect()->route('projects.show', $id)->with('score');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['projet' => 'Echec de modification du projet']);
        }
    }



    public function telechargerProjet($id)
    {
        // dd($id);
        $project = Project::findOrFail($id);
        $name = substr(str_replace([' ', "'"], '', $project->name), 0, 10);
        $repertoire = storage_path('app\projets\\' . $project->id);
        // dd($repertoire);
        $nomFichierZip = $name . 'EasyTTM.zip';
        $cheminFichierZip =  storage_path($nomFichierZip);
        // dd($cheminFichierZip);

        // Créer une instance de la classe ZipArchive
        $zip = new ZipArchive();

        // Ouvrir le fichier ZIP en mode création
        if ($zip->open($cheminFichierZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Récupérer la liste des fichiers et dossiers dans le répertoire "storage"
            $elements = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($repertoire, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            // Parcourir les fichiers et dossiers et les ajouter au fichier ZIP
            foreach ($elements as $element) {
                if ($element->isFile()) {
                    $chemin = $element->getPathName();

                    $nom = $element->getBasename();
                    // dd($element->getPath());
                    $zip->addFile($chemin, $nom);
                } elseif ($element->isDir()) {
                    $chemin = $element->getPath();
                    $nom = $element->getBasename();
                    $zip->addEmptyDir($nom);
                    // dd($chemin);
                }
            }

            // Fermer le fichier ZIP
            $zip->close();


            // Obtenir le contenu du fichier ZIP
            // Vérifier si le fichier ZIP a bien été créé
            if (file_exists($cheminFichierZip)) {
                // Retourner le fichier ZIP en tant que téléchargement
                return response()->download($cheminFichierZip, $nomFichierZip)->deleteFileAfterSend(true);
            } else {
                // En cas d'erreur lors de la création du fichier ZIP
                return response('Erreur lors de la création du fichier ZIP', 500);
            }
        } else {
            // En cas d'erreur lors de l'ouverture du fichier ZIP
            return response('Erreur lors de l\'ouverture du fichier ZIP', 500);
        }
    }


    public function destroy(Project $project)
    {
        try {
            $project->delete();
            activity()
                ->causedBy(auth()->user()->id)
                ->performedOn($project)
                ->event('delete')
                ->log(auth()->user()->name . ' a supprimé le projet ' . $project->name);

            return redirect()->back()->with('Sucess', 'Projet supprimé avec success');
        } catch (\Throwable $th) {
            return view('errorsPages.error');
        }
    }
}
