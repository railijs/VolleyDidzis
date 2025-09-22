<?php 

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentApplicationController;
use App\Http\Controllers\TournamentMatchController;
use App\Http\Controllers\TournamentProgressController;
use App\Http\Controllers\TournamentStatsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', fn () => view('welcome'));

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// About
Route::get('/about', fn () => view('about'))->name('about');

// Tournament calendar & day view (public)
Route::get('/tournaments/calendar', [TournamentController::class, 'calendar'])
    ->name('tournaments.calendar');
Route::get('/tournaments/day/{date}', [TournamentController::class, 'dayTournaments'])
    ->name('tournaments.day');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tournament CRUD
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('/tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::put('/tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('/tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

    // Join tournament
    Route::post('/tournaments/{tournament}/join', [TournamentApplicationController::class, 'join'])->name('tournaments.join');

    // Tournament progress
    Route::post('/tournaments/{tournament}/start', [TournamentProgressController::class, 'start'])->name('tournaments.start');
    Route::post('/tournaments/{tournament}/stop', [TournamentProgressController::class, 'stop'])->name('tournaments.stop');

    // Tournament stats
    Route::get('/tournaments/{tournament}/stats', [TournamentStatsController::class, 'stats'])->name('tournaments.stats');

    // Match scoring
    Route::patch(
        '/tournaments/{tournament}/matches/{match}/score',
        [TournamentMatchController::class, 'updateScore']
    )->name('tournaments.updateMatchScore');

    // Show single tournament (keep last so it doesn’t conflict with edit/stats)
    Route::get('/tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');

    // News
    Route::resource('news', NewsController::class);

    // Admin panel (check admin in controller)
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])
    ->name('admin.users.updateRole');
});

require __DIR__.'/auth.php';
