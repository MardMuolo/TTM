<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportingController;
Route::get('dashboard', [ReportingController::class, 'index'])->name('dashboard.index');
Route::get('rapport', [ReportingController::class, 'rapport'])->name('rapport.index');

Route::get('dashboard', [ReportingController::class, 'index'])->name('dashboard.index');
Route::get('rapport', [ReportingController::class, 'rapport'])->name('rapport.index');

// Route::get('rapport', ReportingController::class, function() {
//     return view('reporting.rapport');
// });
// Route::resource('rapport', ReportingController::class);
