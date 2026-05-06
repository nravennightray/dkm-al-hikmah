@extends('master.layout.app')

@section('title', 'Struktur Organisasi - DKM Al Hikmah')

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Struktur Organisasi</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75">Beranda</a></li>
                <li class="breadcrumb-item text-white-50">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Struktur</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-normal">Bagan Organisasi DKM Al Hikmah</h2>
            <p class="text-muted">Sinergi dalam melayani umat dan memakmurkan masjid.</p>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-4 text-center">
                <div class="p-4 bg-white border-top border-success border-4 shadow-sm border-radius">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-user-tie fa-lg"></i>
                    </div>
                    <h5 class="mb-1">Ketua Umum</h5>
                    <p class="text-success small fw-bold mb-0">PENANGGUNG JAWAB UTAMA</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-4 mb-5">
            <div class="col-md-4 col-lg-3 text-center">
                <div class="p-3 bg-white shadow-sm border-radius">
                    <h6 class="mb-1">Sekretaris</h6>
                    <p class="text-muted small mb-0">Administrasi & Surat</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3 text-center">
                <div class="p-3 bg-white shadow-sm border-radius">
                    <h6 class="mb-1">Bendahara</h6>
                    <p class="text-muted small mb-0">Keuangan & Infaq</p>
                </div>
            </div>
        </div>

        <div class="row g-4 text-center">
            <div class="col-6 col-lg-3">
                <div class="p-3 border rounded bg-white h-100">
                    <i class="fas fa-mosque text-success mb-2"></i>
                    <h6 class="mb-0">Bidang Idarah</h6>
                    <p class="font-small text-muted mb-0">Manajemen & Organisasi</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 border rounded bg-white h-100">
                    <i class="fas fa-pray text-success mb-2"></i>
                    <h6 class="mb-0">Bidang Imarah</h6>
                    <p class="font-small text-muted mb-0">Peribadahan & Dakwah</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 border rounded bg-white h-100">
                    <i class="fas fa-tools text-success mb-2"></i>
                    <h6 class="mb-0">Bidang Riayah</h6>
                    <p class="font-small text-muted mb-0">Pemeliharaan & Bangunan</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="p-3 border rounded bg-white h-100">
                    <i class="fas fa-users text-success mb-2"></i>
                    <h6 class="mb-0">Bidang Sosial</h6>
                    <p class="font-small text-muted mb-0">Zakat & Pemberdayaan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section pt-0 bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="p-2 bg-white shadow border-radius">
                    <div class="p-5 border border-dashed border-radius">
                        <i class="fas fa-sitemap fa-3x text-light mb-3"></i>
                        <p class="text-muted italic">"Bagan Visual dalam proses finalisasi oleh pengurus."</p>
                    </div>
                </div>
                {{-- <div class="p-2 bg-white shadow border-radius">
                    <img src="{{ asset('assets/images/dkm/full-structure-chart.jpg') }}" 
                        alt="Bagan Struktur Organisasi" 
                        class="img-fluid border-radius">
                </div> --}}
            </div>
        </div>
    </div>
</div>

@endsection