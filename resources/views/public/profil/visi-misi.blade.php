@extends('master.layout.app')

@section('title', ($page['title'] ?? 'Visi & Misi') . ' - DKM Al Hikmah')

@section('css')
<style>
    .profil-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .profil-breadcrumb {
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

    .profil-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
    }

    .profil-breadcrumb a:hover {
        text-decoration: underline;
    }

    .profil-hero-badge {
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

    @media (max-width: 767px) {
        .profil-breadcrumb {
            flex-wrap: wrap;
            border-radius: 18px;
            line-height: 1.6;
        }
    }

    .section-xl {
        padding-top: 140px !important;
        padding-bottom: 70px !important;
    }

    .vision-section {
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
    }

    .vision-label {
        color: #2563eb;
        font-weight: 800;
    }

    .mission-icon {
        width: 54px;
        height: 54px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        box-shadow: 0 12px 26px rgba(37, 99, 235, 0.22);
    }

    .mission-item {
        padding: 1rem;
        border-radius: 22px;
        transition: all 0.3s ease;
    }

    .mission-item:hover {
        background: #eff6ff;
        transform: translateX(6px);
    }

    .vision-image {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        background: #f8fafc;
    }

    .vision-image img {
        width: 100%;
        min-height: 360px;
        object-fit: cover;
    }

    .vision-image-placeholder {
        min-height: 360px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        color: #94a3b8;
    }

    .core-value-card {
        height: 100%;
        padding: 2rem;
        border-radius: 24px;
        text-align: center;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        transition: all 0.3s ease;
    }

    .core-value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
        border-color: rgba(37, 99, 235, 0.22);
    }

    .core-value-card h5 {
        color: #2563eb;
        font-weight: 800;
    }

    .core-value-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 1rem;
        border-radius: 18px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .core-value-card:hover .core-value-icon {
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
    }

    .profile-empty {
        padding: 48px 24px;
        text-align: center;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
    }

    .profile-empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
</style>
@endsection

@section('content')

@php
    $title = $page['title'] ?? 'Visi & Misi';
    $heroBadge = $page['hero_badge'] ?? 'Arah Perjuangan DKM';
    $heroIcon = $page['hero_icon'] ?? 'fas fa-bullseye';

    $visionLabel = $page['section_label'] ?? 'Visi Kami';
    $visionTitle = $page['section_title'] ?? 'Terwujudnya Masjid sebagai Pusat Ibadah dan Pemberdayaan Umat yang Mandiri dan Unggul';
    $visionBody = $page['section_body_1'] ?? '';

    $image = $page['image'] ?? '';
    $imageUrl = !empty($image)
        ? asset('image/profil/' . $image)
        : null;

    $missions = $missions ?? collect();
    $values = $values ?? collect();
@endphp

<div class="section-xl profil-hero">
    <div class="container text-center pt-5">
        <div class="profil-breadcrumb">
            <a href="{{ url('/') }}">
                Beranda
            </a>

            <i class="fas fa-chevron-right small"></i>

            <a href="{{ route('profil.index') }}">
                Profil
            </a>

            <i class="fas fa-chevron-right small"></i>

            <span>
                {{ $title }}
            </span>
        </div>

        <div class="profil-hero-badge">
            <i class="{{ $heroIcon }}"></i>
            {{ $heroBadge }}
        </div>

        <h1 class="fw-normal text-white display-4">
            {{ $title }}
        </h1>

        @if(!empty($visionTitle))
            <p class="text-white-50 mb-0">
                {{ $visionTitle }}
            </p>
        @endif
    </div>
</div>

<div class="section vision-section">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h6 class="font-small uppercase vision-label letter-spacing-1">
                    {{ $visionLabel }}
                </h6>

                <h2 class="fw-bold mb-4">
                    {{ $visionTitle }}
                </h2>

                @if(!empty($visionBody))
                    <p class="lead text-muted mb-0">
                        {{ $visionBody }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-12 col-lg-6">
                <h6 class="font-small uppercase vision-label letter-spacing-1">
                    Misi Kami
                </h6>

                <h2 class="fw-bold mb-4">
                    Langkah Nyata Mencapai Visi
                </h2>

                @forelse($missions as $mission)
                    @php
                        $missionIcon = $mission['icon'] ?? 'fas fa-check';
                        $missionTitle = $mission['title'] ?? '-';
                        $missionDescription = $mission['description'] ?? '';
                    @endphp

                    <div class="mission-item d-flex {{ !$loop->last ? 'mb-3' : '' }}">
                        <div class="me-3">
                            <div class="mission-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="{{ $missionIcon }}"></i>
                            </div>
                        </div>

                        <div>
                            <h5 class="fw-bold">
                                {{ $missionTitle }}
                            </h5>

                            <p class="text-muted mb-0">
                                {{ $missionDescription }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="profile-empty">
                        <div class="profile-empty-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>

                        <h5 class="fw-bold mb-2">
                            Misi Belum Tersedia
                        </h5>

                        <p class="text-muted mb-0">
                            Data misi belum tersedia saat ini.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="col-12 col-lg-6">
                <div class="vision-image">
                    @if($imageUrl)
                        <img src="{{ $imageUrl }}"
                             alt="{{ $title }}"
                             class="img-full">
                    @else
                        <div class="vision-image-placeholder">
                            <div class="text-center">
                                <i class="bi bi-image fs-1"></i>
                                <div class="small mt-2">No Image Available</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section pt-0">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 text-center mb-2">
                <h6 class="font-small uppercase letter-spacing-1 fw-bold" style="color: #2563eb;">
                    Prinsip Utama
                </h6>

                <h3 class="fw-bold">
                    Nilai-Nilai Kami
                </h3>
            </div>

            @forelse($values as $value)
                @php
                    $valueIcon = $value['icon'] ?? 'fas fa-star';
                    $valueTitle = $value['title'] ?? '-';
                    $valueDescription = $value['description'] ?? '';
                @endphp

                <div class="col-md-4">
                    <div class="core-value-card">
                        <div class="core-value-icon">
                            <i class="{{ $valueIcon }}"></i>
                        </div>

                        <h5>
                            {{ $valueTitle }}
                        </h5>

                        <p class="font-small mb-0 text-muted">
                            {{ $valueDescription }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="profile-empty">
                        <div class="profile-empty-icon">
                            <i class="fas fa-stars"></i>
                        </div>

                        <h5 class="fw-bold mb-2">
                            Nilai-Nilai Belum Tersedia
                        </h5>

                        <p class="text-muted mb-0">
                            Data nilai-nilai DKM belum tersedia saat ini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection