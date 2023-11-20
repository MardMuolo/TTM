<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ActiveDirectoryController;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // use AuthenticatesUsers;

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        if ($request->user()->line_manager == null && $request->user()->direction_user == null) {
            return to_route('info');
        }

        return to_route('home');
    }

    protected function validateLogin(Request $request)
    {
        return $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $this->validateLogin($request);
        // Vérifiez si l'utilisateur est "admin" avec le mot de passe "admin"
        $user = User::Where(['username' => $request->username])?->get()->first();
        $isAdmin = $user?->roles->where('name', 'admin')->first();
        if ($user and $isAdmin) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return to_route('home');
            } else {
                return $this->sendFailedLoginResponse($request);
            }
        } else { // Retrieve the ID of the logged in user à partir serveur
            $username = $request->username;
            // Check if the user's username exists in the writelist table
            $username = DB::table('writelists')->where('username', $username)->exists();
            if (!$username) {
                return redirect()->back()->withErrors(['username' => "Vous n'est pas autorisé à se connecter. Veuillez contacter l'administrateur."]);
            }

            //Login From Active directory
            $req = ActiveDirectoryController::loginFromAd($request->username, $request->password);

            if (isset($req->user)) {
                $user = User::Where(['username' => $request->username])?->get()->first();
                // gestion softdelete
                $email = $user?->email;
                $user = User::withTrashed()
                    ->where('email', $email)
                    ->first();

                if ($user) {
                    $user->restore();
                    // Faire quelque chose après avoir restauré l'utilisateur
                }
                if (!$user) {
                    $user = User::create([
                        'name' => $req->user->first_name.' '.$req->user->last_name,
                        'email' => $req->user->email,
                        'username' => $request->username,
                        'password' => Hash::make('password'),
                    ]);
                }

                $this->guard()->login($user);

                return $this->sendLoginResponse($request);
            } else {
                return $this->sendFailedLoginResponse($request);
            }
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
    }

    /**
     * The user has been authenticated.
     *
     * @param mixed $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
    }

    public function username()
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
