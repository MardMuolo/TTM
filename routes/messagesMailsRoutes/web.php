<?php

use App\Http\Controllers\MessageMailController;
use Illuminate\Support\Facades\Route;

Route::resource('messagesMails', MessageMailController::class);