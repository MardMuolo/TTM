<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Direction;
use Illuminate\Http\Request;
use App\Models\DirectionUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ActiveDirectoryController;

class DirectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Return the view index related to directions
        $directions = Direction::orderBy('name')->paginate(5);
        $users = User::all();
        return view("directions.index", ['directions' => $directions, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:directions|max:255',
            ]);
            $user_in_db = User::Where(['username' => $request->username])?->get()->first();
            
            if (!$user_in_db) {
                $user_in_db = User::create([
                    'name' => $request->user_name,
                    'email' => $request->Email,
                    'password' =>Hash::make('password'),
                    'phone_number' => $request->phone_number,
                    'username' => $request->username,
                ]);
            }
            $direction=Direction::create([
                'name' => $request->direction_name,
            ]);
            DirectionUser::create([
                'user_id'=>$user_in_db->id,
                'direction_id'=>$direction->id,
                'is_director'=>true,
            ]);

            return redirect()->back()->with('success','création de la direction avec success');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->back()->with('error','création de la direction a échouée! veuillez voir si la diretion existe déjà');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Direction $direction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Direction $direction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Direction $direction)
    {
        //
        $request->validate([
            'name' => 'required|max:255'
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

        $former_direction_user = DirectionUser::Where(['user_id' => $user_in_db->id, 'is_director' => true])->first();

        if ($former_direction_user) {
            $former_direction_user->update([
                'user_id' => null
            ]);
        }

        $direction->update([
            'name' => $request->name
        ]);

        $direction->direction_users()?->Where('is_director', true)->first()->update([
            'user_id' => $user_in_db->id
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Direction $direction)
    {
        //Delete the related direction
        $direction->delete();
        return redirect()->back();
    }
}
