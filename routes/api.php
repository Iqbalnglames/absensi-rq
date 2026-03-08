<?php

use App\Http\Controllers\AbsenKerjaController;
use App\Http\Controllers\AjarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\JadwalMengajarController;
use App\Http\Controllers\Api\JurnalController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/jadwal', [AjarController::class, 'index']);
    Route::get('/jadwal/{id}', [AjarController::class, 'show']);
    Route::get('/jadwal/{id}/absen', [AjarController::class, 'absenMurid']);
    Route::post('/jadwal/absen', [AjarController::class, 'storeAbsen']);
    Route::post('/absenmasuk', [AbsenKerjaController::class, 'absenMasuk']);
     Route::get('/jadwal/{jadwalId}/jurnal', [JurnalController::class, 'index']);
    Route::post('/jurnal', [JurnalController::class, 'store']);
    Route::get('/jurnal/{id}', [JurnalController::class, 'show']);
    Route::delete('/jurnal/{id}', [JurnalController::class, 'destroy']);
});
