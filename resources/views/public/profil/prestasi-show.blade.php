@extends('master.layout.app')

@section('title', ($prestasi['title'] ?? 'Detail Prestasi') . ' - DKM Al Hikmah')

@section('css')
<style>
    .article-hero-badge {
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
        .article-breadcrumb {
            flex-wrap: wrap;
            border-radius: 18px;
            line-height: 1.6;
        }
    }
    .article-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .article-breadcrumb {
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

    .article-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
    }

    .article-breadcrumb a:hover {
        text-decoration: underline;
    }

    .article-card {
        margin-top: -70px;
        position: relative;
        z-index: 2;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid #e9ecef;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .article-image {
        width: 100%;
        height: 460px;
        object-fit: cover;
        background: #f8fafc;
    }

    .article-placeholder {
        height: 460px;
        background: linear-gradient(135deg, #f8fafc, #eef2f7);
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .article-content {
        max-width: 860px;
        margin: 0 auto;
        padding: 42px 32px 54px;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 22px;
    }

    .article-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 800;
    }

    .article-title {
        margin-bottom: 18px;
        color: #111827;
        font-size: clamp(30px, 5vw, 46px);
        font-weight: 900;
        line-height: 1.18;
    }

    .article-summary {
        margin-bottom: 28px;
        padding: 22px 24px;
        border-radius: 22px;
        background: #f8fafc;
        border-left: 5px solid #2563eb;
        color: #4b5563;
        font-size: 15px;
        line-height: 1.8;
    }

    .article-body {
        color: #4b5563;
        font-size: 16px;
        line-height: 1.9;
    }

    .article-body p {
        margin-bottom: 18px;
    }

    .article-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 30px;
        color: #2563eb;
        font-weight: 800;
        text-decoration: none;
    }

    .article-back:hover {
        color: #1d4ed8;
    }

    @media(max-width: 991px) {
        .article-card {
            margin-top: -40px;
        }

        .article-image,
        .article-placeholder {
            height: 320px;
        }
    }
</style>
@endsection

@section('content')

@php
    $title = $prestasi['title'] ?? 'Detail Prestasi';
    $category = $prestasi['category'] ?? 'Prestasi';
    $shortDesc = $prestasi['short_desc'] ?? '';
    $content = $prestasi['content'] ?? '';
    $achievedAt = $prestasi['achieved_at'] ?? '';

    $image = $prestasi['image'] ?? '';
    $imagePath = public_path('image/profil/' . $image);

    $imageUrl = !empty($image) && file_exists($imagePath)
        ? asset('image/profil/' . $image) . '?v=' . filemtime($imagePath)
        : null;

    $paragraphs = collect(preg_split("/\r\n|\n|\r/", $content))
        ->map(fn ($paragraph) => trim($paragraph))
        ->filter()
        ->values();
@endphp

<div class="section-xl article-hero">
    <div class="container text-center pt-5">
        <div class="article-breadcrumb">
            <a href="{{ url('/') }}">
                Beranda
            </a>

            <i class="fas fa-chevron-right small"></i>

            <a href="{{ route('profil.index') }}">
                Profil
            </a>

            <i class="fas fa-chevron-right small"></i>

            <a href="{{ route('profil.prestasi') }}">
                Prestasi
            </a>

            <i class="fas fa-chevron-right small"></i>

            <span>
                Detail Prestasi
            </span>
        </div>

        <h1 class="fw-normal text-white display-4">
            Detail Prestasi
        </h1>

        <p class="text-white-50 mb-0">
            {{ $shortDesc ?: 'Dokumentasi pencapaian DKM Al Hikmah.' }}
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <article class="article-card">
            @if(!empty($imageUrl))
                <img src="{{ $imageUrl }}"
                     class="article-image"
                     alt="{{ $title }}">
            @else
                <div class="article-placeholder">
                    <div class="text-center">
                        <i class="fas fa-trophy fa-3x"></i>

                        <div class="small mt-3">
                            No Image Available
                        </div>
                    </div>
                </div>
            @endif

            <div class="article-content">
                <div class="article-meta">
                    <span class="article-pill">
                        <i class="fas fa-trophy"></i>
                        {{ $category }}
                    </span>

                    @if($achievedAt)
                        <span class="article-pill">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $achievedAt }}
                        </span>
                    @endif
                </div>

                <h1 class="article-title">
                    {{ $title }}
                </h1>

                @if($shortDesc)
                    <div class="article-summary">
                        {{ $shortDesc }}
                    </div>
                @endif

                <div class="article-body">
                    @if($paragraphs->count())
                        @foreach($paragraphs as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    @else
                        <p>
                            Detail prestasi belum tersedia.
                        </p>
                    @endif
                </div>

                <a href="{{ route('profil.prestasi') }}"
                   class="article-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke daftar prestasi
                </a>
            </div>
        </article>

    </div>
</div>

@endsection