<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jalon;
use App\Models\Demande;
use App\Models\Project;
use App\Models\Livrable;
use App\Models\OptionTtm;
use App\Models\DemandeJalon;
use Illuminate\Http\Request;
use App\Models\HistoriqueDate;
use App\Models\CategoryDemande;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\ProjectOptionttmJalon;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\StoreJalonRequest;
use App\Http\Requests\UpdateJalonRequest;

class JalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandes = Demande::all();
        $jalons = Jalon::all();

        return view('jalons.index', compact('jalons', 'demandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $demandes = Demande::all();
        $jalons = Jalon::all();

        return view('jalons.index', compact('jalons', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJalonRequest $request)
    {
        $designation = $request->designation;

        // Vérifier si le jalon existe déjà
        $existingJalon = Jalon::where('designation', $designation)->exists();
        if ($existingJalon) {
            return redirect()->route('jalons.index')->withErrors(['designation' => 'Le jalon existe déjà.']);
        }

        Jalon::create([
            'designation' => $designation,
        ]);

        return redirect()->route('jalons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jalon $jalon)
    {
    }

    public function show_demande($project, $optionTtm, $jalon, $demande)
    {


        //Decrypatge des Id au niveau des URL
        $project_id = Crypt::decrypt($project);
        $project = Project::findOrFail($project_id);

        $optionTtm_id = Crypt::decrypt($optionTtm);
        $optionTtm = OptionTtm::findOrFail($optionTtm_id);

        $jalon_id = Crypt::decrypt($jalon);
        $jalon = Jalon::findOrFail($jalon_id);
        // dd($optionTtm);

        // $project=Project::findOrFail($project);

        // die($project->users[0]->pivot);
        $demande = DemandeJalon::find($demande);
        $livrables = $demande->livrables()->get();
        $i = 1;
        $color = ['A Corriger' => 'bg-warning', 'Valider' => 'bg-success', 'en attente' => 'bg-secondary', 'Rejeter' => 'bg-danger'];
        return view('jalons.demande', compact('demande', 'livrables', 'i', 'color', 'project', 'optionTtm', 'jalon'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jalon $jalon)
    {
        $users = User::all();
        $demandes = Demande::all();
        $jalon = Jalon::findorFail($jalon->id);

        return view('jalons.edit', compact('jalon', 'users', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJalonRequest $request, Jalon $jalon)
    {
        $jalons = Jalon::findOrFail($jalon->id);

        $jalons->designation = $request->designation;
        $jalons->save();

        return redirect()->route('jalons.index');
    }

    public function is_active($id)
    {
        $tmp = DB::table('project_users')
            ->where('user_id', $id)
            ->where('status', env('membreApprouver'))
            ->get();
        // dd($tmp);

        return $tmp;
    }

    public function single($jalon, $option_ttm, $project)
    {

        //Decrypatge des Id au niveau des URL
        $jalon = Crypt::decrypt($jalon);
        $jalon = Jalon::findOrFail($jalon);

        $option_ttm = Crypt::decrypt($option_ttm);
        $optionTtm = Optionttm::findOrFail($option_ttm);

        $project = Crypt::decrypt($project);
        $project = Project::findOrFail($project);

        // $allContributeur = Http::get('http://10.143.41.70:8000/promo2/odcapi/?method=getUsers');
        $allContributeurs = User::all();
        $categoryDemandes = CategoryDemande::all();
        $projetOptionJalon = ProjectOptionttmJalon::where("jalon_id", $jalon->id)
            ->where("option_ttm_id", $optionTtm->id)
            ->where("project_id", $project->id)->get()->first();
        $jalonDemande = DemandeJalon::where("project_optionttm_jalon_id", $projetOptionJalon->id)->get();
        $i = 1;
        // dd($demandeJalons);

        $allDemandes = Demande::whereHas('jalon', function ($query) use ($jalon) {
            $query->where('id', $jalon->id);
        })->orWhereDoesntHave('jalon')->get();

        $users = Project::find($project->id)->users;
        $option_ttm = $project->optionttm()->get()->first();
        $projectOptionttmJalon = ProjectOptionttmJalon::where('jalon_id', $jalon->id)->where('option_ttm_id', $optionTtm->id)->where('project_id', $project->id)->first();
        $status = $projectOptionttmJalon->status;
        if ($projectOptionttmJalon) {
            $demandes = $projectOptionttmJalon->demandeJalons()->get();
            $totalDemandes = $demandes->count();
            $demandesSoumises = $demandes->where('status', env('demandeSoumise'))->count();
            $is_active = $this->is_active(Auth()->user()->id);
            // dd($is_active);
            $members = $project->users;
            foreach ($demandes as $demande) {
                $retard = null;
                $dateActuelle = now(); // Obtenez la date actuelle

                if ($demande->date_reelle) {
                    $retard = Carbon::parse($demande->date_reelle)->diffInDays($demande->date_prevue);
                } else {
                    if ($demande->date_prevue && $dateActuelle > $demande->date_prevue) {
                        $retard = $dateActuelle->diffInDays($demande->date_prevue);
                    }
                }

                $demande->retard = $retard;
                $demande->message_retard = ($demande->date_reelle && $demande->date_reelle < $demande->date_prevue) ? '' : (($retard === 0 && !$demande->date_reelle) ? 'Pas de retard observé' : null);
            }
            $pivotId = $projectOptionttmJalon->id;
            $debutDate = $projectOptionttmJalon->debutDate;
            $echeance = $projectOptionttmJalon->echeance;
        }
        $historiques = HistoriqueDate::where('project_optionttm_jalon_id', $projectOptionttmJalon->id)->orderBy('date_repouser', 'desc')->get();
        // dd($totalDemandes);
        return view('jalons.single', compact('is_active', 'allContributeurs', 'categoryDemandes', 'allDemandes', 'jalon', 'optionTtm', 'project', 'demandes', 'users', 'option_ttm', 'debutDate', 'echeance', 'pivotId', 'historiques', 'totalDemandes', 'demandesSoumises', 'status', 'jalonDemande', 'i'));
    }

    public function addDate(Request $request, Jalon $jalon, $option_ttm, Project $project)
    {
        // Validation des champs 'debutDate' et 'echeance' pour s'assurer qu'ils contiennent des dates valides
        $request->validate([
            'debutDate' => 'required|date|after_or_equal:' . Carbon::today()->format('Y-m-d'),
            'echeance' => 'required|date|after_or_equal:debutDate',
        ]);

        // Récupération de l'option TTM du projet
        $option_ttm = $project->optionttm()->first();

        // Recherche du premier ProjectOptionttmJalon correspondant aux critères spécifiés
        $projectOptionttmJalon = ProjectOptionttmJalon::where('jalon_id', $jalon->id)
            ->where('option_ttm_id', $option_ttm->id)
            ->where('project_id', $project->id)
            ->first();

        if ($projectOptionttmJalon) {
            // Mise à jour des champs 'debutDate' et 'echeance' du ProjectOptionttmJalon avec les nouvelles dates
            $projectOptionttmJalon->debutDate = $request->debutDate;
            $projectOptionttmJalon->echeance = $request->echeance;

            if ($projectOptionttmJalon->save()) {
                // Enregistrement d'une activité de journalisation pour suivre l'ajout de la date
                activity()
                    ->causedBy(auth()->user()->id)
                    ->performedOn($project)
                    ->event('add')
                    ->log(auth()->user()->name . ' a fixé la Date du passage pour le jalon ' . $jalon->designation . ', du ' . $request->debutDate . ' au ' . $request->echeance);
            }

            // Mettre à jour la date de fin du projet avec la date de fin du dernier jalon
            $dernierJalon = $project->optionsJalons()->orderBy('jalon_id', 'desc')->first();

            if ($dernierJalon && $dernierJalon->pivot->echeance > $project->endDate) {
                $project->endDate = $dernierJalon->pivot->echeance;
                $project->save();
            }

            // Mise à jour du statut du projet
            $project->update([
                'status' => env('projetenCours'),
            ]);

            // Redirection vers la page précédente
            return redirect()->back();
        }

        // Redirection vers la page précédente avec un message d'erreur si aucun ProjectOptionttmJalon n'a été trouvé
        return redirect()->back()->with('error', 'Projet non trouvé.');
    }

    public function repouserDate(Request $request, $jalon, $option_ttm, $project)
    {
        $jalon_id = Crypt::decrypt($jalon);
        $jalon = Jalon::findOrFail($jalon_id);
        $option_ttm = Crypt::decrypt($option_ttm);
        $project_id = Crypt::decrypt($project);
        $project = Project::findOrFail($project_id);
        // Validation du champ 'echeance' pour s'assurer qu'il contient une date valide
        $request->validate([
            'echeance' => 'required|date',
        ]);

        // Recherche du premier ProjectOptionttmJalon correspondant aux critères spécifiés
        $projectOptionttmJalon = ProjectOptionttmJalon::where('jalon_id', $jalon->id)
            ->where('option_ttm_id', $option_ttm)
            ->where('project_id', $project->id)
            ->first();

        if ($projectOptionttmJalon) {
            // Conversion de la date précédente en format 'Y-m-d'
            $echeanceAncienne = Carbon::parse($projectOptionttmJalon->echeance)->format('Y-m-d');

            // Validation du champ 'echeance' à nouveau pour s'assurer qu'il est une date postérieure à la date précédente
            $request->validate([
                'echeance' => 'required|date|after:' . $echeanceAncienne,
            ], [
                'echeance.after' => 'La nouvelle échéance doit être une date ultérieure à l\'ancienne échéance.',
            ]);

            // Création d'un enregistrement dans la table HistoriqueDate pour suivre les changements de date
            HistoriqueDate::create([
                'project_optionttm_jalon_id' => $projectOptionttmJalon->id,
                'date_initiale' => $projectOptionttmJalon->echeance,
                'date_repouser' => $request->echeance,
            ]);

            // Mise à jour de la valeur de 'echeance' du ProjectOptionttmJalon avec la nouvelle date
            $projectOptionttmJalon->echeance = $request->echeance;
            if ($projectOptionttmJalon->save()) {
                // Enregistrement d'une activité de journalisation pour suivre la modification de la date
                activity()
                    ->causedBy(auth()->user()->id)
                    ->performedOn($project)
                    ->event('updateTask')
                    ->log(auth()->user()->name . ' a repoussé la date du jalon ' . $jalon->designation . ' au ' . $request->echeance);
            }

            // Modifier la date du jalon suivant s'il existe
            $option_ttm = $project->optionttm()->first();
            $currentProjectOptionttmJalon = ProjectOptionttmJalon::where('option_ttm_id', $option_ttm->id)
                ->where('project_id', $project->id)
                ->first();

            if ($currentProjectOptionttmJalon) {
                $projectOptionttmJalons = ProjectOptionttmJalon::where('option_ttm_id', $option_ttm->id)
                    ->where('project_id', $project->id)
                    ->where('id', '>', $currentProjectOptionttmJalon->id)
                    ->get();

                if ($projectOptionttmJalons->isNotEmpty()) {
                    // Calcul de la différence de jours entre la nouvelle date et l'ancienne date
                    $joursDeDifference = Carbon::parse($request->echeance)->diffInDays($echeanceAncienne);

                    foreach ($projectOptionttmJalons as $NextprojectOptionttmJalons) {
                        // Mise à jour des dates de début et d'échéance des jalons suivants en ajoutant la différence de jours
                        $nouvelleDateDebut = Carbon::parse($NextprojectOptionttmJalons->debutDate)->addDays($joursDeDifference);
                        $nouvelleDateEcheance = Carbon::parse($NextprojectOptionttmJalons->echeance)->addDays($joursDeDifference);

                        $NextprojectOptionttmJalons->debutDate = $nouvelleDateDebut;
                        $NextprojectOptionttmJalons->echeance = $nouvelleDateEcheance;
                        $NextprojectOptionttmJalons->save();
                        $project->endDate = $nouvelleDateEcheance;
                        $project->save();
                    }
                }
            }

            // Redirection vers la route appropriée après la mise à jour de la date
            return redirect()->route('jalons.single', ['jalon' => Crypt::encrypt($jalon->id), 'option_ttm' => Crypt::encrypt($option_ttm->id), 'project' => Crypt::encrypt($project->id)]);
        }

        // Redirection vers la route appropriée si aucun ProjectOptionttmJalon n'a été trouvé
        return redirect()->route('jalons.single', ['jalon' => Crypt::encrypt($jalon->id), 'option_ttm' => Crypt::encrypt($option_ttm->id), 'project' => Crypt::encrypt($project->id)]);
    }

    public function updateStatus(Request $request, $jalon, $option_ttm, $project)
    {
        // dd($request->status);
        //Decryptage des Url
        $jalon = Crypt::decrypt($jalon);
        $option_ttm = Crypt::decrypt($option_ttm);
        $project_id = Crypt::decrypt($project);

        $project = Project::findOrFail($project_id);




        $projectOptionttmJalon = ProjectOptionttmJalon::where('jalon_id', $jalon)
            ->where('option_ttm_id', $option_ttm)
            ->where('project_id', $project->id)
            ->first();

        if ($request->comite == "on") {
            $projectOptionttmJalon->status = env('jalonEnComite');
            $projectOptionttmJalon->save();
        } else {
            if ($request->hasFile('jalonPv')) {
                $jalonPvFile = $request->file('jalonPv');
                $jalonPvFileName = substr(str_replace([' ', "'"], '', $jalonPvFile->getClientOriginalName()), 0, 6) . date('ymdhis') . '.' . $jalonPvFile->extension();
                $destinationPath = 'storage/lalonPvs';
                $jalonPvFile->storeAs($destinationPath, $jalonPvFileName, 'public');

                // Enregistrement du nom du fichier dans la base de données

                if ($projectOptionttmJalon) {
                    dd($request->comite);
                    $projectOptionttmJalon->status = env('jalonCloturer');
                    $projectOptionttmJalon->jalonPv = $jalonPvFileName;
                    $projectOptionttmJalon->save();
                    activity()
                        ->causedBy(auth()->user()->id)
                        ->performedOn($project)
                        ->event('endTask')
                        ->log(auth()->user()->name . ' a déclaré le jalon ' . $jalon . ' comme cloturé');
                }
            }
        }



        return redirect()->back()->with(['msg' => 'Status du jalon changé avec success']);
    }
    public function passageComite(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jalon $jalon)
    {
        $jalon->delete();

        return redirect()->route('jalons.index');
    }
}
