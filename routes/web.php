<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
@include 'myWeb.php';
@include 'webAcl.php';

Route::get('/', function () {
    // dd(Auth::user()->roles[0]->name);
    $routes=[
        env('TtmOfficer')=>"route('home')",
        env('Pm')=>route('projects.index'),
        env('User')=>route('projects.index'),
        env('Directeur')=>route('approbationCollaborateur.index'),
        env('AdminSys')=> route('users.index'),
    ];
    
    return redirect($routes[Auth::user()->roles[0]->name]);
});
@include('metierRoutes/web.php');
@include 'complexityRoutes/web.php';
@include 'optionTtmRoutes/web.php';
@include 'reporting/web.php';

@include 'authRoutes/wep.php';
@include 'projectTypeRoutes/web.php';
@include 'directionRoutes/web.php';
@include 'messagesMailsRoutes/web.php';
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


