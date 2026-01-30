<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


route::get('/', function () {
    return view('welcome');
});

// ======================================================================
// =============================== AUTH =================================
// ======================================================================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login_proses'])->name('login-proses');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_proses'])->name('register-proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
