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