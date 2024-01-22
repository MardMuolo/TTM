<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Création du rôle 'admin'

        // Création de l'utilisateur admin
        // $admin = DB::table('users')->insertGetId([
        //     'name' => env('RootAdmin'),
        //     'email' => 'admin@example.com',
        //     'username' => env('RootAdmin'),
        //     'phone_number' => '0840000000',
        //     'password' => Hash::make(env('ADMIN_PASS')),
        // ]);

        // // Ajout du rôle 'admin' à l'utilisateur admin
        // $role = Role::where('name', env('RootAdmin'))->first();
        // if ($role) {
        //     $user = User::find($admin);
        //     $user->roles()->attach($role);
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Suppression de l'utilisateur admin
        DB::table('users')->where('email', 'admin@example.com')->delete();

        // Suppression du rôle 'admin'
        DB::table('roles')->where('name', 'admin')->delete();
    }
};
