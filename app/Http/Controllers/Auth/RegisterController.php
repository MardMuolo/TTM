<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Direction;
use Illuminate\Http\Request;
use App\Models\DirectionUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Providers\RouteServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ActiveDirectoryController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // View to add supplementary info about the user
    public function edit()
    {
        $directions = Direction::all();

        return view('auth.add_user_information', compact('directions'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $allowed = ['png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'];
            $extension = $file->extension();

            if (($file->getSize() / 1000000) <= 5) {
                if (in_array($extension, $allowed)) {
                    if ($user->profile_photo != null) {
                        if (File::exists('storage/profiles/' . $user->profile_photo)) {
                            File::delete('storage/profiles/' . $user->profile_photo);
                        }
                    }

                    $namefile = substr(str_replace([' ', "'"], '', Auth::user()->name), 0, 6) . '' . date('ymdhis') . '.' . $file->extension();
                    $path = $file->storeAs('profiles', $namefile);
                    $publicPath = public_path('storage/profiles');
                    File::ensureDirectoryExists($publicPath);
                    File::delete($publicPath . '/' . $namefile);
                    File::link(storage_path('app/' . $path), $publicPath . '/' . $namefile);
                    $user->profile_photo = $namefile;
                    $user->save();

                } else {
                    throw ValidationException::withMessages(['profile' => 'Le format du fichier est incorrect, seuls png,jpg,jpeg sont acceptés!!']);
                }
            } else {
                throw ValidationException::withMessages(['profile' => 'Le fichier est trop volumineux']);
            }
        }

        if (!$request->email && !$request->direction) {
            $id=Crypt::encrypt(Auth::user()->id);
            return to_route('profile',$id);
        }

        $line_manager = User::Where(['email' => $request->email])?->get()->first();

        if (!$line_manager) {
            $req = ActiveDirectoryController::getUserByEmail($request->email);

            if (isset($req->user)) {
                $line_manager = User::create([
                    'name' => $req->user->first_name . ' ' . $req->user->last_name,
                    'email' => $req->user->email,
                    'username' => $req->user->username,
                    'password' => Hash::make('password'),
                ]);
            }
        }

        $user->line_manager = $line_manager->id;
        $user->save();

        $direction_user = DirectionUser::Where(['user_id' => $user->id, 'direction_id' => $request->direction])->get()->first();

        if (!$direction_user) {
            DirectionUser::create([
                'direction_id' => $request->direction,
                'user_id' => $user->id,
                'is_director' => false,
            ]);
        } else {
            $direction_user->update([
                'direction_id' => $request->direction,
            ]);
        }

        if ($request->routeIs('update-user-info')) {
            return to_route('profile');
        }

        return to_route('home');
    }

    public function profile($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        // dd($user);
        $directions = Direction::all();
        $line_manager = User::find($user->line_manager);
        $direction = $user->direction_user?->direction;
        $direction_user_director = DirectionUser::Where(['direction_id' => $direction?->id, 'is_director' => true])->get()->first();

        $directeur = $direction_user_director?->user;
        $userProjects = $user->projects()->get();
        // $userLivrable=Auth::user()->livrables()->get();
        $userActivities = Activity::orderBy('id', 'desc')->where('causer_id', $user->id)->get();
        // die($userProjects);
        $today = Carbon::now();
        return view('auth.profile', compact('user', 'today', 'userProjects', 'directions', 'line_manager', 'directeur', 'direction', 'userActivities'));
    }
}
