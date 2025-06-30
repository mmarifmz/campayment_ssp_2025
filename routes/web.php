<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PendaftaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/daftar', [PendaftaranController::class, 'create'])->name('daftar.create');
Route::post('/daftar', [PendaftaranController::class, 'store'])->name('daftar.store');
Route::get('/resit', [PendaftaranController::class, 'receipt'])->name('daftar.resit');
Route::post('/toyyibpay-callback', [PendaftaranController::class, 'callback'])->name('toyyibpay.callback');