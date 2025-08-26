<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::resource('/', HomeController::class)->name('reportes', '*');
Route::post('/reportes', [HomeController::class, 'store'])->name('reportes.store');
Route::get('/colonias/{municipio}/{cp}', [HomeController::class, 'getColonias']);
