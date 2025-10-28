<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\WatchlistItemController;
use Illuminate\Support\Facades\Route;

// Publieke routes
Route::get('/', fn() => view('home'))->name('home');
Route::resource('titles', TitleController::class)->only(['index', 'show']);

// Auth routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Profielbeheer
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-only routes
    Route::middleware('can:admin-access')->group(function () {
        Route::resource('titles', TitleController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('platforms', PlatformController::class);
        Route::resource('genres', GenreController::class);
    });

    // Watchlist voor gebruikers
    Route::resource('watchlist', WatchlistItemController::class)->only(['index', 'store', 'destroy']);
});

require __DIR__.'/auth.php';
