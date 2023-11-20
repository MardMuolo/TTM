<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDemandeJalonRequest;
use App\Models\CategoryDemande;
use App\Models\Demande;
use App\Models\DemandeJalon;
use App\Models\MessageMail;
use App\Models\Project;
use App\Models\ProjectOptionttmJalon;
use App\Models\ProjectUser;
use App\Models\User;
use App\Notifications\EasyTtmNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DemandeJalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryDemandes = CategoryDemande::all();
        $demandes = Demande::all();

        return view('demande.all', compact('demandes', 'categoryDemandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function notifyMemberAndManager($manager, $user, $fichiers)
    {
        try {
            // Requete de notification au line_manager
            if ($manager) {
                $message1 = MessageMail::Where('code_name', 'notify_to_manager')->first();
                $manager->notify(new EasyTtmNotification($message1, route('home'), []));
            }

            // foreach ($project->projectFile as $file) {
            //     $projectFiles[] = 'storage/'.$file->filePath;
            // }
            // Requete de notification au contributeur
            $message2 = MessageMail::Where('code_name', 'add_member_to_project')->get()->first();
            $user->notify(new EasyTtmNotification($message2, route('home'), $fichiers));
        } catch (\Exception $e) {
            return redirect()->back();
        }

        return redirect()->back()->with('Done', 'contributeur ajouté avec succès');
    }

    public function handleManager(Request $request)
    {
        $user = User::Where(['email' => $request->email_manager])?->get()->first();
        $project = Project::find($request->project);
        if (!empty($user)) {
            return $user;
        } else {
            $user = User::create([
                'name' => $request->nom_manager,
                'email' => $request->email_manager,
                'username' => $request->username_manager,
                'password' => Hash::make('password'),
            ]);

            return $user;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function handleMember(Request $request, $manager, $project)
    {
        // dd($project);
        // $user = auth()->user();
        $user = User::Where(['email' => $request->email])?->get()->first();

        if (!empty($user)) {
            if ($user->line_manger == null) {
                $user->lineManager()->associate($manager);
                $user->save();
            }
            ProjectUser::create([
                'user_id' => $user->id,
                'project_id' => $request->project_id,
                'role' => $request->role,
            ]);
        } else {
            $user = $manager->collaborateurs()->create([
                'name' => $request->nom,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make('password'),
            ]);

            ProjectUser::create([
                'user_id' => $user->id,
                'project_id' => $request->project_id,
                'role' => $request->role,
            ]);
        }
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($project)
        ->event('addUser')
        ->log(auth()->user()->name.' a ajouté comme '.$request->role.' '.$request->noms);
        // Notification au contributeur pour son affectation au projet

        return $user;
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $project = Project::find($request->project_id);
        // dd($project);
        // Gestion d'ajout de membres et les notification
        $manager = $this->handleManager($request);
        $fichiers = [];

        // sauvegardages des fichiers
        if ($request->hasFile('file')) {
            $files = $request->file('file');

            foreach ($files as $file) {
                $namefile = date('ymdhis').'.'.$file->extension();
                $fichier = $file->storeAs('demandes', $namefile);

                $publicPath = public_path('storage/demandes');
                File::ensureDirectoryExists($publicPath);
                File::delete($publicPath.'/'.$namefile);
                File::link(storage_path('app/'.$fichier), $publicPath.'/'.$namefile);

                $fichiers[] = $fichier;
            }
        }
        // dd($fichiers);
        // gestion d'ajout de membre et la notification
        $user = $this->handleMember($request, $manager, $project);
        $this->notifyMemberAndManager($user, $manager, $fichiers);
        // ProjectUserController::store($request);
        // $user = User::Where('username', $request->contributeur)->get()->first();

        $deadLine = $request->input('deadLine');
        $deadlineUnit = $request->input('deadline_unit');
        $deadlineCombinee = $deadLine.' '.$deadlineUnit;

        $delai = $request->input('deadLine');
        $uniteDelai = $request->input('deadline_unit');

        $datePrevue = null;

        if ($delai && $uniteDelai) {
            $datePrevue = Carbon::now()->add($delai, $uniteDelai);
        }

        $demandeJalon = new DemandeJalon();
        $demandeJalon->demande_id = $request->input('demande');
        $demandeJalon->description = $request->input('description');
        $demandeJalon->pathTask = implode(',', $fichiers);
        $demandeJalon->contributeur = $user->id;
        $demandeJalon->deadLine = $deadlineCombinee;
        $demandeJalon->date_prevue = $datePrevue;
        $demandeJalon->status = 'non soumis';
        $demandeJalon->project_optionttm_jalon_id = $request->input('project_optionttm_jalon_id');
        $demandeJalon->save();
        $project_id = ProjectOptionttmJalon::where('id', $demandeJalon->project_optionttm_jalon_id)->get()->first()->project_id;

        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($project)
            ->event('createTask')
            ->log(auth()->user()->name.' a ajouté une demande '.implode(', ', $fichiers));

        $message = MessageMail::Where('code_name', 'add_member_to_project')->get()->first();
        // $user->notify(new EasyTtmNotification($message,route('home'), $fichiers));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Demande $demande)
    {
        return response()->json($demande);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Demande $demandeJalon)
    {
        $users = User::all();

        return view('projects.tasks.edit', compact('demandeJalon', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDemandeJalonRequest $request, Demande $demandeJalon)
    {
        $delai = $request->input('deadLine');
        $uniteDelai = $request->input('deadline_unit');

        $deadlineCombinee = $delai.' '.$uniteDelai;

        $datePrevue = null;

        if ($delai && $uniteDelai) {
            $datePrevue = Carbon::now()->add($delai, $uniteDelai);
        }
        $demandeJalon->update([
            'title' => $request->title,
            'model' => $request->model,
            'deadLine' => $deadlineCombinee,
            'date_prevue' => $datePrevue,
            'description' => $request->description,
            'contributeur' => $request->contributeur,
        ]);
        $project = Project::find(ProjectOptionttmJalon::where('id', $demandeJalon->project_optionttm_jalon_id)->get()->first()->project_id);
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($project)
        ->event('updateTask')
        ->log(auth()->user()->name.'a modifier la demande '.$demandeJalon->title);

        return redirect()->back()->with('success', 'Point de complexité modifié avec succes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $demandeJalon)
    {
        $demandeJalon = DemandeJalon::findOrFail($demandeJalon);
        $project = Project::find(ProjectOptionttmJalon::where('id', $demandeJalon->project_optionttm_jalon_id)->get()->first()->project_id);
        $demandeJalon->delete();
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($project)
        ->event('deleteTask')
        ->log(auth()->user()->name.'a supprimé la demande '.$demandeJalon->title);

        return redirect()->back();
    }
}
