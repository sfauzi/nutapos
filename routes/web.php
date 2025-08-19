<?php

use App\Http\Controllers\PajakController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/transactions/saldo', [TransactionController::class, 'hitungSaldo']);
Route::get('/stok/kartu', [StockController::class, 'kartuStok']);