<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('admin.addhomepagedata');
// });
Route::get('', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // resource
    Route::resource('countries', CountryController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('places', PlaceController::class);
    Route::resource('homepages', HomepageController::class);
    // resource
    // search routing
    Route::get('search', [PlaceController::class, 'search'])->name('search');
    Route::get('destinations', [DestinationController::class, 'Search'])->name('destinations.index');
    // end search routing
    // filter
    // routes/web.php
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');


    // end filter

    // Filter places by destination
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
