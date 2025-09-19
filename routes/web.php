<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/about', fn () => view('about'))->name('about');

// Calendar
Route::get('/tournaments/calendar', [TournamentController::class, 'calendar'])
    ->name('tournaments.calendar');
Route::get('/tournaments/day/{date}', [TournamentController::class, 'dayTournaments'])
    ->name('tournaments.day');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tournaments
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
        Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');

    Route::get('/tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');
    Route::post('/tournaments/{tournament}/join', [TournamentController::class, 'join'])->name('tournaments.join');

    // Admin-only routes for tournaments (check admin in controller)
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('/tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::put('/tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('/tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

    
Route::post('/tournaments/{tournament}/start', [TournamentController::class, 'start'])->name('tournaments.start');
Route::post('/tournaments/{tournament}/stop', [TournamentController::class, 'stop'])
    ->name('tournaments.stop');
Route::get('/tournaments/{tournament}/stats', [TournamentController::class, 'stats'])->name('tournaments.stats');
Route::patch('/tournaments/{tournament}/matches/{match}/score', [TournamentController::class, 'updateMatchScore'])
    ->name('tournaments.updateMatchScore');


    // News
    Route::resource('news', NewsController::class);

    // Admin panel (check admin in controller)
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

require __DIR__.'/auth.php';
