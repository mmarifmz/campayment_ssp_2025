@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow max-w-2xl">
    <h2 class="text-2xl font-bold mb-4">Resit Pembayaran</h2>

    <div class="mb-4 border-b pb-2">
        <p><strong>Nama Peserta:</strong> {{ $payment->nama }}</p>
        <p><strong>Kelas:</strong> {{ $payment->kelas }}</p>
        <p><strong>IC:</strong> {{ $payment->ic }}</p>
        <p><strong>Telefon:</strong> {{ $payment->telefon }}</p>
        <p><strong>Email:</strong> {{ $payment->email }}</p>
    </div>

    <div class="mb-4 border-b pb-2">
        <p><strong>Tarikh:</strong> {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y h:i A') }}</p>
        <p><strong>Jumlah Sumbangan:</strong> RM {{ number_format($payment->sumbangan, 2) }}</p>
        <p><strong>Rujukan Transaksi:</strong> {{ $payment->billcode }}</p>
    </div>

    <div class="text-center mt-6">
        <button onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Cetak Resit</button>
    </div>
</div>

<style>
@media print {
    button { display: none; }
    body { background: white; }
}
</style>
@endsection