@extends('master.layout.app')

@section('title', ucwords(str_replace('-', ' ', $category)) . ' - DKM Al Hikmah')

@section('css')
<style>
    .hover-up {
        transition: all 0.3s ease;
    }
    .hover-up:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    .stretched-link::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
        content: "";
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">{{ ucwords(str_replace('-', ' ', $category)) }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}" class="text-white opacity-75">Kegiatan</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ ucwords(str_replace('-', ' ', $category)) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">
        <div class="row g-4">
            @forelse($kegiatans as $item)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-radius overflow-hidden h-100 hover-up">
                    <div class="position-relative">
                        <img src="{{ asset('assets/images/dkm/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 220px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-success shadow-sm">Kegiatan</span>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="far fa-calendar-alt text-success me-2"></i>
                            <small class="text-muted">{{ $item->date }}</small>
                        </div>
                        
                        <h5 class="card-title fw-normal mb-3">
                            {{-- This generates the link to the detail page --}}
                            <a href="{{ route('kegiatan.detail', [$category, $item->slug]) }}" class="text-dark text-decoration-none stretched-link">
                                {{ $item->title }}
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted small">
                            {{ $item->excerpt }}
                        </p>
                    </div>
                    
                    <div class="card-footer bg-white border-0 px-4 pb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-success small fw-bold">Selengkapnya</span>
                            <i class="fas fa-arrow-right text-success small"></i>
                        </div>
                    </div>
                </div>
            </div>
            @empty

            <div class="col-12 text-center py-5">
                <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                <p class="text-muted">Belum ada data kegiatan untuk kategori ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection