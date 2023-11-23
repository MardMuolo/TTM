<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JalonController;
use App\Http\Controllers\LivrableController;
use App\Http\Controllers\OptionTtmController;
use App\Http\Controllers\ValidationController;

Route::middleware(['auth'])->group(function(){
    Route::resource('optionsttm', OptionTtmController::class);
    Route::resource('jalons', JalonController::class);
    Route::resource('livrables', LivrableController::class);
    Route::resource('validations', ValidationController::class);
    Route::get('/jalons/{jalon}/optionttm/{option_ttm}/project/{project}', [JalonController::class,'single'])->name('jalons.single');
    Route::post('/jalons/{jalon}/optionttm/{option_ttm}/project/{project}/add-date',  [JalonController::class,'addDate'])->name('jalons.addDate');
    Route::put('/jalons/{jalon}/option_ttm/{option_ttm}/project/{project}/repouser-date', [JalonController::class,'repouserDate'])->name('repouserDate');
    Route::put('/jalons/{jalon}/optionttm/{option_ttm}/project/{project}/update-status', [JalonController::class, 'updateStatus'])->name('jalons.updateStatus');
    Route::get('/jalon/demande/{demande}', [JalonController::class, 'show_demande'])->name('show_demande');
    Route::put('/livrable/{livrable}', [LivrableController::class, 'valider_livrable'])->name('valider_livrable');

});

Auth::routes();