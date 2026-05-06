@extends('master.layout.app')

@section('title', 'Infaq & Sedekah - DKM Al Hikmah')

@section('content')

<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Infaq & Sedekah</h1>
        <p class="text-white-50">"Harta tidak akan berkurang karena sedekah." (HR. Muslim)</p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- Left: Info & QRIS -->
            <div class="col-lg-6 text-center">
                <div class="p-4 bg-white shadow-sm border-radius">
                    <h4 class="fw-normal mb-4">Scan QRIS Infaq</h4>
                    {{-- Replace with your actual QRIS image --}}
                    <div class="bg-light p-3 border-radius mb-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=DKM-AL-HIKMAH" alt="QRIS" class="img-fluid" style="max-width: 250px;">
                    </div>
                    <p class="small text-muted">Mendukung semua e-wallet (GoPay, OVO, Dana, LinkAja, dsb)</p>
                </div>
            </div>

            <!-- Right: Bank Accounts -->
            <div class="col-lg-6">
                <h2 class="fw-normal mb-4">Transfer Bank</h2>
                <p class="text-muted mb-4">Anda dapat menyalurkan donasi melalui transfer ke rekening resmi DKM Al Hikmah di bawah ini:</p>

                @foreach($accounts as $acc)
                <div class="card border-0 bg-light-gray border-radius mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <span class="badge bg-success mb-2">{{ $acc->bank }}</span>
                            <h3 class="fw-bold mb-1 letter-spacing-1">{{ $acc->number }}</h3>
                            <small class="text-muted">a.n {{ $acc->holder }}</small>
                        </div>
                        {{-- A simple button that looks like a copy button --}}
                        <button class="btn btn-white shadow-sm btn-sm border-radius text-success px-3">
                            <i class="far fa-copy me-1"></i> Salin
                        </button>
                    </div>
                </div>
                @endforeach

                <div class="mt-5 p-4 border border-success border-radius italic text-muted small">
                    <i class="fas fa-info-circle me-2 text-success"></i> 
                    Mohon sertakan kode unik atau melakukan konfirmasi ke Bendahara DKM setelah melakukan transfer untuk mempermudah pencatatan laporan keuangan.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection