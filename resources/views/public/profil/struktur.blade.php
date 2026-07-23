@extends('master.layout.app')

@section('title', ($page['title'] ?? 'Struktur Organisasi') . ' - DKM Al Hikmah')

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

    .org-main-card {
        border-top: 4px solid #2563eb;
        border-radius: 24px;
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
        transition: all 0.3s ease;
    }

    .org-main-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 50px rgba(37, 99, 235, 0.20);
    }

    .org-icon-main {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.26);
    }

    .org-small-card,
    .org-field-card {
        border: 1px solid rgba(37, 99, 235, 0.10);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .org-small-card:hover,
    .org-field-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(37, 99, 235, 0.12);
        border-color: rgba(37, 99, 235, 0.25);
    }

    .org-field-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 0.8rem;
        border-radius: 16px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .org-field-card:hover .org-field-icon {
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
    }

    .org-label {
        color: #2563eb;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .structure-placeholder {
        border: 1px dashed rgba(37, 99, 235, 0.35);
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
    }

    .structure-placeholder i {
        color: rgba(37, 99, 235, 0.35);
    }

    .structure-image {
        width: 100%;
        border-radius: 18px;
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
    $title = $page['title'] ?? 'Struktur Organisasi';
    $heroBadge = $page['hero_badge'] ?? 'Tata Kelola DKM';
    $heroIcon = $page['hero_icon'] ?? 'fas fa-sitemap';
    $subtitle = $page['subtitle'] ?? 'Sinergi dalam melayani umat dan memakmurkan masjid.';
    $sectionLabel = $page['section_label'] ?? 'Bagan Organisasi';
    $sectionTitle = $page['section_title'] ?? 'Bagan Organisasi DKM Al Hikmah';
    $sectionBody = $page['section_body_1'] ?? $subtitle;
    $image = $page['image'] ?? '';

    $mainStructure = $mainStructure ?? null;
    $secondaryStructures = $secondaryStructures ?? collect();
    $fieldStructures = $fieldStructures ?? collect();

    $structureImageUrl = !empty($image)
        ? asset('image/profil/' . $image)
        : null;
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

        @if(!empty($subtitle))
            <p class="text-white-50 mb-0">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">

        <div class="section-title text-center mb-5">
            <h6 class="font-small uppercase letter-spacing-1 fw-bold" style="color: #2563eb;">
                {{ $sectionLabel }}
            </h6>

            <h2 class="fw-bold">
                {{ $sectionTitle }}
            </h2>

            @if(!empty($sectionBody))
                <p class="text-muted">
                    {{ $sectionBody }}
                </p>
            @endif
        </div>

        @if($mainStructure)
            @php
                $mainRole = $mainStructure['role'] ?? 'Ketua Umum';
                $mainDescription = $mainStructure['description'] ?? 'Penanggung Jawab Utama';
                $mainIcon = $mainStructure['icon'] ?? 'fas fa-user-tie';
            @endphp

            <div class="row justify-content-center mb-5">
                <div class="col-md-5 col-lg-4 text-center">
                    <div class="org-main-card p-4 bg-white">
                        <div class="org-icon-main rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="{{ $mainIcon }} fa-lg"></i>
                        </div>

                        <h5 class="mb-1 fw-bold">
                            {{ $mainRole }}
                        </h5>

                        <p class="org-label mb-0">
                            {{ $mainDescription }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($secondaryStructures->count())
            <div class="row justify-content-center g-4 mb-5">
                @foreach($secondaryStructures as $structure)
                    <div class="col-md-4 col-lg-3 text-center">
                        <div class="org-small-card p-4 bg-white shadow-sm h-100">
                            <h6 class="mb-1 fw-bold">
                                {{ $structure['role'] ?? '-' }}
                            </h6>

                            <p class="text-muted small mb-0">
                                {{ $structure['description'] ?? '' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($fieldStructures->count())
            <div class="row g-4 text-center">
                @foreach($fieldStructures as $structure)
                    @php
                        $role = $structure['role'] ?? '-';
                        $description = $structure['description'] ?? '';
                        $icon = $structure['icon'] ?? 'fas fa-users';
                    @endphp

                    <div class="col-6 col-lg-3">
                        <div class="org-field-card p-4 bg-white h-100">
                            <div class="org-field-icon">
                                <i class="{{ $icon }}"></i>
                            </div>

                            <h6 class="mb-1 fw-bold">
                                {{ $role }}
                            </h6>

                            <p class="font-small text-muted mb-0">
                                {{ $description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!$mainStructure && !$secondaryStructures->count() && !$fieldStructures->count())
            <div class="profile-empty">
                <div class="profile-empty-icon">
                    <i class="fas fa-sitemap"></i>
                </div>

                <h5 class="fw-bold mb-2">
                    Data Struktur Belum Tersedia
                </h5>

                <p class="text-muted mb-0">
                    Data struktur organisasi belum tersedia saat ini.
                </p>
            </div>
        @endif

    </div>
</div>

{{-- <div class="section pt-0" style="background: #ffffff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                @if($structureImageUrl)
                    <div class="p-2 bg-white shadow border-radius">
                        <img src="{{ $structureImageUrl }}"
                             alt="{{ $sectionTitle }}"
                             class="img-fluid structure-image">
                    </div>
                @else
                    <div class="p-2 bg-white shadow border-radius">
                        <div class="structure-placeholder p-5 border-radius">
                            <i class="fas fa-sitemap fa-3x mb-3"></i>
                            <p class="text-muted italic mb-0">
                                "Bagan Visual dalam proses finalisasi oleh pengurus."
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div> --}}
</div>

@endsection