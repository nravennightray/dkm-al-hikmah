@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Admin')
@section('page_subtitle', 'Ringkasan kegiatan DKM AL HIKMAH')

@section('css')
<style>
    .dashboard-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 18px;
    }

    .dashboard-grid-main {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
        gap: 18px;
        margin-bottom: 18px;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .dashboard-stat {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .dashboard-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kegiatan-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .kegiatan-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .kegiatan-thumb {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        object-fit: cover;
        background: #eff6ff;
        color: #2563eb;
        flex-shrink: 0;
    }

    .category-mini-card {
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 18px;
        height: 100%;
    }

    .category-mini-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .admin-info-line {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .admin-info-line:last-child {
        border-bottom: none;
    }

    @media (max-width: 991px) {
        .dashboard-grid-3,
        .dashboard-grid-main,
        .category-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="dashboard-grid-3">
    <div class="dashboard-stat p-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted small mb-1">Total Kegiatan</p>
                <h3 class="fw-bold mb-0">{{ $stats['total_kegiatans'] ?? 0 }}</h3>
            </div>

            <div class="dashboard-stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-stat p-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted small mb-1">Kategori</p>
                <h3 class="fw-bold mb-0">{{ $stats['total_categories'] ?? 0 }}</h3>
            </div>

            <div class="dashboard-stat-icon">
                <i class="fas fa-layer-group"></i>
            </div>
        </div>
    </div>

    <div class="dashboard-stat p-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted small mb-1">User Aktif</p>
                <h3 class="fw-bold mb-0">{{ $stats['active_users'] ?? 0 }}</h3>
            </div>

            <div class="dashboard-stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-grid-main">
    <div class="admin-card p-4 h-100">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold mb-1">Kegiatan yang Sudah Ditambahkan</h5>
                <p class="text-muted small mb-0">Data terbaru dari Google Sheet kegiatan.</p>
            </div>

            <a href="#" class="admin-btn-blue">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
        </div>

        @forelse($latestKegiatans as $item)
            @php
                $image = $item['image'] ?? null;
                $title = $item['title'] ?? 'Judul belum tersedia';
                $slug = $item['slug'] ?? null;
                $categorySlug = $item['category_slug'] ?? '-';
                $date = $item['date'] ?? '-';
                $excerpt = $item['excerpt'] ?? 'Deskripsi kegiatan belum tersedia.';
            @endphp

            <div class="kegiatan-row">
                @if(! empty($image))
                    <img src="{{ asset('assets/images/dkm/' . $image) }}"
                            alt="{{ $title }}"
                            class="kegiatan-thumb">
                @else
                    <div class="kegiatan-thumb d-flex align-items-center justify-content-center">
                        <i class="fas fa-image"></i>
                    </div>
                @endif

                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">{{ $title }}</h6>

                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge bg-light text-primary">
                            {{ $categorySlug }}
                        </span>

                        <small class="text-muted">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $date }}
                        </small>
                    </div>
                </div>

                @if(! empty($slug) && $categorySlug !== '-')
                    <a href="{{ route('kegiatan.detail', [$categorySlug, $slug]) }}"
                        target="_blank"
                        class="btn btn-sm btn-outline-primary rounded-pill">
                        Lihat
                    </a>
                @endif
            </div>
        @empty
            <div class="text-center py-5">
                <p class="text-muted mb-0">Belum ada kegiatan.</p>
            </div>
        @endforelse
    </div>

    <div class="admin-card p-4 h-100">
        <h5 class="fw-bold mb-3">Admin Login</h5>

        <div class="admin-info-line">
            <span class="text-muted small">Nama</span>
            <strong class="text-end">
                {{ session('sheet_user.name') ?? auth()->user()->name ?? '-' }}
            </strong>
        </div>

        <div class="admin-info-line">
            <span class="text-muted small">Email</span>
            <strong class="text-end">
                {{ session('sheet_user.email') ?? auth()->user()->email ?? '-' }}
            </strong>
        </div>

        <div class="admin-info-line">
            <span class="text-muted small">Role</span>
            <span class="badge bg-primary">
                {{ session('sheet_user.role') ?? 'admin' }}
            </span>
        </div>

        <div class="mt-4 d-grid gap-2">
            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-globe me-2"></i>
                Lihat Website
            </a>
        </div>
    </div>
</div>

<div class="admin-card p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h5 class="fw-bold mb-1">Kategori Kegiatan</h5>
            <p class="text-muted small mb-0">Kategori yang terdaftar di Google Sheet.</p>
        </div>
    </div>

    <div class="category-grid">
        @forelse($categories ?? [] as $category)
            <div class="category-mini-card">
                <div class="d-flex align-items-start gap-3">
                    <div class="category-mini-icon">
                        <i class="fas {{ $category['icon'] ?? 'fa-folder' }}"></i>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-1">
                            {{ $category['name'] ?? '-' }}
                        </h6>

                        <p class="text-muted small mb-0">
                            {{ $category['desc'] ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted mb-0">Belum ada kategori.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection