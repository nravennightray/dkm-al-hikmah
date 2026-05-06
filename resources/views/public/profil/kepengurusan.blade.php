@extends('master.layout.app')

@section('title', 'Kepengurusan - DKM Al Hikmah')

@section('css')
<style>
    .team-img-wrapper img {
        width: 100%;
        aspect-ratio: 1 / 1; /* Makes it a perfect square */
        object-fit: cover; /* Ensures the headshot isn't stretched */
        transition: transform 0.3s ease;
    }

    .team-card:hover img {
        transform: scale(1.05);
    }

    .list-group-item {
        border-color: rgba(0,0,0,0.05);
        font-size: 0.95rem;
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Kepengurusan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75">Beranda</a></li>
                <li class="breadcrumb-item text-white-50">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Kepengurusan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-normal">Dewan Pengurus Harian</h2>
            <p class="text-muted">Masa Bakti 2024 - 2027</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="team-card text-center">
                    <div class="team-img-wrapper mb-3">
                        <img src="{{ asset('assets/images/dkm/user-placeholder.jpg') }}" alt="Ketua DKM" class="img-fluid border-radius shadow-sm">
                    </div>
                    <h5 class="mb-1 fw-medium">Nama Ketua DKM</h5>
                    <p class="text-success small uppercase fw-bold">Ketua Umum</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="team-card text-center">
                    <div class="team-img-wrapper mb-3">
                        <img src="{{ asset('assets/images/dkm/user-placeholder.jpg') }}" alt="Sekretaris" class="img-fluid border-radius shadow-sm">
                    </div>
                    <h5 class="mb-1 fw-medium">Nama Sekretaris</h5>
                    <p class="text-success small uppercase fw-bold">Sekretaris</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="team-card text-center">
                    <div class="team-img-wrapper mb-3">
                        <img src="{{ asset('assets/images/dkm/user-placeholder.jpg') }}" alt="Bendahara" class="img-fluid border-radius shadow-sm">
                    </div>
                    <h5 class="mb-1 fw-medium">Nama Bendahara</h5>
                    <p class="text-success small uppercase fw-bold">Bendahara</p>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <div class="row g-5">
            <div class="col-lg-6">
                <h4 class="fw-normal border-bottom pb-2 mb-4"><i class="fas fa-pray text-success me-2"></i>Bidang Imarah</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                        <span>Koordinator Kajian</span>
                        <span class="fw-medium text-dark">Nama Anggota</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                        <span>Seksi Peribadahan</span>
                        <span class="fw-medium text-dark">Nama Anggota</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                        <span>Seksi PHBI</span>
                        <span class="fw-medium text-dark">Nama Anggota</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-6">
                <h4 class="fw-normal border-bottom pb-2 mb-4"><i class="fas fa-tools text-success me-2"></i>Bidang Riayah</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                        <span>Seksi Pemeliharaan Gedung</span>
                        <span class="fw-medium text-dark">Nama Anggota</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                        <span>Seksi Perlengkapan</span>
                        <span class="fw-medium text-dark">Nama Anggota</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                        <span>Kebersihan & Taman</span>
                        <span class="fw-medium text-dark">Nama Anggota</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection