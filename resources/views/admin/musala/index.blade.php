@extends('admin.layout.app')

@section('title', 'Musala')
@section('page_title', 'Musala Management')
@section('page_subtitle', 'Kelola data Musala Kantor & Musala Plant')

@section('css')
<style>
    /* =========================
       HEADER (match kegiatan style)
       ========================= */
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
        margin-bottom: 28px;
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

    /* =========================
       GRID LAYOUT (IMPORTANT)
       ========================= */
    .musala-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 28px; /* BIGGER spacing */
    }

    @media (max-width: 768px) {
        .musala-grid {
            grid-template-columns: 1fr;
        }
    }

    /* =========================
       CARD STYLE
       ========================= */
    .musala-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
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

    /* IMAGE */
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

    /* BODY */
    .musala-body {
        padding: 18px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .musala-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 10px;
        width: fit-content;
    }

    .musala-name {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .musala-location {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 18px;
    }

    /* BUTTON */
    .musala-action {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        border-radius: 10px;
        background: #2563eb;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .musala-action:hover {
        background: #1d4ed8;
        color: #fff;
    }
</style>
@endsection

@section('content')

<div class="musala-page-header">
    <div>
        <span class="musala-eyebrow">Manajemen Data</span>
        <h3 class="musala-title">Musala Management</h3>
        <p class="musala-subtitle">
            Kelola data Musala Kantor & Musala Plant untuk kebutuhan operasional DKM AL HIKMAH.
        </p>
    </div>
</div>

{{-- GRID --}}
<div class="musala-grid">

    @forelse($musala as $item)

        @php
            $slug = $item['slug'] ?? '';
            $title = $item['title'] ?? '';
            $location = $item['location'] ?? '';
            $image = $item['image'] ?? null;
        @endphp

        <div class="musala-card">

            {{-- IMAGE --}}
            @if(!empty($image))
                <img src="{{ asset('image/musala/' . $image) }}"
                     class="musala-img"
                     alt="{{ $title }}">
            @else
                <div class="musala-placeholder">
                    <div class="text-center">
                        <i class="bi bi-image fs-1"></i>
                        <div class="small mt-2">No Image Available</div>
                    </div>
                </div>
            @endif

            {{-- BODY --}}
            <div class="musala-body">

                <div class="musala-badge">
                    {{ strtoupper(str_replace('-', ' ', $slug)) }}
                </div>

                <div class="musala-name">
                    {{ $title }}
                </div>

                <div class="musala-location">
                    <i class="bi bi-geo-alt me-1"></i>
                    {{ $location }}
                </div>

                <a href="{{ route('admin.musala.edit', $slug) }}"
                   class="musala-action">
                    <i class="bi bi-pencil"></i>
                    Edit Data
                </a>
            </div>
        </div>
    @empty
        <div class="admin-card p-5 text-center">
            <i class="bi bi-building fs-1 text-muted"></i>
            <h5 class="mt-3">Data Musala tidak ditemukan</h5>
        </div>
    @endforelse
</div>

@endsection