@extends('layouts.receipt')

@section('content')
<div class="receipt-box">

    {{-- Header with Logo --}}
    <div class="receipt-header">
        <img src="https://yuranpibg.sripetaling.edu.my/storage/logo-ssp-167x168.png" class="logo mb-2">
        <h2 class="mt-2">Kem Kepimpinan SK Sri Petaling 2025</h2>
    </div>

    <h4 class="text-center mb-4">Resit Pembayaran</h4>

    {{-- Conditional Alerts --}}
    @if(isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @elseif(isset($pending) && $pending)
        <div class="alert alert-warning">
            <p><strong>Rekod pembayaran sedang disemak.</strong> Sila maklumkan kepada Guru yang bertugas.</p>
            <ul class="mb-0">
                <li><strong>Payment ID#:</strong> {{ $pendaftaran->bill_code }}</li>
                <li><strong>Nama:</strong> {{ $pendaftaran->nama }}</li>
                <li><strong>Kelas:</strong> {{ $pendaftaran->kelas }}</li>
                <li><strong>Email:</strong> {{ $pendaftaran->email }}</li>
                <li><strong>No. Telefon:</strong> {{ $pendaftaran->telefon }}</li>
            </ul>
        </div>
    @elseif(isset($paid) && $paid)
        <div class="alert alert-success">
            <p><strong>Pembayaran berjaya!</strong></p>
            <ul class="mb-0">
                <li><strong>Jumlah Bayaran:</strong> RM {{ number_format($pendaftaran->total_amount / 100, 2) }}</li>
                <li><strong>No. Telefon:</strong> {{ $pendaftaran->telefon }}</li>
                <li><strong>Email:</strong> {{ $pendaftaran->email }}</li>
                <li><strong>Payment ID#:</strong> {{ $pendaftaran->bill_code }}</li>
            </ul>
        </div>
    @endif

    {{-- Formal Receipt Section --}}
    @if(isset($paid) && $paid)
    <table class="table table-borderless table-sm mt-4">
        <tr>
            <th width="30%">Tarikh</th>
            <td>{{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $pendaftaran->nama }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ $pendaftaran->kelas }}</td>
        </tr>
        <tr>
            <th>Jawatan</th>
            <td>{{ $pendaftaran->jawatan }}</td>
        </tr>
        <tr>
            <th>Jumlah Bayaran</th>
            <td>RM {{ number_format($pendaftaran->total_amount / 100, 2) }}</td>
        </tr>
    </table>
    @endif

    <div class="footer mt-5">
        Sistem direka oleh <strong>Biro ICT, PIBG Sekolah Kebangsaan Sri Petaling</strong> Tahun 2025/2026
       

</div>
@endsection