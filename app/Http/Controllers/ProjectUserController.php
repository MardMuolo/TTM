<?php
/*
Author: emmenuel badibanga
 emmanuelbadidanga250@gmail.com
*/

namespace App\Http\Controllers;

use App\Models\MessageMail;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Notifications\EasyTtmNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProjectUserController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public static function store(Request $request)
    {
        $user = User::Where(['email' => $request->email])?->get()->first();
        $project = Project::find($request->project);
        if ($user) {
            ProjectUser::create([
                'user_id' => $user->id,
                'project_id' => $request->project,
                'role' => $request->role,
            ]);
        } else {
            $user = User::create([
                'name' => $request->noms,
                'email' => $request->email,
                'username' => 'mich',
                'password' => Hash::make('password'),
                'phone_number' => '0825678',
            ]);
            ProjectUser::create([
                'user_id' => $user->id,
                'project_id' => $request->project,
                'role' => $request->role,
            ]);
        }
        activity()
        ->causedBy(auth()->user()->id)
        ->performedOn($project)
        ->event('addUser')
        ->log(auth()->user()->name.' a ajouté comme '.$request->role.' '.$request->noms);
        // Notification au contributeur pour son affectation au projet

        $projectFiles = [];
        $manager = User::where('id', $user->line_manager)->get()->first();

        // Requete de notification au Line Manager
        // if ($manager) {
        //     $message1 = MessageMail::Where('code_name', 'notify_to_manager')->first();
        //     $manager->notify(new EasyTtmNotification($message1, route('home'), []));
        // }

        foreach ($project->projectFile as $file) {
            $projectFiles[] = 'storage/'.$file->filePath;
        }
        try {
            // Requete de notification au contributeur
            //$message2 = MessageMail::Where('code_name', 'add_member_to_project')->get()->first();
            //$user->notify(new EasyTtmNotification($message2, route('home'), $projectFiles));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['projet' => 'Echec d\'ajout de membre']);;
        }

        return redirect()->back()->with(['message'=>'contributeur ajouté avec succès']);
    }

    public function edit(Project $project, $id)
    {
        return view('projects.membres.edit', compact('project', 'id'));
    }

    public static function update(Request $request, Project $project)
    {
        DB::table('project_users')->update([
            'user_id' => $request->user,
            'project_id' => $request->project,
            'role' => $request->role,
        ]);
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($project)
            ->event('updateUser')
            ->log(auth()->user()->name.' a modifié'.$request->role.' '.$request->name);

        return redirect()->route('membres.index');
    }

    public static function destroy($id)
    {
        $member = ProjectUser::where('user_id', $id)->get()->first();
        $project = Project::find($member->project_id);
        $user = User::find($member->user_id);
        $member->delete();
        activity()
            ->causedBy(auth()->user()->id)
            ->performedOn($project)
            ->event('deleteUser')
            ->log(auth()->user()->name.' a supprimé '.$member->role.' '.$user->name);

            return redirect()->back()->with(['message'=>'contributeur suprimé avec succès']);
    }
}
