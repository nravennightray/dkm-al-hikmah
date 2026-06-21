@extends('master.layout.app')

@section('title', 'Lokasi Musala - DKM Al Hikmah')

@section('css')
<style>
    .hover-card:hover {
        transform: scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    .transition {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Fasilitas Musala</h1>
        <p class="text-white-50">Temukan lokasi tempat ibadah terdekat di lingkungan Plant & Office.</p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach($locations as $loc)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm border-radius overflow-hidden h-100 hover-card transition">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <img src="{{ asset('assets/images/dkm/' . $loc->image) }}" class="img-full h-100" style="object-fit: cover; min-height: 250px;">
                        </div>
                        <div class="col-lg-7">
                            <div class="card-body p-4 d-flex flex-column h-100">
                                <h3 class="fw-normal text-dark">{{ $loc->name }}</h3>
                                <p class="text-muted small flex-grow-1">{{ $loc->short_desc }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('musala.show', $loc->slug) }}" class="btn btn-success border-radius">
                                        Lihat Detail Fasilitas <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Nice added touch: Adab Musala --}}
        <div class="mt-5 text-center p-5 bg-white border-radius shadow-sm">
            <h4 class="fw-normal mb-3">Menjaga Kebersihan Bersama</h4>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Mohon untuk selalu menjaga kebersihan area wudhu dan merapikan kembali sarung/mukena setelah digunakan demi kenyamanan jamaah berikutnya.
            </p>
        </div>
    </div>
</div>
@endsection