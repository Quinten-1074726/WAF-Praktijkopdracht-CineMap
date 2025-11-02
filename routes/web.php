<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\WatchlistItemController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TitleController as AdminTitleController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\PlatformController as AdminPlatformController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
Public routes
*/
Route::get('/', [TitleController::class, 'index'])->name('home');

Route::redirect('/titles', '/');

// Publieke detailpagina
Route::get('/titles/{title}', [TitleController::class, 'show'])->name('titles.show');

/*
Auth routes 
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Profiel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Watchlist
    Route::resource('watchlist', WatchlistItemController::class)
        ->only(['index','store','update','destroy'])
        ->middleware('can:use-watchlist');
});

/*
Admin routes 
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'can:admin-access'])
    ->group(function () {

        // Admin dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Titles 
        Route::resource('titles', AdminTitleController::class);
        Route::post('titles/{title}/toggle-publish', [AdminTitleController::class, 'togglePublish'])
            ->name('titles.toggle-publish');

        // Platforms genres
        Route::resource('platforms', AdminPlatformController::class);
        Route::resource('genres', AdminGenreController::class);

        // Users
        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');

    });

require __DIR__.'/auth.php';
