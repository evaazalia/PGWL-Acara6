<?php

use App\Http\Controllers\pageController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\polygonsController;
use App\Http\Controllers\polylinesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/peta', [pageController::class, 'peta'])->name('peta');

Route::get('/tabel',[pageController::class, 'table'])->name('tabel');

// points
Route::post('/point/store', [PointsController::class, 'store'])->name('point.store');

// polylines
Route::post('/polyline/store', [polylinesController::class, 'store'])->name('polyline.store');

// polygons
Route::post('/polygon/store', [polygonsController::class, 'store'])->name('polygon.store');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
