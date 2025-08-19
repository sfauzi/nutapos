<?php

use App\Http\Controllers\DiskonController;
use App\Http\Controllers\OjolRevenueController;
use App\Http\Controllers\PajakController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/hitung-pajak', [PajakController::class, 'hitungPajak']);
Route::post('/hitung-diskon', [DiskonController::class, 'hitungDiskon']);
Route::post('/hitung-ojol-revenue', [OjolRevenueController::class, 'hitungRevenue']);