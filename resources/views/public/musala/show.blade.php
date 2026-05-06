@extends('master.layout.app')

@section('title', $musala->title . ' - DKM Al Hikmah')

@section('content')

<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5 text-white">
        <h1 class="fw-normal display-4">{{ $musala->title }}</h1>
        <p class="opacity-75"><i class="fas fa-map-marker-alt me-2"></i> {{ $musala->location }}</p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- Left: Image Gallery -->
            <div class="col-lg-6">
                <div class="border-radius overflow-hidden shadow-lg">
                    {{-- Placeholder image --}}
                    <img src="{{ asset('assets/images/dkm/' . $musala->image) }}" class="img-fluid" alt="{{ $musala->title }}">
                </div>
            </div>

            <!-- Right: Details -->
            <div class="col-lg-6">
                <h2 class="fw-normal mb-4">Fasilitas & Kapasitas</h2>
                <p class="text-muted mb-5">
                    {{ $musala->title }} disediakan untuk memudahkan karyawan melaksanakan ibadah shalat tepat waktu di tengah aktivitas kerja. Kami selalu berusaha menjaga kebersihan dan kenyamanan area ini.
                </p>

                <div class="row g-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white p-3 rounded-circle me-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Kapasitas</small>
                                <strong>{{ $musala->capacity }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    @foreach($musala->facilities as $facility)
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-light text-success p-3 rounded-circle me-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Fasilitas</small>
                                <strong>{{ $facility }}</strong>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection