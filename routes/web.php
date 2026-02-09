<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//  Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

    // Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    // Ubah 'dashboard' jadi 'admin.dashboard' karena file lo di folder admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Tambahkan route untuk welcome
    Route::get('/Lamar-Pekerjaan', function () {
        return view('welcome');
    })->name('welcome');
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me']);
});