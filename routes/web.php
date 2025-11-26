<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/check', [HomeController::class, 'check'])->name('check');
Route::group(['prefix' => 'files', 'as' => 'files.'], function () {
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
    Route::get('/download/{uuid}', [FileController::class, 'download'])->name('download');
    Route::get('/view/{uuid}', [FileController::class, 'view'])->name('view');
    Route::delete('/delete/{uuid}', [FileController::class, 'delete'])->name('delete');
});
