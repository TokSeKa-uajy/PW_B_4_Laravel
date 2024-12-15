<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware(['auth:sanctum', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/total', [App\Http\Controllers\AdminController::class, 'totalKeanggotaanPesan']);
    Route::get('/admin/keuntungan', [App\Http\Controllers\AdminController::class, 'hitungKeuntungan']);

    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard']);

    //pelatih
    Route::get('/pelatih', [App\Http\Controllers\PelatihController::class, 'index']);
    Route::post('/pelatih', [App\Http\Controllers\PelatihController::class, 'store']);
    Route::get('/pelatih/{id}', [App\Http\Controllers\PelatihController::class, 'show']);
    Route::post('/pelatih/{id}', [App\Http\Controllers\PelatihController::class, 'update']);
    Route::delete('/pelatih/{id}', [App\Http\Controllers\PelatihController::class, 'destroy']);

    //kategori kelas
    Route::get('/kategori-kelas', [App\Http\Controllers\KategoriKelasController::class, 'index']);
    Route::post('/kategori-kelas', [App\Http\Controllers\KategoriKelasController::class, 'store']);
    Route::get('/kategori-kelas/{id}', [App\Http\Controllers\KategoriKelasController::class, 'show']);
    Route::put('/kategori-kelas/{id}', [App\Http\Controllers\KategoriKelasController::class, 'update']);
    Route::delete('/kategori-kelas/{id}', [App\Http\Controllers\KategoriKelasController::class, 'destroy']);

    //paket keanggotaan
    Route::get('/paket-keanggotaan', [App\Http\Controllers\PaketKeanggotaanController::class, 'index']);
    Route::post('/paket-keanggotaan', [App\Http\Controllers\PaketKeanggotaanController::class, 'store']);
    Route::get('/paket-keanggotaan/{id}', [App\Http\Controllers\PaketKeanggotaanController::class, 'show']);
    Route::put('/paket-keanggotaan/{id}', [App\Http\Controllers\PaketKeanggotaanController::class, 'update']);
    Route::delete('/paket-keanggotaan/{id}', [App\Http\Controllers\PaketKeanggotaanController::class, 'destroy']);

    //paket kelas
    Route::get('/paket-kelas', [App\Http\Controllers\PaketKelasController::class, 'index']);
    Route::get('/paket-kelas/{idKelas}', [App\Http\Controllers\PaketKelasController::class, 'indexKelas']);
    Route::post('/paket-kelas', [App\Http\Controllers\PaketKelasController::class, 'store']);
    Route::get('/paket-kelas/{id}', [App\Http\Controllers\PaketKelasController::class, 'show']);
    Route::put('/paket-kelas/{id}', [App\Http\Controllers\PaketKelasController::class, 'update']);
    Route::delete('/paket-kelas/{id}', [App\Http\Controllers\PaketKelasController::class, 'destroy']);

    //kelas
    Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index']);
    Route::post('/kelas', [App\Http\Controllers\KelasController::class, 'store']);
    Route::get('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'show']);
    Route::put('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'destroy']);

    //add kategori
    Route::get('/add-kategoris', [App\Http\Controllers\Api\AddKategoriController::class, 'index']);
    Route::post('/add-kategoris', [App\Http\Controllers\Api\AddKategoriController::class, 'store']);
    Route::get('/add-kategoris/{id}', [App\Http\Controllers\Api\AddKategoriController::class, 'show']);
    Route::put('/add-kategoris/update/{id}', [App\Http\Controllers\Api\AddKategoriController::class, 'update']);
    Route::delete('/add-kategoris/delete/{id}', [App\Http\Controllers\Api\AddKategoriController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/user/profile', [App\Http\Controllers\UserController::class, 'profile']);

    //pemesanan kelas
    Route::get('pemesanan-kelas/cari/{id}', [App\Http\Controllers\PemesananKelasController::class, 'findById']);
    Route::get('pemesanan-kelas', [App\Http\Controllers\PemesananKelasController::class, 'tampilPesanan']);
    Route::post('pemesanan-kelas', [App\Http\Controllers\PemesananKelasController::class, 'pesanKelas']);
    Route::get('pemesanan-kelas/{id}', [App\Http\Controllers\PemesananKelasController::class, 'show']);
    Route::put('pemesanan-kelas/{id}/status', [App\Http\Controllers\PemesananKelasController::class, 'updateStatusPembayaran']);
    Route::delete('pemesanan-kelas/{id}', [App\Http\Controllers\PemesananKelasController::class, 'hapusPesanan']);

    //registrasi keanggotaan
    Route::post('/registrasi-keanggotaan', [App\Http\Controllers\RegistrasiKeanggotaanController::class, 'store']);
    Route::get('/registrasi-keanggotaan', [App\Http\Controllers\RegistrasiKeanggotaanController::class, 'showByUser']);

    //keanggotaan
    Route::post('/keanggotaan', [App\Http\Controllers\KeanggotaanController::class, 'registerMembership']);
    Route::get('/keanggotaan', [App\Http\Controllers\KeanggotaanController::class, 'showByUser']);

    //umpan balik
    Route::get('/umpan-balik', [App\Http\Controllers\UmpanBalikController::class, 'index']);
    Route::post('/umpan-balik', [App\Http\Controllers\UmpanBalikController::class, 'store']);
    Route::get('/umpan-balik/{id}', [App\Http\Controllers\UmpanBalikController::class, 'show']);
    Route::put('/umpan-balik/{id}', [App\Http\Controllers\UmpanBalikController::class, 'update']);
    Route::delete('/umpan-balik/{id}', [App\Http\Controllers\UmpanBalikController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

});