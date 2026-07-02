@extends('master.layout.app')

@section('title', ($page['title'] ?? 'Kepengurusan') . ' - DKM Al Hikmah')

@section('css')
<style>
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.55) !important;
        content: "/" !important;
    }

    .breadcrumb-item a:hover {
        color: #fff !important;
        text-decoration: underline;
    }

    .team-card {
        transition: all 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-8px);
    }

    .team-img-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.10);
        background: #f8fafc;
    }

    .team-img-wrapper img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .team-card:hover img {
        transform: scale(1.05);
    }

    .team-role-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-top: 0.25rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .division-card {
        padding: 2rem;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        border-radius: 24px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        height: 100%;
    }

    .division-title {
        padding-bottom: 1rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.12);
        font-weight: 700;
    }

    .division-title i {
        color: #2563eb;
    }

    .list-group-item {
        border-color: rgba(37, 99, 235, 0.08);
        font-size: 0.95rem;
        padding-top: 0.9rem;
        padding-bottom: 0.9rem;
    }

    .member-name {
        color: #0f172a;
        font-weight: 700;
        text-align: right;
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

    @media (max-width: 576px) {
        .list-group-item {
            align-items: flex-start !important;
            flex-direction: column;
            gap: 4px;
        }

        .member-name {
            text-align: left;
        }
    }
</style>
@endsection

@section('content')

@php
    $title = $page['title'] ?? 'Kepengurusan';
    $heroBadge = $page['hero_badge'] ?? 'Struktur Pengurus';
    $heroIcon = $page['hero_icon'] ?? 'fas fa-users';
    $sectionLabel = $page['section_label'] ?? 'Tim Pengurus';
    $sectionTitle = $page['section_title'] ?? 'Dewan Pengurus Harian';
    $periodText = $page['section_body_1'] ?? 'Masa Bakti 2024 - 2027';

    $dailyPengurus = $dailyPengurus ?? collect();
    $divisionPengurus = $divisionPengurus ?? collect();
    $divisions = $divisions ?? collect();

    $placeholderImage = asset('assets/images/dkm/user-placeholder.jpg');
@endphp

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
            <i class="{{ $heroIcon }} me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">
                {{ $heroBadge }}
            </span>
        </div>

        <h1 class="fw-bold text-white display-4">
            {{ $title }}
        </h1>

        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="/" class="text-white text-decoration-none opacity-75">Beranda</a>
                </li>
                <li class="breadcrumb-item text-white opacity-75">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $title }}
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">

        <div class="section-title text-center mb-5">
            <h6 class="font-small uppercase letter-spacing-1" style="color: #2563eb;">
                {{ $sectionLabel }}
            </h6>

            <h2 class="fw-bold">
                {{ $sectionTitle }}
            </h2>

            @if(!empty($periodText))
                <p class="text-muted">
                    {{ $periodText }}
                </p>
            @endif
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($dailyPengurus as $pengurus)
                @php
                    $name = $pengurus['name'] ?? '-';
                    $role = $pengurus['role'] ?? '-';
                    $image = $pengurus['image'] ?? '';

                    $imageUrl = !empty($image)
                        ? asset('image/profil/' . $image)
                        : $placeholderImage;
                @endphp

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="team-card text-center">
                        <div class="team-img-wrapper mb-4">
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $name }}"
                                 class="img-fluid"
                                 onerror="this.onerror=null;this.src='{{ $placeholderImage }}';">
                        </div>

                        <h5 class="mb-1 fw-bold">
                            {{ $name }}
                        </h5>

                        <span class="team-role-badge">
                            {{ $role }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="profile-empty">
                        <div class="profile-empty-icon">
                            <i class="fas fa-users"></i>
                        </div>

                        <h5 class="fw-bold mb-2">
                            Data Pengurus Harian Belum Tersedia
                        </h5>

                        <p class="text-muted mb-0">
                            Data dewan pengurus harian belum tersedia saat ini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <hr class="my-5" style="border-color: rgba(37, 99, 235, 0.12);">

        <div class="row g-4">
            @forelse($divisions as $division)
                @php
                    $divisionTitle = $division['title'] ?? ($division['slug'] ?? '-');
                    $divisionSlug = $division['slug'] ?? '';
                    $divisionIcon = $division['icon'] ?? 'fas fa-users';

                    $members = $divisionPengurus->get($divisionTitle)
                        ?? $divisionPengurus->get($divisionSlug)
                        ?? collect();
                @endphp

                <div class="col-lg-6">
                    <div class="division-card">
                        <h4 class="division-title">
                            <i class="{{ $divisionIcon }} me-2"></i>
                            {{ $divisionTitle }}
                        </h4>

                        @if($members->count())
                            <ul class="list-group list-group-flush">
                                @foreach($members as $member)
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                        <span>{{ $member['role'] ?? '-' }}</span>
                                        <span class="member-name">{{ $member['name'] ?? '-' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">
                                Belum ada anggota pada bidang ini.
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                @forelse($divisionPengurus as $divisionName => $members)
                    <div class="col-lg-6">
                        <div class="division-card">
                            <h4 class="division-title">
                                <i class="fas fa-users me-2"></i>
                                {{ $divisionName }}
                            </h4>

                            <ul class="list-group list-group-flush">
                                @foreach($members as $member)
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                        <span>{{ $member['role'] ?? '-' }}</span>
                                        <span class="member-name">{{ $member['name'] ?? '-' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="profile-empty">
                            <div class="profile-empty-icon">
                                <i class="fas fa-sitemap"></i>
                            </div>

                            <h5 class="fw-bold mb-2">
                                Data Bidang Belum Tersedia
                            </h5>

                            <p class="text-muted mb-0">
                                Data anggota bidang belum tersedia saat ini.
                            </p>
                        </div>
                    </div>
                @endforelse
            @endforelse
        </div>

    </div>
</div>

@endsection