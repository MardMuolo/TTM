<?php

use App\Http\Controllers\DirectionController;
use Illuminate\Support\Facades\Route;

Route::resource('directions', DirectionController::class);