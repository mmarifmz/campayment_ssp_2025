@extends('layouts.app')

@section('content')
<div class="container my-5 text-center">

  @if(isset($error))
    <div class="alert alert-danger">{{ $error }}</div>
  @else
    <h2 class="mb-3">Terima Kasih!</h2>
    <p class="lead">Maklumat pendaftaran anda telah diterima.</p>

    <div class="card mt-4 mx-auto" style="max-width: 500px;">
      <div class="card-body text-start">
        <p><strong>Nama:</strong> {{ $pendaftaran->nama }}</p>
        <p><strong>Kelas:</strong> {{ $pendaftaran->kelas }}</p>
        <p><strong>No Kad Pengenalan:</strong> {{ $pendaftaran->ic }}</p>
        <p><strong>Jumlah Bayaran:</strong> RM {{ number_format($pendaftaran->total_amount / 100, 2) }}</p>
        <p><strong>Status Bayaran:</strong>
          @if($pendaftaran->is_paid)
            <span class="text-success fw-bold">Telah Dibayar</span>
          @else
            <span class="text-warning fw-bold">Menunggu Pembayaran</span>
          @endif
        </p>
      </div>
    </div>
  @endif

</div>
@endsection