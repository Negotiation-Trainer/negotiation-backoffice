<?php

use App\Http\Controllers\GameDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokenController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/games', [GameDashboardController::class, 'index'])->name('game-sessions');
    Route::get('/game/create', [GameDashboardController::class, 'create'])->name('game-session.create');
    Route::post('/game', [GameDashboardController::class, 'store'])->name('game-session.store');
    Route::get('/game/{id}', [GameDashboardController::class, 'show'])->name('game-session.show');
    Route::patch('/game/{id}', [GameDashboardController::class, 'update'])->name('game-session.update');

    Route::get('/game/{id}/config', [GameDashboardController::class, 'config'])->name('game-session.config');
    Route::patch('/game/{id}/config', [GameDashboardController::class, 'updateConfig'])->name('game-session.config.update');

    Route::get('/costs', [GameDashboardController::class, 'costs'])->name('costs');


    Route::delete('/token/{token}', [TokenController::class, 'revoke'])->name('token.revoke');

});

require __DIR__.'/auth.php';
