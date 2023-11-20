<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Metier;
use App\Models\Direction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MetierController extends Controller
{
    public function index()
    {
        $metiers = Metier::orderBy('name')->with('metier_users')->paginate(5);
        $directions=Direction::all();

        $req = ActiveDirectoryController::getUsers();
        $users = $req->users;
        return view("metiers.index", ['metiers' => $metiers, 'users' => $users,'directions' => $directions]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:metiers|max:255',
        ]);

        $req = ActiveDirectoryController::getUserByEmail($request->email);

        if (isset($req->user)) {
            $user = $req->user;
            $user_in_db = User::Where(['email' => $user->email])?->get()->first();

            if (!$user_in_db) {
                $user_in_db = User::create([
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'password' => Hash::make('password'),
                ]);
            }
        } else {
            throw ValidationException::withMessages(["error_serveur" => 'User not found']);
        }
        $metier = Metier::create([
            'name' => $request->name,
            'direction_id' => $request->direction
        ]);

        $metier->metier_users()?->create([
            'user_id' => $user_in_db->id,
            'is_manager' => $request->isManager?true:false
        ]);

        return redirect()->back();
    }
    
    public function destroy(Metier $metier)
    {
        //Delete the related field
        $metier->delete();
        return redirect()->back();
    }
}
