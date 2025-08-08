<?php

use App\Http\Controllers\DramaController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DramaController::class, 'index'])->name('dramas.index');
Route::get('/search', [DramaController::class, 'search'])->name('dramas.search');
Route::get('/{id}/{slug}', [DramaController::class, 'show'])->name('dramas.show');
Route::get('/{id}/{slug}/{episode}', [DramaController::class, 'video'])->name('dramas.video');
