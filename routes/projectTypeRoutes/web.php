<?php

use App\Http\Controllers\ProjectTypeController;
use Illuminate\Support\Facades\Route;

Route::resource('projectType', ProjectTypeController::class);