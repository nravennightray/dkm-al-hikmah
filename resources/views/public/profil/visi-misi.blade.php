@extends('master.layout.app')

@section('title', 'Visi & Misi - DKM Al Hikmah')

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

    .vision-section {
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
    }

    .vision-label {
        color: #2563eb;
        font-weight: 800;
    }

    .mission-icon {
        width: 54px;
        height: 54px;
        flex-shrink: 0;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        box-shadow: 0 12px 26px rgba(37, 99, 235, 0.22);
    }

    .mission-item {
        padding: 1rem;
        border-radius: 22px;
        transition: all 0.3s ease;
    }

    .mission-item:hover {
        background: #eff6ff;
        transform: translateX(6px);
    }

    .vision-image {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
    }

    .core-value-card {
        height: 100%;
        padding: 2rem;
        border-radius: 24px;
        text-align: center;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        transition: all 0.3s ease;
    }

    .core-value-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
        border-color: rgba(37, 99, 235, 0.22);
    }

    .core-value-card h5 {
        color: #2563eb;
        font-weight: 800;
    }

    .core-value-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 1rem;
        border-radius: 18px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .core-value-card:hover .core-value-icon {
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
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
            <i class="fas fa-bullseye me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">Arah Perjuangan DKM</span>
        </div>

        <h1 class="fw-bold text-white display-4">Visi & Misi</h1>

        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="/" class="text-white text-decoration-none opacity-75">Beranda</a>
                </li>
                <li class="breadcrumb-item text-white opacity-75">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Visi & Misi</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section vision-section">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h6 class="font-small uppercase vision-label letter-spacing-1">
                    Visi Kami
                </h6>

                <h2 class="fw-bold mb-4">
                    Terwujudnya Masjid sebagai Pusat Ibadah dan Pemberdayaan Umat yang Mandiri dan Unggul
                </h2>

                <p class="lead text-muted mb-0">
                    Menjadikan DKM Al Hikmah bukan hanya tempat sujud, namun juga sumber ilmu, solusi sosial, dan pusat ukhuwah bagi seluruh jamaah di lingkungan Plant dan sekitarnya.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-12 col-lg-6">
                <h6 class="font-small uppercase vision-label letter-spacing-1">
                    Misi Kami
                </h6>

                <h2 class="fw-bold mb-4">
                    Langkah Nyata Mencapai Visi
                </h2>

                <div class="mission-item d-flex mb-3">
                    <div class="me-3">
                        <div class="mission-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-pray"></i>
                        </div>
                    </div>

                    <div>
                        <h5 class="fw-bold">Peningkatan Kualitas Ibadah</h5>
                        <p class="text-muted mb-0">
                            Menyelenggarakan kegiatan peribadahan yang sesuai dengan Al-Qur'an dan Sunnah demi kenyamanan jamaah.
                        </p>
                    </div>
                </div>

                <div class="mission-item d-flex mb-3">
                    <div class="me-3">
                        <div class="mission-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>

                    <div>
                        <h5 class="fw-bold">Dakwah & Pendidikan</h5>
                        <p class="text-muted mb-0">
                            Mengembangkan program kajian rutin dan pendidikan Islam bagi anak-anak serta dewasa.
                        </p>
                    </div>
                </div>

                <div class="mission-item d-flex">
                    <div class="me-3">
                        <div class="mission-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>

                    <div>
                        <h5 class="fw-bold">Pemberdayaan Sosial</h5>
                        <p class="text-muted mb-0">
                            Mengelola dana umat secara transparan untuk membantu fakir miskin dan program santunan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="vision-image">
                    <img src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}"
                         alt="Visi Misi DKM"
                         class="img-full">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section pt-0">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 text-center mb-2">
                <h6 class="font-small uppercase letter-spacing-1 fw-bold" style="color: #2563eb;">
                    Prinsip Utama
                </h6>

                <h3 class="fw-bold">Nilai-Nilai Kami</h3>
            </div>

            <div class="col-md-4">
                <div class="core-value-card">
                    <div class="core-value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <h5>Amanah</h5>

                    <p class="font-small mb-0 text-muted">
                        Menjaga kepercayaan umat dalam pengelolaan dana dan kegiatan masjid.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="core-value-card">
                    <div class="core-value-icon">
                        <i class="fas fa-people-arrows"></i>
                    </div>

                    <h5>Inklusif</h5>

                    <p class="font-small mb-0 text-muted">
                        Terbuka bagi seluruh lapisan masyarakat tanpa memandang latar belakang.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="core-value-card">
                    <div class="core-value-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <h5>Transparan</h5>

                    <p class="font-small mb-0 text-muted">
                        Setiap kegiatan dan aliran dana dapat dipertanggungjawabkan secara jelas.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection