@extends('master.layout.app')

@section('title', $currentCategory['name'] . ' - DKM Al Hikmah')

@section('css')
<style>
    .kegiatan-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .kegiatan-breadcrumb {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 15px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
        color: rgba(255, 255, 255, 0.82);
        font-size: 13px;
        font-weight: 700;
    }

    .kegiatan-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
    }

    .kegiatan-breadcrumb a:hover {
        text-decoration: underline;
    }

    .kegiatan-hero-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 14px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.16);
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .activity-post-card {
        border: 1px solid rgba(37, 99, 235, 0.10);
        transition: all 0.3s ease;
    }

    .activity-post-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(37, 99, 235, 0.14) !important;
        border-color: rgba(37, 99, 235, 0.24);
    }

    .activity-post-img {
        height: 220px;
        width: 100%;
        object-fit: cover;
    }

    .activity-image-placeholder {
        height: 220px;
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
        border-bottom: 1px solid rgba(37, 99, 235, 0.10);
        color: #2563eb;
    }

    .badge-dkm-blue {
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
    }

    .text-dkm-blue {
        color: #2563eb !important;
    }

    .activity-read-more {
        color: #2563eb;
    }

    .activity-post-card:hover .activity-read-more {
        color: #1e40af;
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

<div class="section-xl kegiatan-hero">
    <div class="container text-center pt-5">
        <div class="kegiatan-breadcrumb">
            <a href="{{ url('/') }}">
                Beranda
            </a>

            <i class="fas fa-chevron-right small"></i>

            <a href="{{ route('kegiatan.index') }}">
                Kegiatan
            </a>

            <i class="fas fa-chevron-right small"></i>

            <span>
                {{ $currentCategory['name'] }}
            </span>
        </div>

        <h1 class="fw-normal text-white display-4">
            {{ $currentCategory['name'] }}
        </h1>

        <p class="text-white-50 mb-0">
            {{ $currentCategory['desc'] ?? 'Program rutin dan dokumentasi kegiatan DKM Al Hikmah.' }}
        </p>
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">
        <div class="row g-4">
            @forelse($kegiatans as $item)
                @php
                    $image = $item['image'] ?? null;
                    $title = $item['title'] ?? 'Judul kegiatan belum tersedia';
                    $slug = $item['slug'] ?? '#';
                    $date = $item['date'] ?? null;
                    $excerpt = $item['excerpt'] ?? ($item['desc'] ?? 'Deskripsi kegiatan belum tersedia.');
                @endphp

                <div class="col-md-4">
                    <div class="card activity-post-card border-0 shadow-sm border-radius overflow-hidden h-100 position-relative">

                        <div class="position-relative">
                            @if(! empty($item['image']) && ! empty($item['slug']))
                                <img src="{{ asset('image/kegiatan/' . $item['slug'] . '/' . $item['image']) }}"
                                    class="card-img-top activity-post-img"
                                    alt="{{ $title }}">
                            @else
                                <div class="activity-image-placeholder">
                                    Belum ada gambar
                                </div>
                            @endif

                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge badge-dkm-blue shadow-sm">
                                    Kegiatan
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            @if(! empty($date))
                                <div class="d-flex align-items-center mb-3">
                                    <i class="far fa-calendar-alt text-dkm-blue me-2"></i>
                                    <small class="text-muted">{{ $date }}</small>
                                </div>
                            @endif

                            <h5 class="card-title fw-bold mb-3">
                                <a href="{{ route('kegiatan.detail', [$currentCategory['slug'], $slug]) }}"
                                   class="text-dark text-decoration-none stretched-link">
                                    {{ $title }}
                                </a>
                            </h5>

                            <p class="card-text text-muted small mb-0">
                                {{ $excerpt }}
                            </p>
                        </div>

                        <div class="card-footer bg-white border-0 px-4 pb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="activity-read-more small fw-bold">
                                    Selengkapnya
                                </span>

                                <i class="fas fa-arrow-right activity-read-more small"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty

                <div class="col-12 text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3" style="color: rgba(37, 99, 235, 0.25);"></i>
                    <p class="text-muted mb-0">
                        Belum ada data kegiatan untuk kategori ini.
                    </p>
                </div>

            @endforelse
        </div>
    </div>
</div>

@endsection