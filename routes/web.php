<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RukunController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\LurahConfigController;
use App\Http\Controllers\SktmController;
use App\Http\Controllers\DomisiliController;
use App\Http\Controllers\AkteKematianController;
use App\Http\Controllers\AhliWarisController;
use App\Http\Controllers\PindahKeluarController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DashboardController;

//guest route
Route::middleware('guest.check')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.post');
    Route::get('/register', fn() => view('auth.register'))->name('register');
});

//harus login
Route::middleware(['auth.check'])->group(function () {

    //dashboard admin
    Route::middleware(['role.admin'])->group(function () {
        Route::get('/dashboard-admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Rukun
        Route::get('/rukun', [RukunController::class, 'index'])->name('rukun.index');
        Route::post('/rukun', [RukunController::class, 'store'])->name('rukun.store');
        Route::get('/rukun/{id}', [RukunController::class, 'show'])->name('rukun.show');
        Route::put('/rukun/{id}', [RukunController::class, 'update'])->name('rukun.update');
        Route::delete('/rukun/{id}', [RukunController::class, 'destroy'])->name('rukun.destroy');

        // Warga
        Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
        Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
        Route::get('/warga/{id}', [WargaController::class, 'show'])->name('warga.show');
        Route::put('/warga/{id}', [WargaController::class, 'update'])->name('warga.update');
        Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');
        Route::get('/warga/import/template', [WargaController::class, 'downloadTemplate'])->name('warga.import.template');
        Route::post('/warga/import', [WargaController::class, 'import'])->name('warga.import');

        // Family
        Route::get('/family', [FamilyController::class, 'index'])->name('family.index');
        Route::post('/family', [FamilyController::class, 'store'])->name('family.store');
        Route::get('/family/{id}', [FamilyController::class, 'show'])->name('family.show');
        Route::put('/family/{id}', [FamilyController::class, 'update'])->name('family.update');
        Route::delete('/family/{id}', [FamilyController::class, 'destroy'])->name('family.destroy');

        // Profil Kelurahan
        Route::get('/lurah-config', [LurahConfigController::class, 'index'])->name('lurah_config.index');
        Route::post('/lurah-config/save', [LurahConfigController::class, 'save'])->name('lurah_config.save');

        // ============================================================
        // KELOLA SURAT
        // ============================================================

        // Surat Keterangan Tidak Mampu (SKTM)
        Route::get('/sktm', [SktmController::class, 'index'])->name('sktm.index');
        Route::post('/sktm', [SktmController::class, 'store'])->name('sktm.store');
        Route::get('/sktm/search-warga', [SktmController::class, 'searchWarga'])->name('sktm.search_warga');

        // Surat Keterangan Domisili
        Route::get('/domisili', [DomisiliController::class, 'index'])->name('domisili.index');
        Route::post('/domisili', [DomisiliController::class, 'store'])->name('domisili.store');
        Route::get('/domisili/search-warga', [DomisiliController::class, 'searchWarga'])->name('domisili.search_warga');

        // Akte Kematian
        Route::get('/akte-kematian', [AkteKematianController::class, 'index'])->name('akte_kematian.index');
        Route::post('/akte-kematian', [AkteKematianController::class, 'store'])->name('akte_kematian.store');
        Route::get('/akte-kematian/search-warga', [AkteKematianController::class, 'searchWarga'])->name('akte_kematian.search_warga');

        // Surat Ahli Waris
        Route::get('/ahli-waris', [AhliWarisController::class, 'index'])->name('ahli_waris.index');
        Route::post('/ahli-waris', [AhliWarisController::class, 'store'])->name('ahli_waris.store');
        Route::get('/ahli-waris/search-almarhum', [AhliWarisController::class, 'searchAlmarhum'])->name('ahli_waris.search_almarhum');
        Route::get('/ahli-waris/search-warga', [AhliWarisController::class, 'searchWarga'])->name('ahli_waris.search_warga');

        // Surat Pindah Keluar
        Route::get('/pindah-keluar', [PindahKeluarController::class, 'index'])->name('pindah_keluar.index');
        Route::post('/pindah-keluar', [PindahKeluarController::class, 'store'])->name('pindah_keluar.store');
        Route::get('/pindah-keluar/search-warga', [PindahKeluarController::class, 'searchWarga'])->name('pindah_keluar.search_warga');

        // ============================================================
        // ARSIP TERPADU — satu halaman untuk semua jenis surat
        // ============================================================
        Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    });

    // Dashboard roles lain
    Route::middleware(['role.lurah'])->group(function () {
        Route::get('/dashboard-lurah', [DashboardController::class, 'lurah'])->name('dashboard.lurah');
    });

    Route::middleware(['role.sekre'])->group(function () {
        Route::get('/dashboard-sekre', [DashboardController::class, 'sekre'])->name('dashboard.sekre');
    });

    Route::middleware(['role.staff'])->group(function () {
        Route::get('/dashboard-staff', [DashboardController::class, 'staff'])->name('dashboard.staff');
    });

    Route::get('/lamaran', fn() => view('pages.lamaran'))->name('lamaran');
    Route::post('/logout', [AuthController::class, 'logoutWeb'])->name('logout');
});

Route::get('/', function () {
    if (!session('token')) {
        return redirect()->route('login');
    }

    $user = session('user');
    return match ($user->jabatan->slug) {
        'administrator'   => redirect()->route('dashboard.admin'),
        'kepala_lurah'    => redirect()->route('dashboard.lurah'),
        'sekre_lurah'     => redirect()->route('dashboard.sekre'),
        'staff_pelayanan' => redirect()->route('dashboard.staff'),
        default           => redirect()->route('login')
    };
});