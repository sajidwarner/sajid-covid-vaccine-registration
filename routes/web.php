<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('registration')->name('registration.')->group(function () {
    Route::get('/', [RegistrationController::class, 'index'])->name('index');
    Route::post('/', [RegistrationController::class, 'store'])->name('store');
});

Route::get('/search-schedule', [RegistrationController::class, 'search'])->name('search.schedule');

Route::get('/search', [RegistrationController::class, 'search'])->name('search');
