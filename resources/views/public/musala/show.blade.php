@extends('master.layout.app')

@section('title', ($musala['title'] ?? 'Detail Musala') . ' - DKM Al Hikmah')

@section('css')
<style>
    .musala-detail-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .musala-breadcrumb {
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

    .musala-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
    }

    .musala-breadcrumb a:hover {
        text-decoration: underline;
    }

    .musala-detail-wrapper {
        margin-top: -70px;
        position: relative;
        z-index: 2;
    }

    .musala-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(340px, 0.65fr);
        gap: 28px;
        align-items: start;
    }

    .musala-detail-image-card,
    .musala-detail-info-card {
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid #e9ecef;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .musala-detail-image {
        width: 100%;
        height: 460px;
        object-fit: cover;
        background: #f8fafc;
    }

    .musala-detail-placeholder {
        width: 100%;
        height: 460px;
        background: linear-gradient(135deg, #f8fafc, #eef2f7);
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .musala-detail-content {
        padding: 28px;
    }

    .musala-detail-heading {
        margin-bottom: 12px;
        color: #111827;
        font-size: 22px;
        font-weight: 850;
    }

    .musala-detail-desc {
        color: #6c757d;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .musala-detail-info-card {
        padding: 26px;
    }

    .musala-info-item {
        display: flex;
        gap: 14px;
        padding: 17px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .musala-info-item:last-child {
        border-bottom: none;
    }

    .musala-info-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        border-radius: 15px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .musala-info-label {
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .musala-info-value {
        color: #111827;
        font-size: 14px;
        font-weight: 800;
        line-height: 1.5;
    }

    .facility-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }

    .facility-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        color: #475569;
        font-size: 13px;
        font-weight: 800;
    }

    .facility-pill i {
        color: #198754;
    }

    .musala-detail-note {
        margin-top: 40px;
        padding: 28px;
        border-radius: 24px;
        background: #ffffff;
        border-left: 5px solid #2563eb;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    @media(max-width: 991px) {
        .musala-detail-wrapper {
            margin-top: -40px;
        }

        .musala-detail-grid {
            grid-template-columns: 1fr;
        }

        .musala-detail-image,
        .musala-detail-placeholder {
            height: 320px;
        }
    }
</style>
@endsection

@section('content')

@php
    $title = $musala['title'] ?? ($musala['name'] ?? 'Musala');
    $slug = $musala['slug'] ?? '';
    $location = $musala['location'] ?? '';
    $capacity = $musala['capacity'] ?? '';
    $desc = $musala['desc'] ?? '';
    $facilities = $musala['facilities'] ?? [];

    if (is_string($facilities)) {
        $facilities = array_values(array_filter(array_map(
            'trim',
            preg_split('/[;,]/', $facilities)
        )));
    }

    $image = $musala['image'] ?? '';
    $imagePath = public_path('image/musala/' . $image);

    $imageUrl = !empty($image) && file_exists($imagePath)
        ? asset('image/musala/' . $image) . '?v=' . filemtime($imagePath)
        : null;
@endphp

<div class="section-xl musala-detail-hero">
    <div class="container text-center pt-5">
        <div class="musala-breadcrumb">
            <a href="{{ url('/') }}">
                Beranda
            </a>

            <i class="fas fa-chevron-right small"></i>

            <a href="{{ route('musala.index') }}">
                Fasilitas Musala
            </a>

            <i class="fas fa-chevron-right small"></i>

            <span>
                Detail
            </span>
        </div>

        <h1 class="fw-normal text-white display-4">
            {{ $title }}
        </h1>

        <p class="text-white-50 mb-0">
            <i class="fas fa-map-marker-alt me-1"></i>
            {{ $location ?: 'Lokasi belum tersedia' }}
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <div class="musala-detail-wrapper">
            <div class="musala-detail-grid">

                <div class="musala-detail-image-card">
                    @if(!empty($imageUrl))
                        <img src="{{ $imageUrl }}"
                             alt="{{ $title }}"
                             class="musala-detail-image">
                    @else
                        <div class="musala-detail-placeholder">
                            <div class="text-center">
                                <i class="fas fa-image fa-3x"></i>
                                <div class="small mt-3">
                                    No Image Available
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="musala-detail-content">
                        <h2 class="musala-detail-heading">
                            Tentang Musala
                        </h2>

                        <p class="musala-detail-desc">
                            {{ $desc ?: 'Informasi detail musala belum tersedia.' }}
                        </p>

                        @if(count($facilities))
                            <h2 class="musala-detail-heading mt-4">
                                Fasilitas
                            </h2>

                            <div class="facility-list">
                                @foreach($facilities as $facility)
                                    <span class="facility-pill">
                                        <i class="fas fa-circle-check"></i>
                                        {{ $facility }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <aside class="musala-detail-info-card">
                    <h2 class="musala-detail-heading">
                        Informasi Lokasi
                    </h2>

                    <div class="musala-info-item">
                        <div class="musala-info-icon">
                            <i class="fas fa-mosque"></i>
                        </div>

                        <div>
                            <div class="musala-info-label">
                                Nama Musala
                            </div>

                            <div class="musala-info-value">
                                {{ $title }}
                            </div>
                        </div>
                    </div>

                    <div class="musala-info-item">
                        <div class="musala-info-icon">
                            <i class="fas fa-location-dot"></i>
                        </div>

                        <div>
                            <div class="musala-info-label">
                                Lokasi
                            </div>

                            <div class="musala-info-value">
                                {{ $location ?: '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="musala-info-item">
                        <div class="musala-info-icon">
                            <i class="fas fa-users"></i>
                        </div>

                        <div>
                            <div class="musala-info-label">
                                Kapasitas
                            </div>

                            <div class="musala-info-value">
                                {{ $capacity ?: '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="musala-info-item">
                        <div class="musala-info-icon">
                            <i class="fas fa-circle-check"></i>
                        </div>

                        <div>
                            <div class="musala-info-label">
                                Jumlah Fasilitas
                            </div>

                            <div class="musala-info-value">
                                {{ count($facilities) }} fasilitas
                            </div>
                        </div>
                    </div>

                    @if($slug)
                        <div class="musala-info-item">
                            <div class="musala-info-icon">
                                <i class="fas fa-tag"></i>
                            </div>

                            <div>
                                <div class="musala-info-label">
                                    Kode Lokasi
                                </div>

                                <div class="musala-info-value">
                                    {{ strtoupper(str_replace('-', ' ', $slug)) }}
                                </div>
                            </div>
                        </div>
                    @endif
                </aside>

            </div>
        </div>

        <div class="musala-detail-note">
            <div class="row align-items-center">
                <div class="col-md-1 text-center d-none d-md-block">
                    <i class="fas fa-info-circle text-primary fa-2x"></i>
                </div>

                <div class="col-md-11">
                    <h5 class="fw-normal mb-1">
                        Menjaga Kenyamanan Bersama
                    </h5>

                    <p class="text-muted small mb-0">
                        Mohon untuk selalu menjaga kebersihan area musala, tempat wudhu, dan merapikan kembali perlengkapan ibadah setelah digunakan.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection