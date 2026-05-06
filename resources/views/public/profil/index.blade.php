@extends('master.layout.app')

@section('title', 'Profil - DKM Al Hikmah')

@section('css')
<style>
    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Profil DKM</h1>
        <p class="text-white-50">Mengenal lebih dekat pengelola dan visi Masjid Al Hikmah</p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">
        <div class="row g-4">
            <!-- Card 1: Sejarah -->
            <div class="col-md-6">
                <a href="{{ route('profil.sejarah') }}" class="text-decoration-none">
                    <div class="p-5 bg-white border-radius shadow-sm h-100 hover-card transition">
                        <div class="bg-light text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-history fa-2x"></i>
                        </div>
                        <h3 class="text-dark fw-normal">Sejarah</h3>
                        <p class="text-muted">Menelusuri jejak berdirinya Masjid Al Hikmah dari awal hingga saat ini.</p>
                        <span class="text-success fw-bold">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>

            <!-- Card 2: Visi Misi -->
            <div class="col-md-6">
                <a href="{{ route('profil.visi-misi') }}" class="text-decoration-none">
                    <div class="p-5 bg-white border-radius shadow-sm h-100 hover-card transition">
                        <div class="bg-light text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-bullseye fa-2x"></i>
                        </div>
                        <h3 class="text-dark fw-normal">Visi & Misi</h3>
                        <p class="text-muted">Arah dan tujuan kami dalam melayani jamaah dan memakmurkan masjid.</p>
                        <span class="text-success fw-bold">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>

            <!-- Card 3: Struktur -->
            <div class="col-md-6">
                <a href="{{ route('profil.struktur') }}" class="text-decoration-none">
                    <div class="p-5 bg-white border-radius shadow-sm h-100 hover-card transition">
                        <div class="bg-light text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-sitemap fa-2x"></i>
                        </div>
                        <h3 class="text-dark fw-normal">Struktur Organisasi</h3>
                        <p class="text-muted">Bagan tata kelola dan pembagian tugas dalam kepengurusan DKM.</p>
                        <span class="text-success fw-bold">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>

            <!-- Card 4: Kepengurusan -->
            <div class="col-md-6">
                <a href="{{ route('profil.kepengurusan') }}" class="text-decoration-none">
                    <div class="p-5 bg-white border-radius shadow-sm h-100 hover-card transition">
                        <div class="bg-light text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h3 class="text-dark fw-normal">Kepengurusan</h3>
                        <p class="text-muted">Daftar personil dan pengurus masa bakti aktif 2024 - 2027.</p>
                        <span class="text-success fw-bold">Selengkapnya <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection