<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Index route
Route::get('/', [AuthController::class, 'showLogin']);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Extra validation form after email verification
Route::get('/register1', [VerificationController::class, 'showForm'])->name('register1.form');
Route::post('/register1', [VerificationController::class, 'submitForm'])->name('register1.submit');

// Dashboards (only for verified users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin-dashboard');
    });

    Route::get('/user-dashboard', function () {
        return view('user-dashboard');
    });
});

// Email verification routes
Route::middleware(['auth'])->group(function () {
    // Show the email verification notice
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    // Handle the email verification link
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // Marks user as verified

        return redirect('/login'); // or /user-dashboard based on your flow
    })->middleware(['signed'])->name('verification.verify');

    // Resend the verification email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');
});
// routes/web.php
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
