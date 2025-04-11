<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/charts', function () {
    return view('pages.charts.chartjs');
});
Route::get('/login', function () {
    return view('pages.samples.login');
})->name('login');
