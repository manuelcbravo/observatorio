<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::resource('/', HomeController::class)->name('reportes', '*');
Route::post('/reportes', [HomeController::class, 'store'])->name('reportes.store');
Route::get('/colonias/{municipio}/{cp}', [HomeController::class, 'getColonias']);
Route::get('/tablero', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/auth/{provider}', [HomeController::class, 'socialRedirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [HomeController::class, 'socialCallback'])->name('socialite.callback');
