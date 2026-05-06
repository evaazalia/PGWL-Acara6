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
Route::delete('/delete-point/{id}', [PointsController::class, 'destroy'])->name('point.delete');

// polylines
Route::post('/polyline/store', [polylinesController::class, 'store'])->name('polyline.store');
Route::delete('/delete-polyline/{id}', [polylinesController::class, 'destroy'])->name('polyline.delete');

// polygons
Route::post('/polygon/store', [polygonsController::class, 'store'])->name('polygon.store');
Route::delete('/delete-polygon/{id}', [polygonsController::class, 'destroy'])->name('polygon.delete');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
