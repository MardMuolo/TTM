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
use App\Http\Controllers\SendMailController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\SoapServiceController;
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

    public function loginAfterOtp(Request $request){

        $this->validateOtp($request);
        $localUser =  $request->session()->get('localUser');
        
        
        $array = $request->session()->get('array');

        $otp_body = [
            "reference"=>$array->PHONENUMBER==null?$array->EMAIL:str_replace(' ','',$array->PHONENUMBER),
            "origin"=>$array->PHONENUMBER==null?env('OTP_ORIGIN_MAIL'):env('OTP_ORIGIN'),
            "receivedOtp"=>$request->otp,
            "ignoreOrangeNumbers"=>false
        ];

        $otp_body = json_encode($otp_body);
        $request_ldap = new SoapServiceController();
        $otp = $request_ldap->postJsonCheckOtp($otp_body);

        if($otp->diagnosticResult==true){
            if ($localUser==null) {
                $localUser = User::create([
                    'name' => $array->FULLNAME,
                    'username' => $array->CUID,
                    'email' => $array->EMAIL,
                    'phone' => $array->PHONENUMBER==null?'':$array->PHONENUMBER,
                    'password' => Hash::make("password"),
                    'profil_complete' => false,
                    'status' =>1,
                ]);
    
                activity()
                        ->causedBy($localUser)
                        ->performedOn($localUser)
                        ->event('add')
                        ->log("Création d'une nouvelle instance utilisateur");
            }
    
            
                
                    $this->guard()->login($localUser);
                    
                    if ($localUser->line_manager) {
                        // dd($localUser);
                        return redirect()->route('projects.index');
                    }else{
                        // dd($localUser);
                        return to_route('info');
                    }
    
                return $this->sendLoginResponse($request);
        }else{
            return redirect()->back()->with('error','Code incorrect');
        }


    }

    
    public function otp(Request $request){
        $send_type = $request->session()->get('send_type');
        $ref = $request->session()->get('ref');
        $array = $request->session()->get('array');

    
        return view('auth.otp',compact('send_type', 'ref', 'array'));
    }

    protected function validateOtp(Request $request)
    {
        return $request->validate([
            'otp' => 'required|string',
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

    // public function login(Request $request)
    // {
    //     $request_ldap = new SoapServiceController();
    //     try {

    //         $credentials = $this->validateLogin($request);
    //         $username = $request->username;
    //         $password = $request->password;

    //         //on verifie s'il existe une instance de cet utilisateur dans l'application
    //         $localUser = User::Where(['username' => $request->username])->get()->first();

    //         //on vérifier si l'utilisateur qui se connecte a le rôle superAdmin
    //         $isAdmin = $localUser ? $localUser->roles->where('name', 'admin')->first() : false;
    //         // dd(!$isAdmin);

    //         // dd($isAdmin);
    //         if ($localUser) {
    //             if ($isAdmin) {
    //                 if (Auth::attempt($credentials)) {
    //                     $request->session()->regenerate();

    //                     return to_route('roles.index');
    //                 } else {
    //                     return redirect()->back()->withErrors(['username' => 'Ouups! une erreur est survenue']);;
    //                 }
    //             } else {
    //                 $is_onWriteList = $this->is_onWriteList($username);
    //                 if ($is_onWriteList) {

    //                     $otp_body = [
    //                         "reference"=>$localUser->phone_number==null?$localUser->email:str_replace(' ','',$localUser->phone_number),
    //                         "origin"=>$localUser->phone_number==null?env('OTP_ORIGIN_MAIL'):env('OTP_ORIGIN'),
    //                         "otpOveroutTime"=>300000,
    //                         "customMessage"=>"Cher client, {{otpCode}} est votre code OTP. Revenez sur notre plateforme et saisissez-le pour vous connecter.",
    //                         "senderName"=>$localUser->phone_number==null?env('OTP_ORIGIN_MAIL'):env('OTP_ORIGIN'),
    //                         "ignoreOrangeNumbers"=>false
    //                     ];

    //                     $otp_body = json_encode($otp_body);
    //                     $otp = $request_ldap->postJsonRequest($otp_body);
    //                     if($otp->code==200){
    //                         $request->session()->put('send_type', $localUser->phone_number==null?'e-mail':'SMS');
    //                         $request->session()->put('ref', $localUser->phone_number==null?$localUser->email:$localUser->phone_number);
    //                         $request->session()->put('localUser',$localUser);
    //                         $request->session()->put('array',$localUser);
                        
    //                         return redirect()->to('otp');
    //                     }else{
    //                         return $this->sendFailedLoginResponse($request, "Echec de l'opération OTP");
    //                     }
                        
    //                 } else {
    //                     SendMailController::to_directeur("ebadibanga.ext@orange.com", 'bonjour', "<p>je n'arrive pas à se connecter et vola mon CUID" . $username . "</p>");
    //                     return redirect()->back()->withErrors(['username' => 'Vous n\'êtes pas autorisé.e à se connecter. Veuillez contacter l\'administrateur']);
    //                 }

    //                 // dd(Auth::attempt($credentials));

    //             }
    //         } else {
    //             //on connecte le User sur le Ldap afin de recuperer ces information
    //             $data = $this->connect($username, $password);
    //             //"data" stocke les infomations de ce dernier qui ne sont pas encore dans l'applications

    //             if ($data->REQSTATUS == "SUCCESS") {
    //                 if (!$localUser) {
    //                     //Création d'une instance pour ce dernier en se servant des données recuperer via Ldap "data"
    //                     $localUser = User::create([
    //                         'name' => $data->FULLNAME,
    //                         'username' => $data->CUID,
    //                         'email' => $data->EMAIL,
    //                         'phone_number' => $data->PHONENUMBER,
    //                         'password' => Hash::make($password)
    //                     ]);

    //                     //on sauvegarde l'evenement
    //                     activity()
    //                         ->causedBy($localUser)
    //                         ->performedOn($localUser)
    //                         ->event('add')
    //                         ->log("Création d'une nouvelle instance utilisateur");
    //                 }

    //                 //appel à la methode is_onWriteList pour verifier si le User a acces sur l'application
    //                 $is_onWriteList = DB::table('writelists')->where('username', $localUser->username)->exists();
    //                 // dd($is_onWriteList);

    //                 if ($is_onWriteList) {
    //                     if ($localUser->profile_photo) {
    //                         $this->guard()->login($localUser);
    //                     } else {
    //                         $id = Crypt::encrypt(auth()->user()->id);
    //                         return redirect()->route('info');
    //                     }
    //                 } else {
    //                     SendMailController::to_directeur("ebadibanga.ext@orange.com", 'bonjour', "<p>je n'arrive pas à se connecter et vola mon CUID" . $username . "</p>");
    //                     return redirect()->back()->withErrors(['username' => 'Vous n\'êtes pas autorisé.e à se connecter. Veuillez contacter l\'administrateur']);
    //                 }
    //                 // return "erreur4";
    //             } else {

    //                 return redirect()->back()->withErrors(['username' => 'cuid ou mot de passe incorrect']);
    //             }
    //         }
    //     } catch (Exception $e) {
    //         Log::error($e);
    //         return abort(500);
    //     }
    // }

    public function login(Request $request)
    {
        
        $this->validateLogin($request);

        $username = $request->username;
        $password = $request->password;
       
        $localUser = User::where('username', $username)->first();
        // dd($localUser);
        if ($localUser && $localUser->roles->where('name', env('RootAdmin'))->first() && Hash::check($password, $localUser->password)) {
            $this->guard()->login($localUser);
            return redirect()->route('roles.index');
        }


        // if($localUser){
        // //      //$this->guard()->login($localUser);
        // if ($localUser->status == 1) {
        //          $this->guard()->login($localUser);
        //      } else {
        //          return $this->sendFailedLoginResponse($request, "Votre compte est inactif. Vaillez Contactez l'administrateur.");
        //      }
            
        //      if (!$localUser->profil_complete) {
        //           $id = Crypt::encrypt(auth()->user()->id);
        //          return redirect()->route('profile.edit', $id);
        //      }
        //      return redirect()->route('home');
        //   }

        try{

            $request_ldap = new SoapServiceController();
            $request_body = '<?xml version="1.0"?>
            <COMMAND>
                   <TYPE>AUTH_SVC</TYPE>
                   <APPLINAME>OrangeBadge</APPLINAME>
                   <CUID>'.$username.'</CUID>
                   <PASSWORD>'.$password.'</PASSWORD>
                   <DATE>'.Carbon::now().'</DATE>       
           </COMMAND>';

           $result = $request_ldap->postXmlRequest($request_body);

            $xml = simplexml_load_string($result);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            $array = (object)$array;

            
            // if($array->PHONENUMBER == null){
            //     dd($array->PHONENUMBER[0]);
            // }else{
            //     dd($array->PHONENUMBER);
            // }
            

            if ($array->REQSTATUS == "SUCCESS") {

                $is_onWriteList = $this->is_onWriteList($username);
                
                if ($is_onWriteList) {
                    $otp_body = [
                        "reference"=>$array->PHONENUMBER==null?$array->EMAIL:str_replace(' ','',$array->PHONENUMBER),
                        "origin"=>$array->PHONENUMBER==null?env('OTP_ORIGIN_MAIL'):env('OTP_ORIGIN'),
                        "otpOveroutTime"=>300000,
                        "customMessage"=>"Cher client, {{otpCode}} est votre code OTP. Revenez sur notre plateforme et saisissez-le pour vous connecter.",
                        "senderName"=>$array->PHONENUMBER==null?env('OTP_ORIGIN_MAIL'):env('OTP_ORIGIN'),
                        "ignoreOrangeNumbers"=>false
                    ];

                    $otp_body = json_encode($otp_body);
                    $otp = $request_ldap->postJsonRequest($otp_body);
                    if($otp->code==200){
                        $request->session()->put('send_type', $array->PHONENUMBER==null?'e-mail':'SMS');
                        $request->session()->put('ref', $array->PHONENUMBER==null?$array->EMAIL:$array->PHONENUMBER);
                        $request->session()->put('localUser',$localUser);
                        $request->session()->put('array',$array);

                    
                        return redirect()->to('otp');
                    }else{
                        return $this->sendFailedLoginResponse($request, "Echec de l'opération OTP");
                    }
                } else {
                    SendMailController::to_directeur("ebadibanga.ext@orange.com", 'bonjour', "<p>je n'arrive pas à se connecter et vola mon CUID" . $username . "</p>");
                    return redirect()->back()->withErrors(['username' => 'Vous n\'êtes pas autorisé.e à se connecter. Veuillez contacter l\'administrateur']);
                }

            } else {

                return $this->sendFailedLoginResponse($request, "Nom d'utilisateur ou mot de passe invalide");
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            
            return $this->sendFailedLoginResponse($request, "Echec de l'opération");
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
