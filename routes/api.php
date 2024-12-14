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
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard']);


    //pelatih
    Route::get('/pelatih', [App\Http\Controllers\PelatihController::class, 'index']);
    Route::post('/pelatih', [App\Http\Controllers\PelatihController::class, 'store']);
    Route::get('/pelatih/{id}', [App\Http\Controllers\PelatihController::class, 'show']);
    Route::put('/pelatih/{id}', [App\Http\Controllers\PelatihController::class, 'update']);
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

    //kelas
    Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index']);
    Route::post('/kelas', [App\Http\Controllers\KelasController::class, 'store']);
    Route::get('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'show']);
    Route::put('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/user/profile', [App\Http\Controllers\UserController::class, 'profile']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);

});