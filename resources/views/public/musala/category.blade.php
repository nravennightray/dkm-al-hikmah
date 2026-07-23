@extends('master.layout.app')

@section('title', $typeLabel . ' - DKM Al Hikmah')

@section('css')
<style>
    .musala-category-hero {
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

    .musala-category-card-wrapper {
        margin-top: -70px;
        position: relative;
        z-index: 2;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid #e9ecef;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .musala-category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 30px 32px;
        border-bottom: 1px solid #e9ecef;
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    }

    .musala-category-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        padding: 8px 13px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 12px;
    }

    .musala-category-title {
        margin-bottom: 6px;
        color: #111827;
        font-size: 28px;
        font-weight: 900;
    }

    .musala-category-subtitle {
        margin-bottom: 0;
        color: #6c757d;
        font-size: 14px;
        line-height: 1.7;
    }

    .musala-category-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .musala-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 44px;
        padding: 0 16px;
        border-radius: 999px;
        background: #ffffff;
        color: #2563eb;
        border: 1px solid rgba(37, 99, 235, 0.18);
        font-size: 13px;
        font-weight: 900;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .musala-back-btn:hover {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .musala-search {
        width: 100%;
        max-width: 360px;
        position: relative;
        flex-shrink: 0;
    }

    .musala-search i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .musala-search input {
        width: 100%;
        height: 46px;
        padding: 0 15px 0 43px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #111827;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
    }

    .musala-search input:focus {
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
    }

    .musala-grid-wrapper {
        padding: 32px;
    }

    .musala-public-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .musala-public-card {
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

    .musala-public-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.10);
    }

    .musala-image-wrap {
        position: relative;
    }

    .musala-public-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f8fafc;
    }

    .musala-public-placeholder {
        width: 100%;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8fafc, #eef2f7);
        color: #94a3b8;
    }

    .musala-floating-type {
        position: absolute;
        left: 14px;
        top: 14px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.94);
        color: #2563eb;
        font-size: 12px;
        font-weight: 900;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.10);
    }

    .musala-public-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .musala-public-tag {
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

    .musala-public-name {
        color: #111827;
        font-size: 18px;
        font-weight: 900;
        margin-bottom: 8px;
        line-height: 1.35;
    }

    .musala-public-location {
        color: #6c757d;
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .musala-public-desc {
        color: #6c757d;
        font-size: 13px;
        line-height: 1.7;
        margin-bottom: 16px;
    }

    .musala-public-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
    }

    .musala-public-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e5e7eb;
        font-size: 12px;
        font-weight: 700;
    }

    .musala-public-action {
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

    .musala-public-action:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .musala-empty {
        grid-column: 1 / -1;
        padding: 70px 24px;
        text-align: center;
    }

    .musala-empty-icon {
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

    .cleanliness-note {
        margin-top: 40px;
        padding: 28px;
        border-radius: 24px;
        background: #ffffff;
        border-left: 5px solid #2563eb;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    @media (max-width: 991px) {
        .musala-category-card-wrapper {
            margin-top: -40px;
        }

        .musala-category-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .musala-category-actions,
        .musala-search {
            width: 100%;
            max-width: 100%;
        }

        .musala-public-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .musala-grid-wrapper {
            padding: 22px;
        }

        .musala-public-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

@php
    $locations = collect($locations ?? []);

    $type = $type ?? '';
    $typeLabel = $typeLabel ?? ($typeOptions[$type] ?? 'Musala');

    $typeIcon = $type === 'plant' ? 'fa-industry' : 'fa-building';

    $typeDesc = $type === 'plant'
        ? 'Daftar sub musala yang berada di area plant.'
        : 'Daftar sub musala yang berada di area kantor.';
@endphp

<div class="section-xl musala-category-hero">
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
                {{ $typeLabel }}
            </span>
        </div>

        <h1 class="fw-normal text-white display-4">
            {{ $typeLabel }}
        </h1>

        <p class="text-white-50 mb-0">
            {{ $typeDesc }}
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <div class="musala-category-card-wrapper">
            <div class="musala-category-header">
                <div>
                    <div class="musala-category-label">
                        <i class="fas {{ $typeIcon }}"></i>
                        {{ $typeLabel }}
                    </div>

                    <h3 class="musala-category-title">
                        Daftar {{ $typeLabel }}
                    </h3>

                    <p class="musala-category-subtitle">
                        Menampilkan {{ $locations->count() }} lokasi {{ strtolower($typeLabel) }}.
                    </p>
                </div>

                <div class="musala-category-actions">
                    <a href="{{ route('musala.index') }}"
                       class="musala-back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Semua Musala
                    </a>

                    <div class="musala-search">
                        <i class="fas fa-search"></i>

                        <input type="text"
                               id="musalaSearchInput"
                               placeholder="Cari nama atau lokasi...">
                    </div>
                </div>
            </div>

            <div class="musala-grid-wrapper">
                <div class="musala-public-grid" id="musalaGrid">
                    @forelse($locations as $loc)
                        @php
                            $slug = $loc['slug'] ?? '';
                            $title = $loc['title'] ?? ($loc['name'] ?? 'Musala');
                            $location = $loc['location'] ?? '';
                            $capacity = $loc['capacity'] ?? '';
                            $desc = $loc['desc'] ?? '';
                            $sortOrder = $loc['sort_order'] ?? '';
                            $facilities = $loc['facilities'] ?? [];

                            if (is_string($facilities)) {
                                $facilities = array_values(array_filter(array_map(
                                    'trim',
                                    preg_split('/[;,]/', $facilities)
                                )));
                            }

                            $image = $loc['image'] ?? '';
                            $imagePath = public_path('image/musala/' . $image);

                            $imageUrl = !empty($image) && file_exists($imagePath)
                                ? asset('image/musala/' . $image) . '?v=' . filemtime($imagePath)
                                : null;

                            $searchText = strtolower(implode(' ', [
                                $slug,
                                $title,
                                $location,
                                $capacity,
                                $desc,
                                $sortOrder,
                                implode(' ', $facilities),
                            ]));
                        @endphp

                        <div class="musala-public-card"
                             data-musala-card
                             data-search="{{ e($searchText) }}">

                            <div class="musala-image-wrap">
                                @if(!empty($imageUrl))
                                    <img src="{{ $imageUrl }}"
                                         class="musala-public-image"
                                         alt="{{ $title }}">
                                @else
                                    <div class="musala-public-placeholder">
                                        <div class="text-center">
                                            <i class="fas fa-image fa-2x"></i>

                                            <div class="small mt-2">
                                                No Image Available
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="musala-floating-type">
                                    <i class="fas {{ $typeIcon }}"></i>
                                    {{ $typeLabel }}
                                </div>
                            </div>

                            <div class="musala-public-body">
                                <div class="musala-public-tag">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ strtoupper(str_replace('-', ' ', $slug)) }}
                                </div>

                                <h3 class="musala-public-name">
                                    {{ $title }}
                                </h3>

                                <div class="musala-public-location">
                                    <i class="fas fa-location-dot me-1"></i>
                                    {{ $location ?: 'Lokasi belum tersedia' }}
                                </div>

                                <p class="musala-public-desc">
                                    {{ $desc ?: 'Fasilitas musala tersedia untuk menunjang kenyamanan jamaah dalam beribadah.' }}
                                </p>

                                <div class="musala-public-meta">
                                    @if($capacity)
                                        <span class="musala-public-pill">
                                            <i class="fas fa-users"></i>
                                            {{ $capacity }}
                                        </span>
                                    @endif

                                    @if(count($facilities))
                                        <span class="musala-public-pill">
                                            <i class="fas fa-circle-check"></i>
                                            {{ count($facilities) }} Fasilitas
                                        </span>
                                    @endif

                                    @if($sortOrder !== '')
                                        <span class="musala-public-pill">
                                            <i class="fas fa-sort-numeric-down"></i>
                                            Urutan {{ $sortOrder }}
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('musala.show', $slug) }}"
                                   class="musala-public-action">
                                    Lihat Detail
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="musala-empty">
                            <div class="musala-empty-icon">
                                <i class="fas {{ $typeIcon }}"></i>
                            </div>

                            <h5 class="fw-bold mb-2">
                                Data {{ $typeLabel }} Belum Tersedia
                            </h5>

                            <p class="text-muted mb-0">
                                Informasi akan ditampilkan setelah admin menambahkan data.
                            </p>
                        </div>
                    @endforelse
                </div>

                <div class="musala-empty d-none" id="musalaEmptySearch">
                    <div class="musala-empty-icon">
                        <i class="fas fa-search"></i>
                    </div>

                    <h5 class="fw-bold mb-2">
                        Musala Tidak Ditemukan
                    </h5>

                    <p class="text-muted mb-0">
                        Coba gunakan kata kunci pencarian lain.
                    </p>
                </div>
            </div>
        </div>

        <div class="cleanliness-note">
            <div class="row align-items-center">
                <div class="col-md-1 text-center d-none d-md-block">
                    <i class="fas fa-info-circle text-primary fa-2x"></i>
                </div>

                <div class="col-md-11">
                    <h5 class="fw-normal mb-1">
                        Menjaga Kenyamanan Bersama
                    </h5>

                    <p class="text-muted small mb-0">
                        Mohon untuk selalu menjaga kebersihan area musala dan merapikan kembali fasilitas ibadah setelah digunakan.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const musalaSearchInput = document.getElementById('musalaSearchInput');
        const musalaCards = document.querySelectorAll('[data-musala-card]');
        const musalaEmptySearch = document.getElementById('musalaEmptySearch');

        function applyMusalaSearch() {
            const keyword = musalaSearchInput
                ? musalaSearchInput.value.toLowerCase().trim()
                : '';

            let visibleCount = 0;

            musalaCards.forEach(function (card) {
                const haystack = card.getAttribute('data-search') || '';
                const isVisible = keyword === '' || haystack.includes(keyword);

                card.style.display = isVisible ? '' : 'none';

                if (isVisible) {
                    visibleCount++;
                }
            });

            if (musalaEmptySearch) {
                musalaEmptySearch.classList.toggle('d-none', visibleCount > 0);
            }
        }

        if (musalaSearchInput) {
            musalaSearchInput.addEventListener('input', applyMusalaSearch);
        }

        applyMusalaSearch();
    });
</script>

@endsection