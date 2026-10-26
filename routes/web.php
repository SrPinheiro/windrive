<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SetupController;
use App\Http\Controllers\DriveAccountController;
use App\Http\Controllers\DriveFileController;
use App\Http\Controllers\GoogleCredentialController;
use App\Http\Controllers\GoogleOAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/setup', [SetupController::class, 'show'])->name('setup');
    Route::post('/setup', [SetupController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/credentials');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::resource('credentials', GoogleCredentialController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::get('/credentials/{credential}/connect', [GoogleOAuthController::class, 'redirect'])->name('google.connect');
    Route::get('/google/callback', [GoogleOAuthController::class, 'callback'])->name('google.callback');

    Route::delete('/accounts/{account}', [DriveAccountController::class, 'destroy'])->name('accounts.destroy');

    Route::get('/accounts/{account}/files', [DriveFileController::class, 'index'])->name('files.index');
    Route::post('/accounts/{account}/files', [DriveFileController::class, 'store'])->name('files.store');
    Route::delete('/accounts/{account}/files/{fileId}', [DriveFileController::class, 'destroy'])->name('files.destroy');
});
