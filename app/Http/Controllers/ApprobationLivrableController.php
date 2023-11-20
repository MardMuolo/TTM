<?php

namespace App\Http\Controllers;
use App\Models\MessageMail;
use App\Models\User;
use App\Notifications\EasyTtmNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class ApprobationLivrableController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
        ->join('project_users', 'users.id', '=', 'project_users.user_id')
        ->leftJoin('projects', 'project_users.project_id', '=', 'projects.id')
        ->where('users.line_manager', '=', Auth::user()->id)
        ->whereNotIn('users.id', [Auth::user()->id])
        ->select('users.*', 'projects.name as project_name', 'project_users.*')
        ->get();
        Cache::forever('membres', count($users));
        $i = 1;
        Cache::forever('members', count($users));
        // dd(\Cache::get('members'));
        return view('approbations.livrables.index', compact('users', 'i'));
    }
    public function getOwner($id, $code)
    {
        $owner = User::where('id', $id)->get()->first();
        if ($owner) {
            $message1 = MessageMail::Where('code_name', $code)->first();
            $owner->notify(new EasyTtmNotification($message1, route('home'), []));
        }
    }

    public function update(Request $request, int $id)
    {
        DB::table('project_users')
        ->where('user_id', $id)
        ->update([
            'status' => $request->response,
            'user_id' => $id,
        ]);
        if ($request->response == 'accepter') {
            $this->getOwner($id, 'approuved_member_to_project');
        }
        if ($request->response == 'refus') {
            $this->getOwner($id, 'denied_member_to_project');
        }

        return redirect()->back()->with('Validation avec success');
    }

}
