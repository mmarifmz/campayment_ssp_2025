<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\StudentSuggestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/daftar', [PendaftaranController::class, 'create'])->name('daftar.create');
Route::post('/daftar', [PendaftaranController::class, 'store'])->name('daftar.store');
Route::get('/resit', [PendaftaranController::class, 'receipt'])->name('daftar.resit');

Route::get('/receipt', [PendaftaranController::class, 'receipt'])->name('receipt');
Route::post('/toyyibpay/callback', [PendaftaranController::class, 'callback'])->name('toyyibpay.callback');

#Route::get('/receipt/{billcode}', [ReceiptController::class, 'show'])->name('receipt.show');
#Route::post('/toyyibpay-callback', [PendaftaranController::class, 'callback'])->name('toyyibpay.callback');

Route::get('/student-suggest', [StudentSuggestController::class, 'suggest'])
    ->name('suggest.student');

Route::get('/senarai-peserta', [PendaftaranController::class, 'listPaid'])->name('participants.list');