<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ComicController;
use App\Http\Controllers\VolumeController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [ComicController::class, 'dashboard'])->name('dashboard');
Route::resource('comics', ComicController::class);
Route::resource('volumes', VolumeController::class)->except(['index', 'show']);
