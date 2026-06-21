@extends('master.layout.app')

@section('title', ($post['title'] ?? ucwords(str_replace('-', ' ', $slug))) . ' - DKM Al Hikmah')

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

    .post-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.92) 0%,
            rgba(37, 99, 235, 0.86) 55%,
            rgba(14, 165, 233, 0.78) 100%
        );
    }

    .post-image-placeholder {
        min-height: 360px;
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
        border: 1px solid rgba(37, 99, 235, 0.12);
        color: #2563eb;
    }

    .post-meta i {
        color: #2563eb;
    }

    .post-content {
        line-height: 1.9;
    }

    .post-content p {
        margin-bottom: 1.2rem;
    }

    .post-quote {
        background: #eff6ff;
        border-left: 4px solid #2563eb;
        color: #334155;
    }

    .btn-outline-dkm {
        color: #2563eb;
        border-color: #2563eb;
    }

    .btn-outline-dkm:hover {
        color: #ffffff;
        background-color: #2563eb;
        border-color: #2563eb;
    }
</style>
@endsection

@section('content')

@php
    $title = $post['title'] ?? ucwords(str_replace('-', ' ', $slug));
    $date = $post['date'] ?? null;
    $image = $post['image'] ?? null;
    $excerpt = $post['excerpt'] ?? null;
    $content = $post['content'] ?? null;
    $quote = $post['quote'] ?? null;
@endphp

<div class="section-sm post-hero">
    <div class="container pt-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9">
                <h1 class="fw-bold text-white display-5 mb-3">
                    {{ $title }}
                </h1>

                <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-4">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item">
                            <a href="/" class="text-white-50 text-decoration-none">Beranda</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('kegiatan.index') }}" class="text-white-50 text-decoration-none">Kegiatan</a>
                        </li>

                        <li class="breadcrumb-item">
                            <a href="{{ route('kegiatan.category', $currentCategory['slug']) }}" class="text-white-50 text-decoration-none">
                                {{ $currentCategory['name'] }}
                            </a>
                        </li>

                        <li class="breadcrumb-item active text-white" aria-current="page">
                            {{ $title }}
                        </li>
                    </ol>
                </nav>

                @if(! empty($excerpt))
                    <p class="text-white mb-0">
                        {{ $excerpt }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="post-meta d-flex flex-wrap align-items-center mb-4 text-muted">
                    @if(! empty($date))
                        <span class="me-3">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $date }}
                        </span>
                    @endif

                    <span>
                        <i class="far fa-folder me-1"></i>
                        {{ $currentCategory['name'] }}
                    </span>
                </div>

                <div class="mb-5 shadow-sm border-radius overflow-hidden">
                    @if(! empty($image) && ! empty($post['id_kegiatan']))
                        <img src="{{ asset('image/kegiatan/' . $post['id_kegiatan'] . '/' . $image) }}"
                            class="img-fluid w-100"
                            alt="{{ $title }}">
                    @else
                        <div class="post-image-placeholder">
                            Belum ada gambar
                        </div>
                    @endif
                </div>

                <div class="post-content lead-drop-cap">
                    @if(! empty($content))
                        @foreach(preg_split("/\r\n|\n|\r/", $content) as $paragraph)
                            @if(trim($paragraph) !== '')
                                <p>{{ $paragraph }}</p>
                            @endif
                        @endforeach
                    @else
                        <p>
                            Konten lengkap untuk kegiatan ini belum tersedia.
                        </p>
                    @endif

                    @if(! empty($quote))
                        <blockquote class="post-quote p-4 border-radius my-4 italic">
                            "{{ $quote }}"
                        </blockquote>
                    @endif
                </div>

                <hr class="my-5">

                <a href="{{ route('kegiatan.category', $currentCategory['slug']) }}" class="btn btn-outline-dkm">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke {{ $currentCategory['name'] }}
                </a>

            </div>
        </div>
    </div>
</div>

@endsection