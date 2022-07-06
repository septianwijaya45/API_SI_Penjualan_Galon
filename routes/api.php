<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GalonController;
use App\Http\Controllers\Api\LaporanKurirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

// Update Profile
Route::get('update/{id}', [AuthController::class, 'edit'])->name('edit')->middleware('auth:sanctum');
Route::post('update/{id}', [AuthController::class, 'update'])->name('update')->middleware('auth:sanctum');


// Get Galon
Route::get('galon', [GalonController::class, 'index'])->name('galon')->middleware('auth:sanctum');

// Laporan Kurir
Route::get('laporan-kurir/{id}', [LaporanKurirController::class, 'index'])->name('galon')->middleware('auth:sanctum');

