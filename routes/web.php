<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KunjunganController as AdminKunjunganController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\KalenderController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Pengunjung\DashboardController as PengunjungDashboardController;
use App\Http\Controllers\Pengunjung\KunjunganController as PengunjungKunjunganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome'); // ← TAMBAHKAN INI

/*
|--------------------------------------------------------------------------
| Redirect Dashboard Berdasarkan Role
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isPengunjung()) {
        return redirect()->route('pengunjung.dashboard');
    }

    abort(403);
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Kunjungan
        Route::get('/kunjungan', [AdminKunjunganController::class, 'index'])
            ->name('kunjungan.index');

        Route::get('/kunjungan/{kunjungan}', [AdminKunjunganController::class, 'show'])
            ->name('kunjungan.show');

        Route::get('/kunjungan/{kunjungan}/verifikasi', [AdminKunjunganController::class, 'verifikasi'])
            ->name('kunjungan.verifikasi');

        Route::post('/kunjungan/{kunjungan}/verifikasi', [AdminKunjunganController::class, 'prosesVerifikasi'])
            ->name('kunjungan.proses-verifikasi');

        Route::get('/kunjungan/{kunjungan}/assign-petugas', [AdminKunjunganController::class, 'assignPetugas'])
            ->name('kunjungan.assign-petugas');

        Route::post('/kunjungan/{kunjungan}/assign-petugas', [AdminKunjunganController::class, 'prosesAssignPetugas'])
            ->name('kunjungan.proses-assign-petugas');

        Route::post('/kunjungan/{kunjungan}/update-status', [AdminKunjunganController::class, 'updateStatus'])
            ->name('kunjungan.update-status');

        // Pegawai
        Route::resource('pegawai', PegawaiController::class);

        // Kalender
        Route::get('/kalender', [KalenderController::class, 'index'])
            ->name('kalender.index');

        Route::get('/kalender/events', [KalenderController::class, 'getEvents'])
            ->name('kalender.events');

        // Export
        Route::get('/export', [ExportController::class, 'index'])
            ->name('export.index');

        Route::get('/export/excel', [ExportController::class, 'exportExcel'])
            ->name('export.excel');

        Route::get('/export/pdf', [ExportController::class, 'exportPdf'])
            ->name('export.pdf');
    });

/*
|--------------------------------------------------------------------------
| Pengunjung Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pengunjung'])
    ->prefix('pengunjung')
    ->name('pengunjung.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [PengunjungDashboardController::class, 'index'])
            ->name('dashboard');

        // Kunjungan
        Route::get('/kunjungan', [PengunjungKunjunganController::class, 'index'])
            ->name('kunjungan.index');

        Route::get('/kunjungan/create', [PengunjungKunjunganController::class, 'create'])
            ->name('kunjungan.create');

        Route::post('/kunjungan', [PengunjungKunjunganController::class, 'store'])
            ->name('kunjungan.store');

        Route::get('/kunjungan/{kunjungan}', [PengunjungKunjunganController::class, 'show'])
            ->name('kunjungan.show');

        Route::get('/kunjungan/{kunjungan}/konfirmasi', [PengunjungKunjunganController::class, 'konfirmasi'])
            ->name('kunjungan.konfirmasi');

        Route::post('/kunjungan/{kunjungan}/konfirmasi', [PengunjungKunjunganController::class, 'prosesKonfirmasi'])
            ->name('kunjungan.proses-konfirmasi');
    });

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';