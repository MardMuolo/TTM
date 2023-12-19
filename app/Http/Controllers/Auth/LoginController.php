<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    public function connect($username, $password)
    {
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
        return $array;
    }

    //Cette methode vefifie si la personne qui tente de se connecter est autorisée à acceder à l'application
    public function is_onWriteList($username)
    {
        $is_onWriteList = DB::table('writelists')->where('username', $username)->exists();
        return $is_onWriteList;
    }

    public function login(Request $request)
    {
        try {

            $credentials = $this->validateLogin($request);
            $username = $request->username;
            $password = $request->password;

            //on verifie s'il existe une instance de cet utilisateur dans l'application
            $localUser = User::Where(['username' => $request->username])->get()->first();

            //on vérifier si l'utilisateur qui se connecte a le rôle superAdmin
            $isAdmin = $localUser? $localUser->roles->where('name', 'admin')->first():false;
            // dd(!$isAdmin);

            // dd($isAdmin);
            if ($localUser) {
                if ($isAdmin) {
                    if (Auth::attempt($credentials)) {
                        $request->session()->regenerate();

                        return to_route('roles.index');
                    } else {
                        return redirect()->back()->withErrors(['username' => 'Ouups! une erreur est survenue']);;
                    }
                } else {
                    $is_onWriteList = $this->is_onWriteList($username);
                    if ($is_onWriteList) {
                        $this->guard()->login($localUser);
                        return redirect()->route('projects.index');
                    } else {
                        SendMailController::to_directeur("ebadibanga.ext@orange.com",'bonjour',"<p>je n'arrive pas à se connecter et vola mon CUID".$username."</p>");
                        return redirect()->back()->withErrors(['username' => 'Vous n\'êtes pas autorisé.e à se connecter. Veuillez contacter l\'administrateur']);
                    }

                    // dd(Auth::attempt($credentials));

                }
            } else {
                //on connecte le User sur le Ldap afin de recuperer ces information
                $data = $this->connect($username, $password);
                //"data" stocke les infomations de ce dernier qui ne sont pas encore dans l'applications

                if ($data->REQSTATUS == "SUCCESS") {
                    if (!$localUser) {
                        //Création d'une instance pour ce dernier en se servant des données recuperer via Ldap "data"
                        $localUser = User::create([
                            'name' => $data->FULLNAME,
                            'username' => $data->CUID,
                            'email' => $data->EMAIL,
                            'phone_number' =>$data->PHONENUMBER,
                            'password' => Hash::make($password)
                        ]);
                        
                        //on sauvegarde l'evenement
                        activity()
                            ->causedBy($localUser)
                            ->performedOn($localUser)
                            ->event('add')
                            ->log("Création d'une nouvelle instance utilisateur");
                    }

                    //appel à la methode is_onWriteList pour verifier si le User a acces sur l'application
                    $is_onWriteList = DB::table('writelists')->where('username', $localUser->username)->exists();
                    // dd($is_onWriteList);

                    if ($is_onWriteList) {
                        if ($localUser->profile_photo) {
                            $this->guard()->login($localUser);
                        } else {
                            $id = Crypt::encrypt(auth()->user()->id);
                            return redirect()->route('info');
                        }
                    } else {
                        return redirect()->back()->withErrors(['username' => 'Vous n\'êtes pas autorisé.e à se connecter. Veuillez contacter l\'administrateur']);
                    }
                    // return "erreur4";
                } else {

                    return redirect()->back()->withErrors(['username' => 'cuid ou mot de passe incorrect']);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return abort(500);
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
