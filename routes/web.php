<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CareNoteController;
use App\Http\Controllers\ChatSupportController;

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
*/

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Dashboard (no middleware needed)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [DashboardController::class, 'exportData'])->name('dashboard.export');

    // ---------------------------
    // Middleware for Caregivers only
    // ---------------------------
    Route::middleware('caregiver')->group(function () {
        Route::get('/patients', [PatientController::class, 'index'])->name('patients');
        Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
        Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

        // Care Plans Module (Caregiver)
        Route::get('/careplans/select', [CareNoteController::class, 'selectPatient'])->name('careplans.select');

        Route::prefix('patients/{patientId}/careplans')->group(function () {
            Route::get('/', [CareNoteController::class, 'index'])->name('careplans.index');
            Route::get('/create', [CareNoteController::class, 'create'])->name('careplans.create');
            Route::post('/', [CareNoteController::class, 'store'])->name('careplans.store');
            Route::delete('/{id}', [CareNoteController::class, 'destroy'])->name('careplans.destroy');
        });
    });

    // ---------------------------
    // Shared authenticated routes (no middleware needed)
    // ---------------------------
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
    Route::post('/documents/delete/{id}', [DocumentController::class, 'destroy'])->name('documents.delete');

    Route::get('/inbox', fn() => view('pages.inbox'))->name('inbox');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/chatsupport', [ChatSupportController::class, 'index'])->name('chatsupport');
    Route::post('/chatsupport/send', [ChatSupportController::class, 'sendMessage'])->name('chatsupport.send');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ---------------------------
    // Admin and Clinician routes
    // ---------------------------
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
