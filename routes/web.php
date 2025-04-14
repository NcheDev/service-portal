<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController; 

//index route
Route::get('/', [AuthController::class, 'showLogin']);


Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
});
Route::get('/user-dashboard', function () {
    return view('user-dashboard');
});



//login route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//logout 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



//registration route
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class,  'register']);

//apply for validation route


Route::get('/register1', [VerificationController::class, 'showForm'])->name('register1.form');
Route::post('/register1', [VerificationController::class, 'submitForm'])->name('register1.submit');
