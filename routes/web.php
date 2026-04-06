<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MessageController;


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
    Route::post('/documents/delete/{id}', [DocumentController::class, 'destroy'])->name('documents.delete');

    Route::get('/inbox', function () {
        return view('pages.inbox');
    })->name('inbox');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/patients', [PatientController::class, 'index'])->name('patients');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/chatsupport', function () {
        return view('pages.chatsupport');
    })->name('chatsupport');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});