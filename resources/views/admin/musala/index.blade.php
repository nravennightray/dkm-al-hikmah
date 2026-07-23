@extends('admin.layout.app')

@section('title', 'Musala')
@section('page_title', 'Musala Management')
@section('page_subtitle', 'Kelola data Musala Kantor & Musala Plant')

@section('css')
<style>
    .musala-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 24px;
        border-radius: 24px;
        background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        border: 1px solid rgba(37, 99, 235, 0.12);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }

    .musala-eyebrow {
        display: inline-flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 6px 12px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .musala-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .musala-subtitle {
        max-width: 620px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .admin-btn-blue {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        background: #2563eb;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        transition: all .2s ease;
        white-space: nowrap;
    }

    .admin-btn-blue:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .musala-filter-card {
        margin-bottom: 24px;
        padding: 18px;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .musala-filter-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .musala-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .musala-tab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: all .2s ease;
    }

    .musala-tab:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: rgba(37, 99, 235, .18);
    }

    .musala-tab.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 10px 24px rgba(37, 99, 235, .22);
    }

    .musala-tab-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 24px;
        padding: 0 7px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #475569;
        font-size: 12px;
        font-weight: 900;
    }

    .musala-tab.active .musala-tab-count {
        background: rgba(255, 255, 255, .2);
        color: #ffffff;
    }

    .musala-search {
        width: 100%;
        max-width: 340px;
        position: relative;
        flex-shrink: 0;
    }

    .musala-search i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .musala-search input {
        width: 100%;
        height: 44px;
        padding: 0 14px 0 42px;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        background: #ffffff;
        color: #0f172a;
        font-size: 14px;
        outline: none;
        transition: all .2s ease;
    }

    .musala-search input:focus {
        border-color: rgba(37, 99, 235, .45);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .10);
    }

    .musala-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 28px;
    }

    .musala-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        transition: all .25s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .musala-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    }

    .musala-image-wrap {
        position: relative;
    }

    .musala-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #f8fafc;
    }

    .musala-placeholder {
        width: 100%;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8fafc, #eef2f7);
        color: #94a3b8;
    }

    .musala-type-floating {
        position: absolute;
        left: 14px;
        top: 14px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .92);
        color: #2563eb;
        font-size: 12px;
        font-weight: 900;
        box-shadow: 0 8px 20px rgba(15, 23, 42, .10);
    }

    .musala-body {
        padding: 18px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .musala-meta-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

    .musala-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        width: fit-content;
    }

    .musala-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        width: fit-content;
    }

    .musala-status.active {
        background: #ecfdf5;
        color: #047857;
    }

    .musala-status.inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    .musala-name {
        font-size: 18px;
        font-weight: 850;
        color: #0f172a;
        margin-bottom: 8px;
        line-height: 1.35;
    }

    .musala-location {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .musala-info-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
    }

    .musala-info-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e5e7eb;
        font-size: 12px;
        font-weight: 750;
    }

    .musala-card-actions {
        margin-top: auto;
        display: flex;
        gap: 10px;
    }

    .musala-card-actions form {
        flex: 1;
    }

    .musala-action,
    .musala-delete-action {
        width: 100%;
    }

    .musala-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        border-radius: 10px;
        background: #2563eb;
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s ease;
    }

    .musala-action:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .musala-delete-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        border-radius: 10px;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid rgba(220, 38, 38, 0.12);
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s ease;
        cursor: pointer;
    }

    .musala-delete-action:hover {
        background: #dc2626;
        color: #ffffff;
    }

    .musala-empty-state {
        padding: 56px 24px;
        text-align: center;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    @media (max-width: 992px) {
        .musala-filter-row {
            align-items: stretch;
            flex-direction: column;
        }

        .musala-search {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .musala-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .musala-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

@php
    $musalaCollection = collect($musala ?? []);

    $typeOptions = $typeOptions ?? [
        'plant' => 'Musala Plant',
        'kantor' => 'Musala Kantor',
    ];

    $allCount = $musalaCollection->count();
    $plantCount = $musalaCollection->where('type', 'plant')->count();
    $kantorCount = $musalaCollection->where('type', 'kantor')->count();
@endphp

<div class="musala-page-header">
    <div>
        <span class="musala-eyebrow">Manajemen Data</span>

        <h3 class="musala-title">
            Musala Management
        </h3>

        <p class="musala-subtitle">
            Kelola data sub musala berdasarkan kategori Musala Kantor & Musala Plant.
        </p>
    </div>

    <a href="{{ route('admin.musala.create') }}"
       class="admin-btn-blue">
        <i class="bi bi-plus-lg"></i>
        Tambah Musala
    </a>
</div>

<div class="musala-filter-card">
    <div class="musala-filter-row">
        <div class="musala-tabs">
            <button type="button"
                    class="musala-tab active"
                    data-musala-filter="all">
                <i class="bi bi-grid"></i>
                Semua
                <span class="musala-tab-count">{{ $allCount }}</span>
            </button>

            <button type="button"
                    class="musala-tab"
                    data-musala-filter="plant">
                <i class="bi bi-buildings"></i>
                Musala Plant
                <span class="musala-tab-count">{{ $plantCount }}</span>
            </button>

            <button type="button"
                    class="musala-tab"
                    data-musala-filter="kantor">
                <i class="bi bi-building"></i>
                Musala Kantor
                <span class="musala-tab-count">{{ $kantorCount }}</span>
            </button>
        </div>

        <div class="musala-search">
            <i class="bi bi-search"></i>
            <input type="text"
                   id="musalaSearchInput"
                   placeholder="Cari nama atau lokasi...">
        </div>
    </div>
</div>

@if($musalaCollection->count())
    <div class="musala-grid" id="musalaGrid">
        @foreach($musalaCollection as $item)
            @php
                $slug = $item['slug'] ?? '';
                $type = $item['type'] ?? '';
                $typeLabel = $item['type_label'] ?? ($typeOptions[$type] ?? 'Belum Dikategorikan');
                $title = $item['title'] ?? '';
                $location = $item['location'] ?? '';
                $capacity = $item['capacity'] ?? '';
                $facilities = $item['facilities'] ?? '';
                $desc = $item['desc'] ?? '';
                $sortOrder = $item['sort_order'] ?? '';
                $status = $item['status'] ?? 'active';

                $image = $item['image'] ?? '';
                $imagePath = public_path('image/musala/' . $image);

                $hasImage = !empty($image) && file_exists($imagePath);

                $imageUrl = $hasImage
                    ? asset('image/musala/' . $image) . '?v=' . filemtime($imagePath)
                    : asset('assets/images/dkm/default-image.jpg');

                $facilityCount = collect(preg_split('/[;,]/', (string) $facilities))
                    ->map(fn ($facility) => trim($facility))
                    ->filter()
                    ->count();

                $searchText = strtolower(implode(' ', [
                    $slug,
                    $type,
                    $typeLabel,
                    $title,
                    $location,
                    $capacity,
                    $facilities,
                    $desc,
                    $sortOrder,
                    $status,
                ]));
            @endphp

            <div class="musala-card"
                 data-musala-card
                 data-type="{{ $type }}"
                 data-search="{{ e($searchText) }}">

                <div class="musala-image-wrap">
                    @if($hasImage)
                        <img src="{{ $imageUrl }}"
                             class="musala-img"
                             alt="{{ $title ?: 'Musala' }}">
                    @else
                        <div class="musala-placeholder">
                            <div class="text-center">
                                <i class="bi bi-image fs-1"></i>
                                <div class="small mt-2">
                                    No Image Available
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="musala-type-floating">
                        <i class="bi bi-building"></i>
                        {{ $typeLabel }}
                    </div>
                </div>

                <div class="musala-body">
                    <div class="musala-meta-row">
                        @if($sortOrder !== '')
                            <span class="musala-badge">
                                <i class="bi bi-sort-numeric-down"></i>
                                Urutan {{ $sortOrder }}
                            </span>
                        @endif

                        <span class="musala-status {{ $status === 'active' ? 'active' : 'inactive' }}">
                            <i class="bi {{ $status === 'active' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                            {{ ucfirst($status) }}
                        </span>
                    </div>

                    <div class="musala-name">
                        {{ $title }}
                    </div>

                    <div class="musala-location">
                        <i class="bi bi-geo-alt me-1"></i>
                        {{ $location ?: 'Lokasi belum diisi' }}
                    </div>

                    <div class="musala-info-pills">
                        @if($capacity)
                            <span class="musala-info-pill">
                                <i class="bi bi-people"></i>
                                {{ $capacity }}
                            </span>
                        @endif

                        <span class="musala-info-pill">
                            <i class="bi bi-check2-circle"></i>
                            {{ $facilityCount }} Fasilitas
                        </span>
                    </div>

                    <div class="musala-card-actions">
                        <a href="{{ route('admin.musala.edit', $slug) }}"
                           class="musala-action">
                            <i class="bi bi-pencil"></i>
                            Edit
                        </a>

                        <form action="{{ route('admin.musala.destroy', $slug) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus data musala ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="musala-delete-action">
                                <i class="bi bi-trash"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="musala-empty-state mt-4" id="musalaEmptyFiltered" style="display: none;">
        <i class="bi bi-search fs-1 text-muted"></i>

        <h5 class="mt-3 mb-2">
            Data Musala Tidak Ditemukan
        </h5>

        <p class="text-muted mb-0">
            Coba pilih tab lain atau gunakan kata kunci pencarian yang berbeda.
        </p>
    </div>
@else
    <div class="musala-empty-state">
        <i class="bi bi-building fs-1 text-muted"></i>

        <h5 class="mt-3">
            Data Musala tidak ditemukan
        </h5>

        <p class="text-muted mb-0">
            Belum ada data sub musala yang ditambahkan.
        </p>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const musalaTabs = document.querySelectorAll('[data-musala-filter]');
        const musalaCards = document.querySelectorAll('[data-musala-card]');
        const musalaSearchInput = document.getElementById('musalaSearchInput');
        const musalaEmptyFiltered = document.getElementById('musalaEmptyFiltered');

        let activeMusalaType = 'all';

        function applyMusalaFilter() {
            const keyword = musalaSearchInput
                ? musalaSearchInput.value.toLowerCase().trim()
                : '';

            let visibleCount = 0;

            musalaCards.forEach(function (card) {
                const cardType = card.getAttribute('data-type') || '';
                const haystack = card.getAttribute('data-search') || '';

                const matchesType = activeMusalaType === 'all' || cardType === activeMusalaType;
                const matchesKeyword = keyword === '' || haystack.includes(keyword);

                const isVisible = matchesType && matchesKeyword;

                card.style.display = isVisible ? '' : 'none';

                if (isVisible) {
                    visibleCount++;
                }
            });

            if (musalaEmptyFiltered) {
                musalaEmptyFiltered.style.display = visibleCount > 0 ? 'none' : 'block';
            }
        }

        musalaTabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                musalaTabs.forEach(function (item) {
                    item.classList.remove('active');
                });

                tab.classList.add('active');
                activeMusalaType = tab.getAttribute('data-musala-filter') || 'all';

                applyMusalaFilter();
            });
        });

        if (musalaSearchInput) {
            musalaSearchInput.addEventListener('input', applyMusalaFilter);
        }

        applyMusalaFilter();
    });
</script>

@endsection