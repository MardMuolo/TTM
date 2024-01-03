<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $modelFiles = File::files(app_path('Models'));
        foreach ($modelFiles as $file) {
            $models[] = pathinfo($file)['filename'];
        }
        $models = [];

        return view('users.index', compact(['models']))->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Role $role)
    {
        /*  if(Gate::denies('edit-users')){
             return redirect()->route('users.index');
         } */
        $roles = role::all();

        return view('users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('users.index');
    }

    public function getUsers(Request $request)
    {
        $adServer 		= "OPADCOCD04.orangerdc.cd";
        $adUser			= "LVBG0520";
        $adPass			= "Emm@bdb0520";
        $ldapConn 		= ldap_connect($adServer) or die ("Impossible de se connecter Ã  l'AD : {$adServer}") ;
        ldap_set_option($ldapConn,LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($ldapConn,LDAP_OPT_REFERRALS,0);
        $ldapBind 		= ldap_bind($ldapConn, $adUser, $adPass);
        // dd($ldapConn);
        $person			= "*ng*";
        $filter 		= "(&(objectCategory=person)(objectClass=user)(|(sn={$person})(displayname={$person})))";
        $attributes = array("sAMAccountName","cn", "mail");
        $ldapResult 	= ldap_search($ldapConn,"DC=ORANGERDC,DC=CD",$filter, $attributes);
        $ldapEntries 	= ldap_get_entries($ldapConn,$ldapResult);
        $Tot            = count($ldapEntries);
        ldap_close($ldapConn);
        $users=[];
        for ($i=0; $i < $Tot-1; $i++) { 
            if(isset($ldapEntries[$i]['mail'][0])){
                $users[]= [
                    'id' => count($users)+1,
                    'username' => $ldapEntries[$i]['samaccountname'][0],
                    'name' => $ldapEntries[$i]['cn'][0],
                    'email' => $ldapEntries[$i]['mail'][0],
                    'phone' => '124567890',
                ];
            }
           
        }
        
        // $users = [
        //     [
        //         'id' => 1,
        //         'username' => 'emmanuelbdb',
        //         'first_name' => 'emmanuel',
        //         'last_name' => 'badibanga',
        //         'email' => 'ebadibanga.ext@orange.com',
               
                
        //     ],
        //     [
        //         'id' => 2,
        //         'username' => 'momo',
        //         'first_name' => 'mardochee',
        //         'last_name' => 'muolo',
        //         'email' => 'mmuolo.ext@orange.com',
        //         'phone' => '986543210',
        //     ],
        //     [
        //         'id' => 3,
        //         'username' => 'michael',
        //         'first_name' => 'michael',
        //         'last_name' => 'nyinzi',
        //         'email' => 'mnyinzi.ext@orange.com',
        //         'phone' => '456890123',
        //     ],
        //     [
        //         'id' => 4,
        //         'username' => 'choupole',
        //         'first_name' => 'franck',
        //         'last_name' => 'kapuya',
        //         'email' => 'fkapuya.ext@orange.com',
        //         'phone' => '789123456',
        //     ],
        //     [
        //         'id' => 5,
        //         'username' => 'channel',
        //         'first_name' => 'pierrot',
        //         'last_name' => 'nsiemwe',
        //         'email' => 'cnsiemwe.ext@orange.com',
        //         'phone' => '234678901',
        //     ],
        //     [
        //         'id' => 6,
        //         'username' => 'chist',
        //         'first_name' => 'katumba',
        //         'last_name' => 'katumba',
        //         'email' => 'ckatumba.ext@orange.com',
        //         'phone' => '901245678',
        //     ],
        //     [
        //         'id' => 7,
        //         'username' => 'davidwilson',
        //         'first_name' => 'David',
        //         'last_name' => 'Wilson',
        //         'email' => 'davidwilson.ext@orange.com',
        //         'phone' => '567801234',
        //     ],
        //     [
        //         'id' => 8,
        //         'username' => 'emilythomas',
        //         'first_name' => 'Emily',
        //         'last_name' => 'Thomas',
        //         'email' => 'emilythomas.ext@orange.com',
        //         'phone' => '432198765',
        //     ],
        //     [
        //         'id' => 9,
        //         'username' => 'tomwright',
        //         'first_name' => 'Tom',
        //         'last_name' => 'Wright',
        //         'email' => 'tomwright.ext@orange.com',
        //         'phone' => '8765432109',
        //     ],
        //     [
        //         'id' => 10,
        //         'username' => 'lauramiller',
        //         'first_name' => 'Laura',
        //         'last_name' => 'Miller',
        //         'email' => 'lauramiller.ext@orange.com',
        //         'phone' => '1098765432',
        //     ],
        //     [
        //         'id' => 10,
        //         'username' => 'rootadmin',
        //         'first_name' => 'rootadmin',
        //         'last_name' => 'rootadmin',
        //         'email' => 'admin@example.com   ',
        //         'phone' => '0844297349',
        //     ],
        // ];

        $formattedData = collect($users)->map(function ($user) {
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
            ];
        });
    
        $response = [
            'status' => 'success',
            'code' => Response::HTTP_OK,
            'body' => $formattedData,
        ];
    
        return response()->json($response, Response::HTTP_OK);
}}
