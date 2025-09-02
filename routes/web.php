<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return view('welcome');
});

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [RegisterController::class, 'create'])->name('auth.register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('auth.register.store');

    // Login
    Route::get('/login', [LoginController::class, 'show'])->name('auth.login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.attempt');

    // Forgot password (direct reset for testing)
    Route::get('/forgot-password', [ResetPasswordController::class, 'showDirectForm'])->name('reset.direct.form');
    Route::post('/forgot-password', [ResetPasswordController::class, 'resetDirect'])->name('reset.direct.submit');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('auth.logout');

    // Gmail sections
    Route::get('/inbox', fn() => view('inbox'))->name('inbox');
    Route::get('/sent', fn() => view('sent'))->name('sent');
    Route::get('/favorites', fn() => view('favorites'))->name('favorites');

    Route::get('/compose', fn() => view('compose'))->name('compose');

    Route::get('/compose', [MailController::class, 'create'])->name('compose');
    Route::post('/compose', [MailController::class, 'store'])->name('compose.send');

    Route::get('/inbox', [MailController::class, 'inbox'])->name('inbox');
    Route::get('/sent', [MailController::class, 'sent'])->name('sent');
    Route::get('/favorites', [MailController::class, 'favorites'])->name('favorites');
    Route::get('/trash', [MailController::class, 'trash'])->name('trash');
    Route::post('/mail/{id}/favorite', [MailController::class, 'toggleFavorite'])->name('mail.favorite');
    Route::delete('/mail/{mail}', [MailController::class, 'destroy'])->name('mail.delete');          // move to Trash (soft delete)
    Route::patch('/mail/{mail}/restore', [MailController::class, 'restore'])->name('mail.restore');  // restore from Trash
    Route::delete('/mail/{mail}/force', [MailController::class, 'forceDelete'])->name('mail.force'); // permanent delete (optional)

});


Route::middleware('auth')->group(function () {
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox');
});
