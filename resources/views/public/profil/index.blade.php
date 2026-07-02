@extends('master.layout.app')

@section('title', 'Profil - DKM Al Hikmah')

@section('css')
<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 18px 40px rgba(37, 99, 235, 0.14) !important;
    }

    .profile-icon {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.10), rgba(14, 165, 233, 0.16));
        color: #2563eb !important;
        border: 1px solid rgba(37, 99, 235, 0.14);
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .profile-icon i {
        color: #2563eb !important;
        transition: all 0.3s ease;
    }

    .profile-card:hover .profile-icon {
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff !important;
    }

    .profile-card:hover .profile-icon i {
        color: #ffffff !important;
    }

    .profile-card {
        min-height: 100%;
    }

    .profile-description {
        min-height: 56px;
        line-height: 1.7;
    }

    .profile-empty {
        padding: 56px 24px;
        text-align: center;
        border-radius: 24px;
        background: #ffffff;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
    }

    .profile-empty-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 18px;
        border-radius: 24px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }
</style>
@endsection

@section('content')

<div class="section-xl position-relative overflow-hidden"
     style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">

    <div class="position-absolute top-0 start-0 translate-middle rounded-circle"
         style="width: 320px; height: 320px; background: rgba(255,255,255,0.14); filter: blur(70px);">
    </div>

    <div class="position-absolute bottom-0 end-0 translate-middle-y rounded-circle"
         style="width: 380px; height: 380px; background: rgba(125, 211, 252, 0.22); filter: blur(80px);">
    </div>

    <div class="container position-relative text-center pt-5">
        <div class="d-inline-flex align-items-center px-4 py-2 mb-4 rounded-pill"
             style="background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.25); backdrop-filter: blur(10px);">
            <i class="fas fa-mosque me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">Tentang Kami</span>
        </div>

        <h1 class="fw-bold text-white display-4">Profil DKM</h1>

        <p class="text-white mt-3 mb-0">
            Mengenal lebih dekat pengelola dan visi Masjid Al Hikmah
        </p>
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">

        <div class="row g-4">
            @forelse(($menus ?? collect()) as $menu)
                @php
                    $title = $menu['title'] ?? '-';
                    $description = $menu['description'] ?? '';
                    $icon = $menu['icon'] ?? 'fas fa-circle';
                    $routeName = $menu['route_name'] ?? null;

                    $canOpenRoute = $routeName && \Illuminate\Support\Facades\Route::has($routeName);
                @endphp

                <div class="col-md-6">
                    @if($canOpenRoute)
                        <a href="{{ route($routeName) }}" class="text-decoration-none">
                    @else
                        <a href="javascript:void(0)" class="text-decoration-none">
                    @endif

                        <div class="profile-card p-5 bg-white border-radius shadow-sm h-100 hover-card">
                            <div class="profile-icon rounded-circle d-inline-flex align-items-center justify-content-center mb-4">
                                <i class="{{ $icon }} fa-2x"></i>
                            </div>

                            <h3 class="text-dark fw-bold">
                                {{ $title }}
                            </h3>

                            <p class="text-muted profile-description">
                                {{ $description ?: 'Informasi profil DKM Al Hikmah.' }}
                            </p>

                            <span class="profile-link fw-bold" style="color: #2563eb;">
                                Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </span>
                        </div>

                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="profile-empty">
                        <div class="profile-empty-icon">
                            <i class="fas fa-id-card"></i>
                        </div>

                        <h4 class="fw-bold mb-2">
                            Data Profil Belum Tersedia
                        </h4>

                        <p class="text-muted mb-0">
                            Menu profil belum tersedia saat ini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>

@endsection