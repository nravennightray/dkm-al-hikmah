@extends('master.layout.app')

@section('title', ($musala['title'] ?? 'Musala') . ' - DKM Al Hikmah')

@section('css')
<style>
    .musala-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .musala-detail-image {
        width: 100%;
        max-height: 460px;
        object-fit: cover;
    }

    .info-card {
        background: #ffffff;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    }

    .info-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #198754;
        color: #ffffff;
        flex: 0 0 48px;
    }

    .facility-item {
        height: 100%;
        border: 1px solid #e9ecef;
        background: #f8fafc;
        border-radius: 14px;
        padding: 12px;
    }

    .facility-check {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #198754;
        color: #ffffff;
        flex: 0 0 34px;
    }
</style>
@endsection

@section('content')

@php
    $title = $musala['title'] ?? ($musala['name'] ?? 'Musala');
    $location = $musala['location'] ?? '-';
    $capacity = $musala['capacity'] ?? '-';
    $desc = $musala['desc'] ?? '';
    $image = $musala['image'] ?? '';
    $facilities = $musala['facilities'] ?? [];

    if (is_string($facilities)) {
        $facilities = array_filter(array_map('trim', explode(';', $facilities)));
    }
@endphp

<div class="section-xl musala-hero">
    <div class="container text-center pt-5 text-white">
        <h1 class="fw-normal display-4">
            {{ $title }}
        </h1>

        <p class="opacity-75 mb-0">
            <i class="fas fa-map-marker-alt me-2"></i>
            {{ $location }}
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <div class="row g-5 align-items-start">

            <div class="col-lg-6">
                @if(!empty($image))
                    <div class="border-radius overflow-hidden shadow-lg bg-white">
                        <img src="{{ asset('image/musala/' . $image) }}"
                             class="musala-detail-image"
                             alt="{{ $title }}">
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center bg-white border-radius shadow-sm"
                         style="height: 360px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-image fs-1"></i>
                            <div class="small mt-2">No image available</div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-6">

                <div class="info-card mb-4">
                    <h2 class="fw-normal mb-3">
                        Informasi Musala
                    </h2>

                    <p class="text-muted mb-0">
                        {{ $desc ?: $title . ' disediakan untuk mendukung aktivitas ibadah dengan nyaman dan bersih.' }}
                    </p>
                </div>

                <div class="info-card mb-4">
                    <div class="d-flex align-items-center">
                        <div class="info-icon me-3">
                            <i class="fas fa-users"></i>
                        </div>

                        <div>
                            <small class="text-muted d-block">Kapasitas</small>
                            <strong>{{ $capacity }}</strong>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <h4 class="fw-normal mb-3">
                        Fasilitas Tersedia
                    </h4>

                    <div class="row g-3">
                        @forelse($facilities as $facility)
                            <div class="col-12 col-md-6">
                                <div class="facility-item d-flex align-items-center">

                                    <div class="facility-check me-2">
                                        <i class="fas fa-check" style="font-size: 12px;"></i>
                                    </div>

                                    <div>
                                        <small class="text-muted d-block">Fasilitas</small>
                                        <strong class="small">{{ $facility }}</strong>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted mb-0">
                                    Tidak ada fasilitas tersedia.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('musala.index') }}" class="btn btn-outline-success border-radius">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke Daftar Musala
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection