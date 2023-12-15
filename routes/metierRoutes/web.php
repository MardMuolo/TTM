<?php

use App\Http\Controllers\MetierController;
use Illuminate\Support\Facades\Route;

Route::resource('metiers', MetierController::class);