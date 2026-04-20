<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ComicController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiProxyController;
use App\Http\Controllers\MarketController;

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
    Route::get('/pasar', [MarketController::class, 'index'])->name('market.index');

    // API Proxy routes (server-side calls to avoid CORS)
    Route::get('/api-proxy/narrative',   [ComicController::class, 'narrativeReport'])->name('api.narrative');
    Route::get('/api-proxy/mangadex',    [ApiProxyController::class, 'mangadex'])->name('proxy.mangadex');
    Route::get('/api-proxy/anilist',     [ApiProxyController::class, 'anilist'])->name('proxy.anilist');
    Route::get('/api-proxy/googlebooks', [ApiProxyController::class, 'googlebooks'])->name('proxy.googlebooks');
    Route::get('/api-proxy/openlibrary', [ApiProxyController::class, 'openlibrary'])->name('proxy.openlibrary');
});
