<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/registrations', [EventRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/create', [EventRegistrationController::class, 'create'])->name('registrations.create');
    Route::post('/registrations', [EventRegistrationController::class, 'store'])->name('registrations.store');
    Route::patch('/registrations/{registration}/cancel', [EventRegistrationController::class, 'cancel'])->name('registrations.cancel');

    // Admin only routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        Route::patch('/registrations/{registration}/approve', [EventRegistrationController::class, 'approve'])->name('registrations.approve');
        Route::patch('/registrations/{registration}/reject', [EventRegistrationController::class, 'reject'])->name('registrations.reject');
        Route::patch('/registrations/{registration}/archive', [EventRegistrationController::class, 'archive'])->name('registrations.archive');

        // Team management
        Route::get('/events/{event}/teams', [TeamController::class, 'index'])->name('teams.index');
        Route::post('/events/{event}/teams', [TeamController::class, 'store'])->name('teams.store');
        Route::post('/events/{event}/teams/assign', [TeamController::class, 'assign'])->name('teams.assign');
        Route::delete('/events/{event}/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
        Route::patch('/events/{event}/registrations/{registration}/unassign', [TeamController::class, 'unassign'])->name('teams.unassign');
        Route::get('/events/{event}/teams/validate', [TeamController::class, 'validateTeams'])->name('teams.validate');
    });
});

// Wildcard route LAST
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

require __DIR__.'/auth.php';