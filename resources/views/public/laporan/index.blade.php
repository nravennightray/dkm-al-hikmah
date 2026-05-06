@extends('master.layout.app')

@section('title', 'Laporan Keuangan - DKM Al Hikmah')

@section('css')
<style>
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1);
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Laporan Keuangan</h1>
        <p class="text-white-50">Transparansi pengelolaan dana umat secara real-time dan terbuka.</p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach($summaries as $report)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-radius overflow-hidden h-100 hover-card transition">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="bg-success-soft p-3 rounded">
                                <i class="fas fa-wallet text-success fa-lg"></i>
                            </div>
                            <span class="badge bg-light text-muted fw-normal">Update: {{ $report->last_update }}</span>
                        </div>
                        
                        <h5 class="text-dark fw-normal mb-1">{{ $report->title }}</h5>
                        <p class="text-muted small mb-4">Saldo Kas Saat Ini</p>
                        
                        <h2 class="text-success fw-bold mb-4">{{ $report->balance }}</h2>
                        
                        <a href="{{ route('laporan.show', $report->slug) }}" class="btn btn-outline-success w-100 border-radius">
                            Lihat Rincian <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Transparency Note -->
        <div class="mt-5 p-4 bg-white border-radius shadow-sm border-start border-success border-4">
            <div class="row align-items-center">
                <div class="col-md-1 text-center d-none d-md-block">
                    <i class="fas fa-info-circle text-success fa-2x"></i>
                </div>
                <div class="col-md-11">
                    <h5 class="fw-normal mb-1">Komitmen Transparansi</h5>
                    <p class="text-muted small mb-0">Semua laporan keuangan di atas diperbarui secara berkala oleh Bendahara DKM. Jika Anda memiliki pertanyaan mengenai penggunaan dana, silakan hubungi pengurus melalui sekretariat masjid.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection