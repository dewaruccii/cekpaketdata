<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('/', [LoginController::class, 'index'])->name('index')->middleware('guest');
    Route::post('/', [LoginController::class, 'login'])->name('login')->middleware('guest');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/check', [HomeController::class, 'check'])->name('check');
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'files', 'as' => 'files.'], function () {
        Route::post('/upload', [FileController::class, 'upload'])->name('upload');
        Route::get('/download/{uuid}', [FileController::class, 'download'])->name('download');
        Route::get('/view/{uuid}', [FileController::class, 'view'])->name('view');
        Route::delete('/delete/{uuid}', [FileController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('laporan', [HomeController::class, 'laporan'])->name('laporan');
        Route::get('laporan/data', [HomeController::class, 'laporanData'])->name('laporan.data');
    });
});
