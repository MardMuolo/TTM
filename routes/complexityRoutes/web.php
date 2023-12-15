<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplexityItemController;
use App\Http\Controllers\ComplexityTargetController;

Route::resource('ComplexityItem', ComplexityItemController::class);
Route::resource('ComplexityTarget', ComplexityTargetController::class);