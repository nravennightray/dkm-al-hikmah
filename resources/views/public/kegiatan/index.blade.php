@extends('master.layout.app')

@section('title', 'Daftar Kegiatan - DKM Al Hikmah')

@section('css')
<style>
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

<div class="section-xl position-relative overflow-hidden"
     style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">

    <div class="container position-relative text-center pt-5">
        <div class="d-inline-flex align-items-center px-4 py-2 mb-4 rounded-pill"
             style="background: rgba(255,255,255,0.16); border: 1px solid rgba(255,255,255,0.28); backdrop-filter: blur(10px);">
            <i class="fas fa-calendar-alt me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">
                Program DKM
            </span>
        </div>

        <h1 class="fw-bold text-white display-4">Kegiatan Kami</h1>

        <p class="text-white mt-3 mb-0">
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