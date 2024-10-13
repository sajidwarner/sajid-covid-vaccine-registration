<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::controller(RegistrationController::class)->group(function () {

    Route::prefix('registration')->name('registration.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/', 'searchSchedule')->name('index');
        Route::get('/schedule', 'search')->name('schedule');
    });
});

Route::controller(CronController::class)->group(function () {
    Route::prefix('cron')->name('cron.')->group(function () {
        Route::get('/schedule-vaccinations', 'scheduleVaccinations')->name('schedule.vaccinations');
    });
});
