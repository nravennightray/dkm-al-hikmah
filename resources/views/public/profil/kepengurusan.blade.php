@extends('master.layout.app')

@section('title', 'Kepengurusan - DKM Al Hikmah')

@section('css')
<style>
    .team-card {
        transition: all 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-8px);
    }

    .team-img-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.10);
    }

    .team-img-wrapper img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .team-card:hover img {
        transform: scale(1.05);
    }

    .team-role {
        color: #2563eb;
        letter-spacing: 0.08em;
    }

    .team-role-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-top: 0.25rem;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .division-card {
        padding: 2rem;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        border-radius: 24px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        height: 100%;
    }

    .division-title {
        padding-bottom: 1rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid rgba(37, 99, 235, 0.12);
        font-weight: 700;
    }

    .division-title i {
        color: #2563eb;
    }

    .list-group-item {
        border-color: rgba(37, 99, 235, 0.08);
        font-size: 0.95rem;
        padding-top: 0.9rem;
        padding-bottom: 0.9rem;
    }

    .member-name {
        color: #0f172a;
        font-weight: 700;
    }
</style>
@endsection

@section('content')

<div class="section-xl position-relative overflow-hidden"
     style="background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);">

    <!-- Decorative Glow -->
    <div class="position-absolute top-0 start-0 translate-middle rounded-circle"
         style="width: 320px; height: 320px; background: rgba(255,255,255,0.14); filter: blur(70px);">
    </div>

    <div class="position-absolute bottom-0 end-0 translate-middle-y rounded-circle"
         style="width: 380px; height: 380px; background: rgba(125, 211, 252, 0.22); filter: blur(80px);">
    </div>

    <div class="container position-relative text-center pt-5">
        <div class="d-inline-flex align-items-center px-4 py-2 mb-4 rounded-pill"
             style="background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.25); backdrop-filter: blur(10px);">
            <i class="fas fa-users me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">Struktur Pengurus</span>
        </div>

        <h1 class="fw-bold text-white display-4">Kepengurusan</h1>

        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="/" class="text-white text-decoration-none opacity-75">Beranda</a>
                </li>
                <li class="breadcrumb-item text-white opacity-75">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Kepengurusan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">

        <div class="section-title text-center mb-5">
            <h6 class="font-small uppercase letter-spacing-1" style="color: #2563eb;">
                Tim Pengurus
            </h6>
            <h2 class="fw-bold">Dewan Pengurus Harian</h2>
            <p class="text-muted">Masa Bakti 2024 - 2027</p>
        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-6 col-lg-3">
                <div class="team-card text-center">
                    <div class="team-img-wrapper mb-4">
                        <img src="{{ asset('assets/images/dkm/user-placeholder.jpg') }}"
                             alt="Ketua DKM"
                             class="img-fluid">
                    </div>

                    <h5 class="mb-1 fw-bold">Nama Ketua DKM</h5>
                    <span class="team-role-badge">Ketua Umum</span>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="team-card text-center">
                    <div class="team-img-wrapper mb-4">
                        <img src="{{ asset('assets/images/dkm/user-placeholder.jpg') }}"
                             alt="Sekretaris"
                             class="img-fluid">
                    </div>

                    <h5 class="mb-1 fw-bold">Nama Sekretaris</h5>
                    <span class="team-role-badge">Sekretaris</span>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="team-card text-center">
                    <div class="team-img-wrapper mb-4">
                        <img src="{{ asset('assets/images/dkm/user-placeholder.jpg') }}"
                             alt="Bendahara"
                             class="img-fluid">
                    </div>

                    <h5 class="mb-1 fw-bold">Nama Bendahara</h5>
                    <span class="team-role-badge">Bendahara</span>
                </div>
            </div>

        </div>

        <hr class="my-5" style="border-color: rgba(37, 99, 235, 0.12);">

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="division-card">
                    <h4 class="division-title">
                        <i class="fas fa-pray me-2"></i>
                        Bidang Imarah
                    </h4>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span>Koordinator Kajian</span>
                            <span class="member-name">Nama Anggota</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span>Seksi Peribadahan</span>
                            <span class="member-name">Nama Anggota</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span>Seksi PHBI</span>
                            <span class="member-name">Nama Anggota</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="division-card">
                    <h4 class="division-title">
                        <i class="fas fa-tools me-2"></i>
                        Bidang Riayah
                    </h4>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span>Seksi Pemeliharaan Gedung</span>
                            <span class="member-name">Nama Anggota</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span>Seksi Perlengkapan</span>
                            <span class="member-name">Nama Anggota</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                            <span>Kebersihan & Taman</span>
                            <span class="member-name">Nama Anggota</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection