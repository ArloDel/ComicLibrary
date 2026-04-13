<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ComicController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ComicController::class, 'dashboard'])->name('dashboard');
    Route::resource('comics', ComicController::class);
    Route::resource('volumes', VolumeController::class)->except(['index', 'show']);
});
