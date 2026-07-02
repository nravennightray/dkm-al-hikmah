@extends('admin.layout.app')

@section('title', 'Profil DKM')
@section('page_title', 'Profil DKM')
@section('page_subtitle', 'Kelola data profil, sejarah, visi misi, struktur, dan kepengurusan DKM AL HIKMAH')

@section('css')
<style>
    .profil-page-header {
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

    .profil-eyebrow {
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

    .profil-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .profil-subtitle {
        max-width: 720px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .profil-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
    }

    .profil-section-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 22px;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .profil-section-card:hover {
        transform: translateY(-6px);
        border-color: rgba(37, 99, 235, 0.22);
        box-shadow: 0 16px 38px rgba(37, 99, 235, 0.10);
    }

    .profil-icon {
        width: 54px;
        height: 54px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        margin-bottom: 16px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 24px;
    }

    .profil-section-title {
        margin-bottom: 8px;
        color: #0f172a;
        font-size: 16px;
        font-weight: 850;
        line-height: 1.35;
    }

    .profil-section-sheet {
        margin-bottom: 16px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }

    .profil-section-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: auto;
    }

    .profil-badge {
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

    .profil-badge-primary {
        background: #eff6ff;
        color: #2563eb;
        border-color: rgba(37, 99, 235, 0.14);
    }

    .profil-arrow {
        margin-top: 18px;
        color: #2563eb;
        font-size: 13px;
        font-weight: 800;
    }

    .profil-section-card:hover .profil-arrow {
        transform: translateX(4px);
    }

    .profil-empty {
        padding: 56px 24px;
        text-align: center;
    }

    .profil-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 24px;
    }

    @media (max-width: 1200px) {
        .profil-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 992px) {
        .profil-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 576px) {
        .profil-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .profil-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="profil-page-header">
    <div>
        <span class="profil-eyebrow">
            Manajemen Data
        </span>

        <h3 class="profil-title">
            Profil DKM
        </h3>

        <p class="profil-subtitle">
            Kelola seluruh konten profil DKM AL HIKMAH, mulai dari menu profil, halaman sejarah,
            visi misi, struktur organisasi, kepengurusan, hingga data divisi.
        </p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 mb-4">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

<div class="admin-card p-4">
    @if(($sections ?? collect())->count())

        <div class="profil-grid">
            @foreach($sections as $section)
                @php
                    $key = $section['key'] ?? '';
                    $label = $section['label'] ?? '-';
                    $sheet = $section['sheet'] ?? '-';
                    $total = $section['total'] ?? 0;
                    $columns = $section['columns'] ?? 0;

                    $icons = [
                        'menu' => 'bi-grid-3x3-gap',
                        'pages' => 'bi-file-earmark-text',
                        'milestones' => 'bi-clock-history',
                        'missions' => 'bi-bullseye',
                        'values' => 'bi-stars',
                        'structure' => 'bi-diagram-3',
                        'pengurus' => 'bi-people',
                        'divisions' => 'bi-diagram-2',
                    ];

                    $icon = $icons[$key] ?? 'bi-folder';
                @endphp

                <a href="{{ route('admin.profil.section.index', $key) }}"
                   class="profil-section-card">

                    <div class="profil-icon">
                        <i class="bi {{ $icon }}"></i>
                    </div>

                    <div class="profil-section-title">
                        {{ $label }}
                    </div>

                    <div class="profil-section-sheet">
                        Sheet:
                        <strong>{{ $sheet }}</strong>
                    </div>

                    <div class="profil-section-meta">
                        <span class="profil-badge profil-badge-primary">
                            <i class="bi bi-table"></i>
                            {{ $total }} Data
                        </span>

                        <span class="profil-badge">
                            <i class="bi bi-layout-three-columns"></i>
                            {{ $columns }} Kolom
                        </span>
                    </div>

                    <div class="profil-arrow">
                        Kelola Data
                        <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            @endforeach
        </div>

    @else

        <div class="profil-empty">
            <div class="profil-empty-icon">
                <i class="bi bi-person-badge"></i>
            </div>

            <h5 class="fw-bold mb-2">
                Section profil belum tersedia
            </h5>

            <p class="text-muted mb-0">
                Konfigurasi section Profil DKM belum ditemukan.
            </p>
        </div>

    @endif
</div>

@endsection