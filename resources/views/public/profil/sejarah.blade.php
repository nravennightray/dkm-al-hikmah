@extends('master.layout.app')

@section('title', ($page['title'] ?? 'Sejarah') . ' - DKM Al Hikmah')

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

    .history-image {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        background: #f8fafc;
    }

    .history-image img {
        width: 100%;
        height: 100%;
        min-height: 360px;
        object-fit: cover;
    }

    .history-image-placeholder {
        min-height: 360px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        color: #94a3b8;
    }

    .history-label {
        color: #2563eb;
    }

    .milestone-card {
        height: 100%;
        padding: 2rem;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        transition: all 0.3s ease;
    }

    .milestone-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
    }

    .milestone-year {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.45rem 1rem;
        margin-bottom: 1rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    .quote-blue-section {
        background: linear-gradient(135deg, #0f172a 0%, #1e40af 55%, #0ea5e9 100%);
        position: relative;
        overflow: hidden;
    }

    .quote-blue-section::before {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        top: -120px;
        left: -120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        filter: blur(70px);
    }

    .quote-blue-section::after {
        content: "";
        position: absolute;
        width: 360px;
        height: 360px;
        right: -120px;
        bottom: -160px;
        border-radius: 50%;
        background: rgba(125, 211, 252, 0.22);
        filter: blur(80px);
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
    $title = $page['title'] ?? 'Sejarah Masjid';
    $heroBadge = $page['hero_badge'] ?? 'Perjalanan DKM';
    $heroIcon = $page['hero_icon'] ?? 'fas fa-history';
    $sectionLabel = $page['section_label'] ?? 'Asal-Usul';
    $sectionTitle = $page['section_title'] ?? 'Titik Awal Perjalanan Dakwah';
    $body1 = $page['section_body_1'] ?? '';
    $body2 = $page['section_body_2'] ?? '';
    $image = $page['image'] ?? '';
    $quoteText = $page['quote_text'] ?? '';
    $quoteAuthor = $page['quote_author'] ?? '';

    $imageUrl = !empty($image)
        ? asset('image/profil/' . $image)
        : null;

    $milestones = $milestones ?? collect();
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

        @if(!empty($sectionTitle))
            <p class="text-white-50 mb-0">
                {{ $sectionTitle }}
            </p>
        @endif
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-12 col-lg-6">
                <div class="history-image">
                    @if($imageUrl)
                        <img src="{{ $imageUrl }}"
                             alt="{{ $title }}"
                             class="img-full">
                    @else
                        <div class="history-image-placeholder">
                            <div class="text-center">
                                <i class="bi bi-image fs-1"></i>
                                <div class="small mt-2">No Image Available</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <h6 class="font-small uppercase history-label letter-spacing-1 fw-bold">
                    {{ $sectionLabel }}
                </h6>

                <h2 class="fw-bold mb-3">
                    {{ $sectionTitle }}
                </h2>

                @if(!empty($body1))
                    <p class="mt-3">
                        {{ $body1 }}
                    </p>
                @endif

                @if(!empty($body2))
                    <p>
                        {{ $body2 }}
                    </p>
                @endif
            </div>
        </div>

        <hr class="my-5" style="border-color: rgba(37, 99, 235, 0.12);">

        <div class="row g-4 mt-2">
            <div class="col-12 text-center mb-4">
                <h6 class="font-small uppercase letter-spacing-1 fw-bold" style="color: #2563eb;">
                    Jejak Perkembangan
                </h6>

                <h3 class="fw-bold">
                    Milestones Penting
                </h3>
            </div>

            @forelse($milestones as $milestone)
                <div class="col-12 col-md-4">
                    <div class="milestone-card text-center">
                        <span class="milestone-year">
                            {{ $milestone['year'] ?? '-' }}
                        </span>

                        <h5 class="fw-bold">
                            {{ $milestone['title'] ?? '-' }}
                        </h5>

                        <p class="font-small text-muted mb-0">
                            {{ $milestone['description'] ?? '' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="profile-empty">
                        <div class="profile-empty-icon">
                            <i class="fas fa-clock"></i>
                        </div>

                        <h5 class="fw-bold mb-2">
                            Milestone Belum Tersedia
                        </h5>

                        <p class="text-muted mb-0">
                            Data milestone sejarah belum tersedia saat ini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

@if(!empty($quoteText))
    <div class="section-sm quote-blue-section text-white">
        <div class="container position-relative text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <i class="fas fa-quote-left fa-2x mb-3 opacity-50"></i>

                    <h4 class="fw-normal italic text-white">
                        "{{ $quoteText }}"
                    </h4>

                    @if(!empty($quoteAuthor))
                        <p class="mt-3 mb-0 text-white">
                            — {{ $quoteAuthor }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@endsection