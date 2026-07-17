@extends('master.layout.app')

@section('title', 'Prestasi - DKM Al Hikmah')

@section('css')
<style>
    .prestasi-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .prestasi-breadcrumb {
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

    .prestasi-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
    }

    .prestasi-breadcrumb a:hover {
        text-decoration: underline;
    }

    .prestasi-list-card {
        margin-top: -70px;
        position: relative;
        z-index: 2;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid #e9ecef;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .prestasi-list-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 28px 32px;
        border-bottom: 1px solid #e9ecef;
    }

    .prestasi-list-title {
        margin-bottom: 6px;
        color: #111827;
        font-size: 26px;
        font-weight: 800;
    }

    .prestasi-list-subtitle {
        margin-bottom: 0;
        color: #6c757d;
        font-size: 14px;
        line-height: 1.7;
    }

    .prestasi-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    .prestasi-grid-wrapper {
        padding: 32px;
    }

    .prestasi-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .prestasi-card {
        height: 100%;
        border-radius: 24px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
    }

    .prestasi-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10);
    }

    .prestasi-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f8fafc;
    }

    .prestasi-placeholder {
        width: 100%;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8fafc, #eef2f7);
        color: #94a3b8;
    }

    .prestasi-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .prestasi-tag {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        width: fit-content;
        padding: 7px 11px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .prestasi-name {
        color: #111827;
        font-size: 18px;
        font-weight: 900;
        margin-bottom: 8px;
        line-height: 1.35;
    }

    .prestasi-date {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .prestasi-desc {
        color: #6c757d;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .prestasi-action {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 42px;
        padding: 0 16px;
        border-radius: 12px;
        background: #2563eb;
        color: #ffffff;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .prestasi-action:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .prestasi-empty {
        grid-column: 1 / -1;
        padding: 70px 24px;
        text-align: center;
    }

    .prestasi-empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 22px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 18px;
    }

    .prestasi-note {
        margin-top: 40px;
        padding: 28px;
        border-radius: 24px;
        background: #ffffff;
        border-left: 5px solid #2563eb;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    @media (max-width: 991px) {
        .prestasi-list-card {
            margin-top: -40px;
        }

        .prestasi-list-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .prestasi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .prestasi-grid-wrapper {
            padding: 22px;
        }

        .prestasi-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="section-xl prestasi-hero">
    <div class="container text-center pt-5">
        <div class="prestasi-breadcrumb">
            <a href="{{ url('/') }}">
                Beranda
            </a>

            <i class="fas fa-chevron-right small"></i>

            <a href="{{ route('profil.index') }}">
                Profil
            </a>

            <i class="fas fa-chevron-right small"></i>

            <span>
                Prestasi
            </span>
        </div>

        <h1 class="fw-normal text-white display-4">
            {{ $page['title'] ?? 'Prestasi DKM' }}
        </h1>

        <p class="text-white-50 mb-0">
            {{ $page['subtitle'] ?? 'Dokumentasi pencapaian dan prestasi DKM Al Hikmah.' }}
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <div class="prestasi-list-card">
            <div class="prestasi-list-header">
                <div>
                    <h3 class="prestasi-list-title">
                        Daftar Prestasi
                    </h3>

                    <p class="prestasi-list-subtitle">
                        Dokumentasi pencapaian, penghargaan, dan kontribusi positif DKM AL HIKMAH.
                    </p>
                </div>

                <span class="prestasi-count-badge">
                    <i class="fas fa-trophy"></i>
                    {{ ($prestasi ?? collect())->count() }} Prestasi
                </span>
            </div>

            <div class="prestasi-grid-wrapper">
                <div class="prestasi-grid">
                    @forelse($prestasi as $item)
                        @php
                            $slug = $item['slug'] ?? '';
                            $title = $item['title'] ?? 'Prestasi';
                            $category = $item['category'] ?? 'Prestasi';
                            $shortDesc = $item['short_desc'] ?? '';
                            $achievedAt = $item['achieved_at'] ?? '';

                            $image = $item['image'] ?? '';
                            $imagePath = public_path('image/profil/' . $image);

                            $imageUrl = !empty($image) && file_exists($imagePath)
                                ? asset('image/profil/' . $image) . '?v=' . filemtime($imagePath)
                                : null;
                        @endphp

                        <div class="prestasi-card">
                            @if(!empty($imageUrl))
                                <img src="{{ $imageUrl }}"
                                     class="prestasi-image"
                                     alt="{{ $title }}">
                            @else
                                <div class="prestasi-placeholder">
                                    <div class="text-center">
                                        <i class="fas fa-trophy fa-2x"></i>

                                        <div class="small mt-2">
                                            No Image Available
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="prestasi-body">
                                <div class="prestasi-tag">
                                    <i class="fas fa-trophy"></i>
                                    {{ $category }}
                                </div>

                                <h3 class="prestasi-name">
                                    {{ $title }}
                                </h3>

                                @if($achievedAt)
                                    <div class="prestasi-date">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $achievedAt }}
                                    </div>
                                @endif

                                <p class="prestasi-desc">
                                    {{ $shortDesc ?: 'Prestasi ini menjadi bagian dari perjalanan DKM Al Hikmah dalam memberikan manfaat bagi jamaah.' }}
                                </p>

                                <a href="{{ route('profil.prestasi.show', $slug) }}"
                                   class="prestasi-action">
                                    Baca Detail
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="prestasi-empty">
                            <div class="prestasi-empty-icon">
                                <i class="fas fa-trophy"></i>
                            </div>

                            <h5 class="fw-bold mb-2">
                                Data Prestasi Belum Tersedia
                            </h5>

                            <p class="text-muted mb-0">
                                Prestasi DKM akan tampil setelah admin menambahkan data.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="prestasi-note">
            <div class="row align-items-center">
                <div class="col-md-1 text-center d-none d-md-block">
                    <i class="fas fa-info-circle text-primary fa-2x"></i>
                </div>

                <div class="col-md-11">
                    <h5 class="fw-normal mb-1">
                        Dokumentasi Prestasi
                    </h5>

                    <p class="text-muted small mb-0">
                        Setiap prestasi menjadi catatan perjalanan DKM AL HIKMAH dalam menghadirkan kegiatan yang bermanfaat bagi jamaah dan lingkungan sekitar.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection