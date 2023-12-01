<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\SoapClientHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
        try {
            $credentials=$this->validateLogin($request);
            $username = $request->username;
            $password = $request->password;

            $localUser = User::Where(['username' => $request->username])?->get()->first();
            $isAdmin = $localUser?->roles->where('name', 'admin')->first();
            if ($localUser and $isAdmin) {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
    
                    return to_route('projects.index');
                } else {
                    return $this->sendFailedLoginResponse($request);
                }
            }else{
                $request_ldap = new SoapClientHelper();
            $request_body = '<?xml version="1.0"?>
            <COMMAND>
                   <TYPE>AUTH_SVC</TYPE>
                   <APPLINAME>OrangeBadge</APPLINAME>
                   <CUID>' . $username . '</CUID>
                   <PASSWORD>' . $password . '</PASSWORD>
                   <DATE>' . Carbon::now() . '</DATE>       
           </COMMAND>';

            $result = $request_ldap->postXmlRequest($request_body);

            $xml = simplexml_load_string($result);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            $array = (object) $array;


            if ($array->REQSTATUS == "SUCCESS") {

                if (!$localUser) {
                    $localUser = User::create([
                        'name' => $array->FULLNAME,
                        'username' => $array->CUID,
                        'email' => $array->EMAIL,
                        'phone' => $array->PHONENUMBER,
                        'password' => Hash::make($password)
                    ]);

                    activity()
                        ->causedBy($localUser)
                        ->performedOn($localUser)
                        ->event('add')
                        ->log("Création d'une nouvelle instance utilisateur");
                }

                if ($localUser) {
                    $this->guard()->login($localUser);
                } else {
                    $id = Crypt::encrypt(auth()->user()->id);
                    return redirect()->route('info');
                }

                return $this->sendLoginResponse($request);
            } else {

                return $this->sendFailedLoginResponse($request);
            }
            }

            
        } catch (Exception) {
            return $this->sendFailedLoginResponse($request);
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
