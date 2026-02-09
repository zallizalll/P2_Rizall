<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Balikin view welcome supaya bisa diakses
    Route::get('/Lamar-Pekerjaan', function () {
        return view('welcome');
    })->name('welcome');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function () {
        return redirect('/dashboard');
    });
    
    Route::get('/me', function () {
        return redirect('/dashboard');
    });
});
