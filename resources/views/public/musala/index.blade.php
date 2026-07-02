@extends('master.layout.app')

@section('title', 'Lokasi Musala - DKM Al Hikmah')

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

    .musala-card {
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .musala-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.10) !important;
    }

    .musala-image {
        width: 100%;
        height: 100%;
        min-height: 260px;
        object-fit: cover;
    }

    .musala-placeholder {
        min-height: 260px;
    }

    .facility-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(25, 135, 84, 0.10);
        color: #198754;
        font-size: 12px;
        font-weight: 600;
        margin-right: 6px;
        margin-bottom: 6px;
    }
</style>
@endsection

@section('content')

<div class="section-xl musala-hero">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Fasilitas Musala</h1>
        <p class="text-white-50">
            Temukan lokasi tempat ibadah terdekat di lingkungan Plant & Office.
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <div class="row g-4 justify-content-center">

            @forelse($locations as $loc)
                @php
                    $title = $loc['title'] ?? '-';
                    $slug = $loc['slug'] ?? '';
                    $location = $loc['location'] ?? '-';
                    $capacity = $loc['capacity'] ?? '-';
                    $desc = $loc['desc'] ?? '';
                    $image = $loc['image'] ?? '';
                    $facilities = $loc['facilities'] ?? [];
                @endphp

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm border-radius overflow-hidden h-100 musala-card">
                        <div class="row g-0 h-100">

                            <div class="col-lg-5">
                                @if(!empty($image))
                                    <img src="{{ asset('image/musala/' . $image) }}"
                                         class="musala-image"
                                         alt="{{ $title }}">
                                @else
                                    <div class="musala-placeholder d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                        <div class="text-center">
                                            <i class="bi bi-image fs-1"></i>
                                            <div class="small mt-2">No Image</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-7">
                                <div class="card-body p-4 d-flex flex-column h-100">

                                    <h3 class="fw-normal text-dark mb-2">
                                        {{ $title }}
                                    </h3>

                                    <div class="text-muted small mb-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $location }}
                                    </div>

                                    <p class="text-muted small flex-grow-1">
                                        {{ $desc ?: 'Fasilitas musala tersedia untuk menunjang kenyamanan jamaah dalam beribadah.' }}
                                    </p>

                                    <div class="mb-3">
                                        <div class="facility-badge">
                                            <i class="fas fa-users"></i>
                                            {{ $capacity }}
                                        </div>

                                        @foreach(array_slice($facilities, 0, 3) as $facility)
                                            <div class="facility-badge">
                                                <i class="fas fa-check"></i>
                                                {{ $facility }}
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-auto">
                                        <a href="{{ route('musala.show', $slug) }}"
                                           class="btn btn-success border-radius">
                                            Lihat Detail Fasilitas
                                            <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center p-5 bg-white border-radius shadow-sm">
                        <i class="bi bi-building fs-1 text-muted"></i>
                        <h4 class="fw-normal mt-3 mb-2">Data Musala Belum Tersedia</h4>
                        <p class="text-muted mb-0">
                            Data lokasi musala belum tersedia saat ini.
                        </p>
                    </div>
                </div>
            @endforelse

        </div>

        <div class="mt-5 text-center p-5 bg-white border-radius shadow-sm">
            <h4 class="fw-normal mb-3">Menjaga Kebersihan Bersama</h4>
            <p class="text-muted mx-auto mb-0" style="max-width: 600px;">
                Mohon untuk selalu menjaga kebersihan area wudhu dan merapikan kembali sarung/mukena setelah digunakan demi kenyamanan jamaah berikutnya.
            </p>
        </div>

    </div>
</div>

@endsection