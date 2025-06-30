@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header with Logo --}}
    <div class="text-center mb-4">
        <img src="https://yuranpibg.sripetaling.edu.my/storage/logo-ssp-167x168.png" alt="Logo SSP" style="max-height: 100px;">
        <h3 class="mt-3">Kem Kepimpinan SK Sri Petaling 2025</h3>
    </div>

    <h2 class="mb-4">Resit Pembayaran</h2>

    @if(isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @elseif(isset($pending) && $pending)
        <div class="alert alert-warning">
            <p><strong>Rekod pembayaran sedang disemak.</strong> Sila maklumkan kepada Guru yang bertugas.</p>
            <ul>
                <li><strong>Bill Code:</strong> {{ $pendaftaran->bill_code }}</li>
                <li><strong>Nama:</strong> {{ $pendaftaran->nama }}</li>
                <li><strong>No. Telefon:</strong> {{ $pendaftaran->telefon }}</li>
            </ul>
        </div>
    @elseif(isset($paid) && $paid)
        <div class="alert alert-success">
            <p><strong>Pembayaran berjaya!</strong></p>
            <ul>
                <li><strong>Nama:</strong> {{ $pendaftaran->nama }}</li>
                <li><strong>Kelas:</strong> {{ $pendaftaran->kelas }}</li>
                <li><strong>Jumlah Bayaran:</strong> RM {{ number_format($pendaftaran->total_amount / 100, 2) }}</li>
                <li><strong>No. Telefon:</strong> {{ $pendaftaran->telefon }}</li>
                <li><strong>Bill Code:</strong> {{ $pendaftaran->bill_code }}</li>
            </ul>
        </div>
    @endif
</div>
@endsection