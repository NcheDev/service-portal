<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\IndividualApplicationController;
use App\Http\Controllers\InstitutionApplicationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/create', [UserProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [UserProfileController::class, 'store'])->name('profile.store');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile/create', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
});

Route::middleware(['auth'])->group(function () {

    // Application selection
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications/create', [ApplicationController::class, 'store'])->name('applications.store');

    // Individual applications
    Route::get('/applications/individual', [ApplicationController::class, 'individualIndex'])->name('applications.individual.index');

    // Institution applications
    Route::get('/applications/institution', [ApplicationController::class, 'institutionIndex'])->name('applications.institution.index');

    // Optional: generic show route
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
});

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/applications/{application}/individual',
        [IndividualApplicationController::class, 'create']
    )->name('applications.individual.create');

    Route::post(
        '/applications/{application}/individual',
        [IndividualApplicationController::class, 'store']
    )->name('applications.individual.store');

});
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/applications/{application}/documents',
        [DocumentController::class, 'create']
    )->name('applications.documents.create');

    Route::post(
        '/applications/{application}/documents',
        [DocumentController::class, 'store']
    )->name('applications.documents.store');

});

Route::get(
    '/documents/{document}/download',
    [DocumentController::class, 'download']
)->name('documents.download');


Route::middleware(['auth'])->group(function () {

    Route::get(
        '/applications/{application}/institution',
        [InstitutionApplicationController::class, 'create']
    )->name('applications.institution.create');

    Route::post(
        '/applications/{application}/institution',
        [InstitutionApplicationController::class, 'store']
    )->name('applications.institution.store');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get(
    '/applications/institution/{application}',
    [InstitutionApplicationController::class, 'show']
)->name('applications.institution.show');

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/applications/{application}/preview',
        [ApplicationController::class, 'preview']
    )->name('applications.preview');

    Route::post(
        '/applications/{application}/submit',
        [ApplicationController::class, 'submit']
    )->name('applications.submit');

});

Route::get(
    '/applications/{application}/resume',
    [ApplicationController::class, 'resume']
)->name('applications.resume');

Route::middleware(['auth'])->group(function () {
    Route::get(
        '/applications/individual/{application}',
        [IndividualApplicationController::class, 'show']
    )->name('applications.individual.show');
});

require __DIR__.'/auth.php';
