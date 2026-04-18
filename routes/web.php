<?php
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public routes - Guest can view events (No login required)
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Authenticated routes only
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/registrations', [EventRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/create', [EventRegistrationController::class, 'create'])->name('registrations.create');
    Route::post('/registrations', [EventRegistrationController::class, 'store'])->name('registrations.store');
    Route::delete('/registrations/{registration}/cancel', [EventRegistrationController::class, 'cancel'])->name('registrations.cancel');
    
    // Admin only routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        
        Route::patch('/registrations/{registration}/approve', [EventRegistrationController::class, 'approve'])->name('registrations.approve');
        Route::patch('/registrations/{registration}/reject', [EventRegistrationController::class, 'reject'])->name('registrations.reject');
        Route::delete('/registrations/{registration}', [EventRegistrationController::class, 'destroy'])->name('registrations.destroy');
    });
});

require __DIR__.'/auth.php';

Route::get('/test-auth', function() {
    if (auth()->check()) {
        return 'Logged in as: ' . auth()->user()->email . ' | Role: ' . auth()->user()->role;
    }
    return 'Not logged in';
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    // ... other admin routes
});