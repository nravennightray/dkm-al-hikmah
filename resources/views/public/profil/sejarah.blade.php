@extends('master.layout.app')

@section('title', 'Sejarah - DKM Al Hikmah')

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

    .section-xl {
        padding-top: 140px !important;
        padding-bottom: 70px !important;
    }

    .history-image {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
    }

    .history-label {
        color: #2563eb;
    }

    .milestone-card {
        height: 100%;
        padding: 2rem;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        transition: all 0.3s ease;
    }

    .milestone-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
    }

    .milestone-year {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.45rem 1rem;
        margin-bottom: 1rem;
        border-radius: 999px;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    .quote-blue-section {
        background: linear-gradient(135deg, #0f172a 0%, #1e40af 55%, #0ea5e9 100%);
        position: relative;
        overflow: hidden;
    }

    .quote-blue-section::before {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        top: -120px;
        left: -120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        filter: blur(70px);
    }

    .quote-blue-section::after {
        content: "";
        position: absolute;
        width: 360px;
        height: 360px;
        right: -120px;
        bottom: -160px;
        border-radius: 50%;
        background: rgba(125, 211, 252, 0.22);
        filter: blur(80px);
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
            <i class="fas fa-history me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">Perjalanan DKM</span>
        </div>

        <h1 class="fw-bold text-white display-4">Sejarah Masjid</h1>

        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="/" class="text-white text-decoration-none opacity-75">Beranda</a>
                </li>
                <li class="breadcrumb-item text-white opacity-75">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Sejarah</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">
        <div class="row g-5 align-items-center">

            <!-- Image Side -->
            <div class="col-12 col-lg-6">
                <div class="history-image">
                    <img src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}"
                         alt="Sejarah DKM Al Hikmah"
                         class="img-full">
                </div>
            </div>

            <!-- Text Side -->
            <div class="col-12 col-lg-6">
                <h6 class="font-small uppercase history-label letter-spacing-1 fw-bold">
                    Asal-Usul
                </h6>

                <h2 class="fw-bold mb-3">
                    Titik Awal Perjalanan Dakwah
                </h2>

                <p class="mt-3">
                    DKM Al Hikmah berawal dari sebuah keinginan tulus para karyawan dan warga sekitar untuk memiliki tempat ibadah yang layak di area Plant. Dimulai dari sebuah bangunan kayu sederhana pada tahun 19xx, tempat ini menjadi saksi bisu perjuangan dakwah di lingkungan industri.
                </p>

                <p>
                    Seiring bertambahnya jumlah jamaah, renovasi demi renovasi dilakukan secara gotong royong. Semangat kebersamaan inilah yang menjadi pondasi utama berdirinya DKM Al Hikmah hingga menjadi pusat kegiatan umat seperti sekarang ini.
                </p>
            </div>
        </div>

        <hr class="my-5" style="border-color: rgba(37, 99, 235, 0.12);">

        <!-- Timeline / Milestones -->
        <div class="row g-4 mt-2">
            <div class="col-12 text-center mb-4">
                <h6 class="font-small uppercase letter-spacing-1 fw-bold" style="color: #2563eb;">
                    Jejak Perkembangan
                </h6>

                <h3 class="fw-bold">
                    Milestones Penting
                </h3>
            </div>

            <div class="col-12 col-md-4">
                <div class="milestone-card text-center">
                    <span class="milestone-year">1995</span>
                    <h5 class="fw-bold">Peletakan Batu Pertama</h5>
                    <p class="font-small text-muted mb-0">
                        Inisiasi awal pembangunan musala kecil oleh pengurus angkatan pertama.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="milestone-card text-center">
                    <span class="milestone-year">2010</span>
                    <h5 class="fw-bold">Renovasi Besar</h5>
                    <p class="font-small text-muted mb-0">
                        Peningkatan kapasitas bangunan menjadi masjid dua lantai untuk menampung lebih banyak jamaah.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="milestone-card text-center">
                    <span class="milestone-year">2024</span>
                    <h5 class="fw-bold">Digitalisasi DKM</h5>
                    <p class="font-small text-muted mb-0">
                        Peluncuran sistem informasi dan manajemen masjid secara digital untuk transparansi umat.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quote Section -->
<div class="section-sm quote-blue-section text-white">
    <div class="container position-relative text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <i class="fas fa-quote-left fa-2x mb-3 opacity-50"></i>

                <h4 class="fw-normal italic text-white">
                    "Masjid bukan sekadar bangunan fisik, melainkan ruh dari kebersamaan umat dalam ketaatan."
                </h4>

                <p class="mt-3 mb-0 text-white">
                    — Pendiri DKM Al Hikmah
                </p>
            </div>
        </div>
    </div>
</div>

@endsection