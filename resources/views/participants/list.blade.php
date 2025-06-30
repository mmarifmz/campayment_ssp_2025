@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center fw-bold mb-5">Kem Kepimpinan SSP 2025 </h2>
    <h5 class="text-center fw-bold mb-5">Senarai Peserta Telah Membayar</h5>
    @foreach ($peserta as $jawatan => $group)
        <div class="mb-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-semibold text-blue-800 border-b border-gray-300 pb-1">
                    {{ $jawatan }}
                </h3>
                <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('copy-{{ \Str::slug($jawatan) }}')">
                    📋 Salin Senarai
                </button>
            </div>

        <textarea id="copy-{{ \Str::slug($jawatan) }}" class="form-control d-none" readonly>
*{{ strtoupper($jawatan) }}*
Senarai Peserta Kem Kepimpinan SSP 2025

@foreach ($group as $p)
- {{ strtoupper($p->nama) }} ({{ $p->kelas }})
@endforeach
</textarea>

            <div class="row g-3">

                @foreach ($group as $p)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body py-2 px-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <a href="{{ route('receipt', ['billcode' => $p->bill_code]) }}" target="_blank" rel="noopener noreferrer">
                                    <h6 class="card-title fw-semibold mb-1 text-uppercase">{{ strtoupper($p->nama) }}</h6></a>
<span class="badge bg-info text-dark">{{ $p->kelas }}</span>
                                </div>

                                <div class="mt-1">
                                    @if ($p->sumbangan > 0)
                                        <span class="badge bg-warning text-dark">Yuran & Sumbangan</span>
                                    @else
                                        <span class="badge bg-success">Yuran</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
@section('scripts')
<script>
    function copyToClipboard(id) {
        const textarea = document.getElementById(id);
        if (!textarea) return;

        textarea.classList.remove('d-none');
        textarea.select();
        textarea.setSelectionRange(0, 99999); // For mobile devices

        try {
            const successful = document.execCommand('copy');
            alert("✅ Senarai telah disalin ke clipboard.");
        } catch (err) {
            alert("❌ Gagal salin teks. Sila cuba manual.");
        }

        textarea.classList.add('d-none');
    }
</script>
@endsection