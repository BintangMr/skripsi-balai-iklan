<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

use App\Http\Controllers\PemesananController;

// URL untuk membuka halaman form pemesanan
Route::get('/pesan-iklan', [PemesananController::class, 'create']);

// URL untuk memproses pengiriman form
Route::post('/pesan-iklan', [PemesananController::class, 'store']);

use App\Http\Controllers\AuthController;

// Route Autentikasi
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Halaman Utama/Welcome Page Pelanggan setelah Login
Route::get('/dashboard-pelanggan', function() {
    if(!session('user_id')) return redirect('/login'); // Proteksi halaman jika belum login
    return view('dashboard_pelanggan');
});

use App\Http\Controllers\PembayaranController;

// Route Pembayaran & Kuitansi
Route::get('/pembayaran/{id}', [PembayaranController::class, 'create']);
Route::post('/pembayaran/{id}', [PembayaranController::class, 'store']);
Route::get('/kuitansi/{id}', [PembayaranController::class, 'kuitansi']);

Route::get('/tagihan', [App\Http\Controllers\PemesananController::class, 'tagihan']);
// Route Riwayat Pesanan Pelanggan
Route::get('/riwayat-pesanan', [PemesananController::class, 'riwayat']);

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;

// Rute khusus Peran ADMIN
Route::get('/dashboard-admin', [AdminController::class, 'index']);
Route::get('/admin/pesanan/{id}', [AdminController::class, 'detail']); // Halaman Detail
Route::post('/admin/pesanan/{id}/verifikasi', [AdminController::class, 'verifikasi']); // Proses Verifikasi

// Rute khusus Peran PEMILIK (Laporan & Cetak)
Route::get('/laporan-pemilik', [PemilikController::class, 'index']);
Route::get('/laporan-pemilik/cetak', [PemilikController::class, 'cetak']);

Route::post('/admin/pesanan/{id}/upload-bukti', [AdminController::class, 'uploadBuktiTerbit']);
Route::get('/admin/pelanggan', [AdminController::class, 'pelanggan']);
Route::delete('/admin/pelanggan/{id}/delete', [AdminController::class, 'hapusPelanggan']);

Route::get('/admin/data-admin', [AdminController::class, 'adminIndex']);
Route::get('/admin/data-admin/create', [AdminController::class, 'adminCreate']);
Route::post('/admin/data-admin/store', [AdminController::class, 'adminStore']);
Route::get('/admin/data-admin/{id}/edit', [AdminController::class, 'adminEdit']);
Route::post('/admin/data-admin/{id}/update', [AdminController::class, 'adminUpdate']);
Route::delete('/admin/data-admin/{id}/delete', [AdminController::class, 'adminDelete']);