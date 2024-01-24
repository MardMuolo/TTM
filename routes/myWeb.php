<?php

use App\Models\Demande;
use App\Models\CategoryDemande;
use App\Http\Controllers\Approuving;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AchivageController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\DemandeJalonController;
use App\Http\Controllers\ProjectFilterControlle;
use App\Http\Controllers\ProjectFilterController;
use App\Http\Controllers\CategoryDemandeController;
use App\Http\Controllers\ApprobationCollaboController;
use App\Http\Controllers\ApprobationLivrableController;

Route::middleware(['auth'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::resource('projects/{id}/membres', ProjectUserController::class);
    Route::resource('demande', DemandeController::class);
    Route::resource('demandeJalon', DemandeJalonController::class);
    Route::resource('categoryDemandes', CategoryDemandeController::class);
    Route::get('/fetch-demandes', function (Request $request) {
        $term = $request->$request->input('term');

        $demandes = Demande::where('titre', 'like', '%'.$term.'%')->pluck('titre');

        return response()->json($demandes);
    });
    Route::get('/fetch-categories', function (Request $request) {
        $term = $request->input('term');

        $categories = CategoryDemande::where('title', 'like', '%'.$term.'%')->pluck('title');

        return response()->json($categories);
    });
    Route::resource('contributeur', ProjectUserController::class);
    Route::resource('approuving', Approuving::class);
    Route::resource('approbationCollaborateur', ApprobationCollaboController::class);
    Route::resource('approbationLivrable', ApprobationLivrableController::class);
    Route::get('projets/dates/{project}', [ProjectController::class, 'addDates'])->name('projects.dates');
    Route::get('project', [ProjectController::class, 'getProjectToRepport'])->name('projectReporting');
    Route::get('/telecharger-projet/{project}', [ProjectController::class,'telechargerProjet'])->name('telecharger');



    Route::resource('archivage',AchivageController::class);
    Route::get('filtrage/{status}',[ProjectFilterController::class,'index'])->name('filtrage');
    
    Route::get('/getUser', [UserController::class,'getUsers'])->name('getUsers');
    Route::get('get_projectBy',[ProjectFilterController::class,'get_projectBy'])->name('get_projectBy');
});
