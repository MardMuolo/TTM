<?php

use App\Models\Demande;
use App\Models\CategoryDemande;
use App\Http\Controllers\Approuving;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\DemandeJalonController;

Route::middleware(['auth'])->group(function () {
    Route::resource('projects', App\Http\Controllers\ProjectController::class);
    Route::resource('projects/{id}/membres', App\Http\Controllers\ProjectUserController::class);
    Route::resource('demande', App\Http\Controllers\DemandeController::class);
    Route::resource('demandeJalon', DemandeJalonController::class);
    Route::resource('categoryDemandes', App\Http\Controllers\CategoryDemandeController::class);
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
    Route::resource('contributeur', App\Http\Controllers\ProjectUserController::class);
    Route::resource('approuving', Approuving::class);
    Route::resource('approbationCollaborateur', App\Http\Controllers\ApprobationCollaboController::class);
    Route::resource('approbationLivrable', App\Http\Controllers\ApprobationLivrableController::class);
    Route::get('projets/dates/{project}', [App\Http\Controllers\ProjectController::class, 'addDates'])->name('projects.dates');
    Route::get('project', [App\Http\Controllers\ProjectController::class, 'getProjectToRepport'])->name('projectReporting');
    Route::get('/telecharger-projet/{project}', [App\Http\Controllers\ProjectController::class,'telechargerProjet'])->name('telecharger');
    Route::get('/getUser', [App\Http\Controllers\UserController::class,'getUsers'])->name('getUsers');
});
