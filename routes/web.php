<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\DramaController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'reelshort'], function () {
    Route::get('/', [ReelController::class, 'index'])->name('reelshort.index');
    Route::get('/search', [ReelController::class, 'search'])->name('reelshort.search');
    Route::get('/{slug}/video', [ReelController::class, 'video'])->name('reelshort.video');

    Route::get('/proxy-video/{path}', [ReelController::class, 'stream'])->where('path', '.*')->name('reelshort.proxy-video');

    Route::get('/{id}/{slug}', [ReelController::class, 'show'])->name('reelshort.show');
});

Route::get('/', [DramaController::class, 'index'])->name('dramas.index');
Route::get('/search', [DramaController::class, 'search'])->name('dramas.search');
Route::get('/{id}/{slug}', [DramaController::class, 'show'])->name('dramas.show');
Route::get('/{id}/{slug}/{episode}', [DramaController::class, 'video'])->name('dramas.video');
