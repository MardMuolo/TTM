<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Direction;
use Illuminate\Http\Request;
use App\Models\DirectionUser;
use Illuminate\Support\Facades\Hash;
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
    
        $req = ActiveDirectoryController::getUsers();
        $users = $req->users;
        return view("directions.index", ['directions' => $directions, 'users'=>$users]);
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
        
        
        $request->validate([
            'name' => 'required|unique:directions|max:255',
        ]);
        
        $req = ActiveDirectoryController::getUserByEmail($request->user);

        if(isset($req->user))
        {
            $user = $req->user;
            $user_in_db = User::Where(['email' => $user->email])?->get()->first();

            if(!$user_in_db){
                $user_in_db = User::create([
                    'name' => $user->first_name.' '.$user->last_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'password' => Hash::make('password'),
                ]);
            }
        }else{
            throw ValidationException::withMessages(["error_serveur" => 'User not found']);
        }

        $direction = Direction::create([
            'name'=>$request->name
        ]);

        $direction->direction_users()?->create([
            'user_id'=>$user_in_db->id,
            'is_director'=>true
        ]);

        return redirect()->back();
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

        if(isset($req->user))
        {
            $user = $req->user;
            $user_in_db = User::Where(['email' => $user->email])?->get()->first();

            if(!$user_in_db){
                $user_in_db = User::create([
                    'name' => $user->first_name.' '.$user->last_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'password' => Hash::make('password'),
                ]);
            }
        }else{
            throw ValidationException::withMessages(["error_serveur" => 'User not found']);
        }

        $former_direction_user = DirectionUser::Where(['user_id'=> $user_in_db->id, 'is_director'=>true])->first();
        
        if($former_direction_user){
            $former_direction_user->update([
                'user_id' => null
            ]);
        }
        
        $direction->update([
            'name'=>$request->name
        ]);

        $direction->direction_users()?->Where('is_director',true)->first()->update([
            'user_id'=>$user_in_db->id
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
