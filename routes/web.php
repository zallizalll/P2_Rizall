<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Default route to redirect based on authentication status
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

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

    // ADMIN ROUTES
    Route::prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
        Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'userDestroy'])->name('users.destroy');

        // RUKUN Management
        Route::get('/rukun', [AdminController::class, 'rukun'])->name('rukun');
        Route::post('/rukun', [AdminController::class, 'rukun_store'])->name('rukun.store');
        Route::put('/rukun/{id}', [AdminController::class, 'rukun_update'])->name('rukun.update');
        Route::delete('/rukun/{id}', [AdminController::class, 'rukun_destroy'])->name('rukun.destroy');

        // FAMILY Management
        Route::get('/family', [AdminController::class, 'family'])->name('family');
        Route::post('/family/store', [AdminController::class, 'family_store'])->name('family.store');
        Route::put('/family/update/{id}', [AdminController::class, 'family_update'])->name('family.update');
        Route::delete('/family/destroy/{id}', [AdminController::class, 'family_destroy'])->name('family.destroy');

        // WARGA Management
        Route::get('/warga', [AdminController::class, 'warga'])->name('warga');
        Route::post('/warga/store', [AdminController::class, 'warga_store'])->name('warga.store');
        Route::put('/warga/update/{id}', [AdminController::class, 'warga_update'])->name('warga.update');
        Route::delete('/warga/delete/{id}', [AdminController::class, 'warga_destroy'])->name('warga.delete');

        // Jabatan Management
        Route::get('/jabatan', [AdminController::class, 'jabatan'])->name('jabatan');
        Route::post('/jabatan', [AdminController::class, 'jabatanStore'])->name('jabatan.store');
        Route::put('/jabatan/{id}', [AdminController::class, 'jabatanUpdate'])->name('jabatan.update');
        Route::delete('/jabatan/{id}', [AdminController::class, 'jabatanDestroy'])->name('jabatan.destroy');
        
        // Lurah Config Routes
        Route::get('/lurah-config', [AdminController::class, 'lurahConfig'])->name('lurah-config');
        Route::post('/lurah-config', [AdminController::class, 'lurahConfigStore'])->name('lurah-config.store');
        Route::put('/lurah-config/{id}', [AdminController::class, 'lurahConfigUpdate'])->name('lurah-config.update');
        Route::delete('/lurah-config/{id}', [AdminController::class, 'lurahConfigDestroy'])->name('lurah-config.destroy');
    });
});
