<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// ======================================================
// LOGIN
// ======================================================

Route::get('/', [
    LoginController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    LoginController::class,
    'login'
])->name('login.process');

Route::post('/logout', [
    LoginController::class,
    'logout'
])->name('logout');


// ======================================================
// ADMIN
// HANYA ADMIN
// ======================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [
            App\Http\Controllers\Admin\DashboardController::class,
            'index'
        ])->name('dashboard');


        // ==========================
        // KENDARAAN
        // ==========================

        Route::resource(
            'kendaraan',
            App\Http\Controllers\Admin\KendaraanController::class
        );


        // ==========================
        // AREA PARKIR
        // ==========================

        Route::resource(
            'area-parkir',
            App\Http\Controllers\Admin\AreaParkirController::class
        );


        // ==========================
        // TARIF
        // ==========================

        Route::resource(
            'tarif',
            App\Http\Controllers\Admin\TarifController::class
        );


        // ==========================
        // USER
        // ==========================

        Route::resource(
            'user',
            App\Http\Controllers\Admin\UserController::class
        );


        // ==========================
        // LOG AKTIVITAS
        // ==========================

        Route::get('/log-aktivitas', [
            App\Http\Controllers\Admin\LogAktivitasController::class,
            'index'
        ])->name('log.index');

        Route::get('/log-aktivitas/{id}', [
            App\Http\Controllers\Admin\LogAktivitasController::class,
            'show'
        ])->name('log.show');

    });


// ======================================================
// OWNER
// HANYA OWNER
// ======================================================

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [
            App\Http\Controllers\Owner\DashboardController::class,
            'index'
        ])->name('dashboard');


        // Laporan
        Route::get('/laporan', [
            App\Http\Controllers\Owner\LaporanController::class,
            'index'
        ])->name('laporan.index');


        // Cetak laporan
        Route::get('/laporan/cetak', [
            App\Http\Controllers\Owner\LaporanController::class,
            'cetak'
        ])->name('laporan.cetak');


        // Detail laporan
        Route::get('/laporan/{id}', [
            App\Http\Controllers\Owner\LaporanController::class,
            'show'
        ])->name('laporan.show');

    });


// ======================================================
// PETUGAS
// HANYA PETUGAS
// ======================================================

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [
            App\Http\Controllers\Petugas\DashboardController::class,
            'index'
        ])->name('dashboard');


        // Transaksi
        Route::resource(
            'transaksi',
            App\Http\Controllers\Petugas\TransaksiController::class
        );


        // Kendaraan keluar
        Route::post(
            '/transaksi/{id}/keluar',
            [
                App\Http\Controllers\Petugas\TransaksiController::class,
                'keluar'
            ]
        )->name('transaksi.keluar');


         // Cetak struk
        Route::get(
            '/transaksi/{id}/struk',
            [
                App\Http\Controllers\Petugas\TransaksiController::class,
                'struk'
            ]
        )->name('transaksi.struk');

        // Scan Kartu RFID (Masuk / Keluar Otomatis)
        Route::post(
            '/transaksi/scan-rfid',
            [
                App\Http\Controllers\Petugas\TransaksiController::class,
                'scanRfid'
            ]
        )->name('transaksi.scanRfid');


    });