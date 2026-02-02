<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, DashboardController, LemburController,
    PegawaiController, TimController, AkunController,
    HariLiburController, VerifikasiController, KonfigurasiController
};

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ganti-password', [AuthController::class, 'showGantiPassword'])->name('ganti_password');
    Route::post('/ganti-password', [AuthController::class, 'gantiPassword']);

    // --- AKSES SEMUA ROLE (Operator, Kabag, Admin) ---
    Route::get('/ajukan-lembur', [LemburController::class, 'index'])->name('input_lembur');
    Route::post('/simpan-pengajuan', [LemburController::class, 'storePengajuan'])->name('simpan_pengajuan');
    Route::get('/status-pengajuan', [LemburController::class, 'statusPengajuan'])->name('status_pengajuan');
    Route::get('/pengajuan/edit/{id}', [LemburController::class, 'editPengajuan'])->name('pengajuan.edit');
    Route::post('/pengajuan/update/{id}', [LemburController::class, 'updatePengajuan'])->name('pengajuan.update');

    // --- ROLE KABAG (VERIFIKATOR) ---
    Route::middleware(['can:kabag'])->group(function () {
        Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('/verifikasi/proses', [VerifikasiController::class, 'proses'])->name('verifikasi.proses');Route::get('verifikasi/riwayat', [VerifikasiController::class, 'riwayat'])->name('verifikasi.riwayat');
        Route::post('/verifikasi/batalkan/{id}', [VerifikasiController::class, 'batalkanPersetujuan'])->name('verifikasi.batalkan');
    });

    // --- ROLE ADMIN ---
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/daftar-spkl', [LemburController::class, 'daftarSpkl'])->name('daftar_spkl');
        Route::get('/rekap-presensi', [LemburController::class, 'rekap'])->name('rekap_presensi');
        Route::post('/rekap-presensi/import', [LemburController::class, 'importPresensi'])->name('lembur.import');
        Route::get('/cetak-spkl', [LemburController::class, 'cetakSpkl'])->name('cetak_spkl');
    });

        // Kelola Pegawai
        Route::get('/kelola-pegawai', [PegawaiController::class, 'index'])->name('kelola_pegawai');
        Route::post('/kelola-pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::post('/kelola-pegawai/update', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::post('/kelola-pegawai/delete', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
        Route::post('/kelola-pegawai/import', [PegawaiController::class, 'import'])->name('pegawai.import');
        Route::get('/kelola-pegawai/template', [PegawaiController::class, 'downloadTemplate'])->name('pegawai.template');

        // Manajemen Akun

Route::get('/manajemen-akun', [AkunController::class, 'index'])->name('manajemen_akun');
Route::post('/manajemen-akun', [AkunController::class, 'store'])->name('akun.store');
Route::put('/manajemen-akun/update', [AkunController::class, 'update'])->name('akun.update'); // Gunakan POST
Route::post('/manajemen-akun/reset', [AkunController::class, 'resetPassword'])->name('akun.reset');
Route::post('/manajemen-akun/status', [AkunController::class, 'ubahStatus'])->name('akun.status');

        // Pengaturan Lainnya
        Route::resource('tim', TimController::class);
        Route::get('/kelola-hari-libur', [HariLiburController::class, 'index'])->name('kelola_hari_libur');
        Route::post('/kelola-hari-libur/sync', [HariLiburController::class, 'sync'])->name('hari_libur.sync');
        Route::post('/hari-libur/delete', [HariLiburController::class, 'destroy'])->name('hari_libur.delete');
        Route::get('/konfigurasi', [KonfigurasiController::class, 'index'])->name('konfigurasi');
        Route::post('/konfigurasi/update', [KonfigurasiController::class, 'update'])->name('konfigurasi.update');
    });


    // --- AKSES OPERATOR & ADMIN ---
Route::get('/ajukan-lembur', [LemburController::class, 'index'])->name('input_lembur');
Route::post('/simpan-pengajuan', [LemburController::class, 'storePengajuan'])->name('simpan_pengajuan');

// --- KHUSUS ADMIN ---
Route::middleware(['auth', 'can:admin'])->group(function () {
    // Menu Rencana
    Route::get('/daftar-spkl', [LemburController::class, 'daftarSpkl'])->name('daftar_spkl');
    Route::get('/cetak-spkl', [LemburController::class, 'cetakSpkl'])->name('cetak_spkl');

    // Menu Realisasi (Rekap Presensi)
    Route::get('/rekap-presensi', [LemburController::class, 'rekap'])->name('rekap_presensi');
    Route::get('/rekap-presensi/download-template', [LemburController::class, 'downloadTemplate'])->name('download_template');
    Route::post('/rekap-presensi/import', [LemburController::class, 'importPresensi'])->name('lembur.import');
    Route::get('/cetak-rekap', [LemburController::class, 'cetakRekap'])->name('cetak_rekap');
});
