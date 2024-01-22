<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

//Route::middleware('auth')->group([
Route::get('/info', [RegisterController::class, 'edit'])->name('info')->middleware('auth');
Route::post('/info-supplementaire/update', [RegisterController::class, 'update'])->name('update-user-info')->middleware('auth');
Route::get('/profile/{id}', [RegisterController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/otp', [LoginController::class, 'otp'])->name('otp');
Route::post('/after-otp', [LoginController::class,'loginAfterOtp'])->name('loginAfterOtp');

//]);


