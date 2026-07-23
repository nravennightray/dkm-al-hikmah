@extends('master.layout.app')

@section('title', 'Daftar Kegiatan - DKM Al Hikmah')

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
    .activity-card {
        padding: 1.75rem;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        transition: all 0.25s ease;
    }

    .activity-card:hover {
        transform: translateY(-4px);
        border-color: rgba(37, 99, 235, 0.25);
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.10);
    }

    .activity-icon {
        color: #2563eb;
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }

    .activity-link {
        color: #2563eb;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .activity-card:hover .activity-link {
        color: #1e40af;
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

            <span>
                Kegiatan
            </span>
        </div>

        <h1 class="fw-normal text-white display-4">
            Kegiatan Kami
        </h1>

        <p class="text-white-50 mb-0">
            Program rutin dan temporer untuk memakmurkan masjid dan umat.
        </p>
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">
        <div class="row g-4">

            @foreach($categories as $cat)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('kegiatan.category', $cat['slug']) }}" class="text-decoration-none">
                        <div class="activity-card h-100">
                            <div class="activity-icon">
                                <i class="fas {{ $cat['icon'] }}"></i>
                            </div>

                            <h4 class="text-dark fw-bold mb-2">
                                {{ $cat['name'] }}
                            </h4>

                            <p class="text-muted small mb-3">
                                {{ $cat['desc'] }}
                            </p>

                            <span class="activity-link">
                                Lihat Program <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection