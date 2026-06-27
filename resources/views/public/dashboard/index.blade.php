@extends('master.layout.app')

@section('title', 'DKM AL HIKMAH')

@section('css')
<style>
    .home-hero {
        position: relative;
        min-height: 720px;
        display: flex;
        align-items: stretch;
    }

    .home-hero-overlay {
        width: 100%;
        min-height: 720px;
        display: flex;
        align-items: center;
        padding: 150px 0 170px;
        background: linear-gradient(
            180deg,
            rgba(15, 23, 42, 0.70) 0%,
            rgba(15, 23, 42, 0.56) 50%,
            rgba(30, 64, 175, 0.42) 100%
        );
    }

    .home-hero-title {
        max-width: 920px;
        line-height: 1.05;
        text-wrap: balance;
    }

    .home-hero-text {
        max-width: 760px;
        font-size: 1.15rem;
        line-height: 1.8;
    }

    .home-hero-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .home-feature-wrapper {
        position: relative;
        z-index: 3;
    }

    .home-feature-card {
        height: 100%;
        transition: all 0.25s ease;
    }

    .home-feature-card:hover {
        transform: translateY(-6px);
    }

    .home-feature-card i {
        line-height: 1;
    }

    .home-profile-image {
        width: 100%;
        height: auto;
        display: block;
    }

    .home-profile-content p {
        line-height: 1.8;
    }

    .home-check-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: #475569;
        font-size: 15px;
        line-height: 1.5;
    }

    .home-check-item i {
        margin-top: 3px;
        flex-shrink: 0;
    }

    .home-service-card {
        height: 100%;
    }

    .home-cta-bg {
        background-position: center;
        background-size: cover;
    }

    .home-cta-section {
        padding: 110px 0;
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.92) 0%,
            rgba(37, 99, 235, 0.86) 55%,
            rgba(14, 165, 233, 0.78) 100%
        );
    }

    .home-cta-title {
        line-height: 1.12;
        text-wrap: balance;
    }

    @media (max-width: 991px) {
        .home-hero,
        .home-hero-overlay {
            min-height: auto;
        }

        .home-hero-overlay {
            padding: 135px 0 120px;
        }

        .home-hero-title {
            max-width: 680px;
            font-size: 46px;
        }

        .home-hero-text {
            max-width: 640px;
            font-size: 1rem;
        }

        .home-feature-wrapper {
            margin-top: -56px;
        }

        .home-feature-card {
            text-align: center;
        }

        .home-profile-content {
            text-align: center;
        }

        .home-profile-content .button-text-2 {
            justify-content: center;
        }

        .home-check-item {
            justify-content: center;
            text-align: left;
        }

        .home-cta-section {
            padding: 86px 0;
        }

        .home-cta-title {
            font-size: 40px;
        }
    }

    @media (max-width: 575px) {
        .home-hero-overlay {
            padding: 118px 0 95px;
            text-align: center;
        }

        .home-hero-title {
            font-size: 34px;
            line-height: 1.12;
        }

        .home-hero-text {
            font-size: 15px;
            line-height: 1.7;
        }

        .home-hero-actions {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
        }

        .home-hero-actions .button {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .home-feature-wrapper {
            margin-top: -42px;
        }

        .home-feature-card {
            padding: 28px !important;
        }

        .home-feature-card i {
            font-size: 42px;
        }

        #profil {
            padding-top: 70px;
        }

        .home-profile-content h2 {
            font-size: 30px;
            line-height: 1.25;
        }

        .home-check-item {
            justify-content: flex-start;
            font-size: 14px;
        }

        .feature-box {
            padding-left: 18px;
            padding-right: 18px;
        }

        .home-cta-section {
            padding: 72px 0;
        }

        .home-cta-pill {
            padding-left: 18px !important;
            padding-right: 18px !important;
            max-width: 100%;
        }

        .home-cta-pill span {
            font-size: 11px;
        }

        .home-cta-title {
            font-size: 32px;
        }

        .home-cta-section .lead {
            font-size: 15px;
            line-height: 1.7;
        }

        .home-cta-section .button {
            width: 100%;
            display: inline-flex;
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 380px) {
        .home-hero-title {
            font-size: 30px;
        }

        .home-hero-text {
            font-size: 14px;
        }

        .home-cta-title {
            font-size: 28px;
        }
    }
</style>
@endsection

@section('content')

<div class="section-2xl bg-image parallax home-hero"
     data-bg-src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}">
    <div class="section-divider-curve-bottom home-hero-overlay">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-10">
                    <h1 class="display-3 font-family-outfit fw-bold text-white home-hero-title">
                        DKM AL-HIKMAH PT SRI
                    </h1>

                    <p class="lead text-white-50 mt-3 home-hero-text">
                        Menjadi pusat syiar Islam yang inklusif, modern, dan menebar manfaat bagi seluruh jamaah.
                        Mari bergabung bersama kami dalam memakmurkan masjid dan membangun ukhuwah.
                    </p>

                    <div class="home-hero-actions mt-4">
                        <a href="{{ route('profil.index') }}"
                           class="button button-lg button-radius button-white shadow">
                            Tentang Kami
                        </a>

                        <a href="{{ route('kegiatan.index') }}"
                           class="button button-lg button-radius button-outline-white">
                            Kegiatan Rutin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="n-margin-6 home-feature-wrapper">
    <div class="container icon-5xl">
        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="bg-white border-radius-1 box-shadow hover-float p-4 p-xl-5 h-100 home-feature-card">
                    <div class="text-dkm-blue mb-2 mb-lg-3">
                        <i class="bi bi-moon-stars"></i>
                    </div>

                    <h5 class="fw-medium">Pusat Ibadah</h5>

                    <p class="mb-0">
                        Menyelenggarakan shalat berjamaah, kajian rutin, dan peringatan hari besar Islam dengan nyaman dan khidmat.
                    </p>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="bg-white border-radius-1 box-shadow hover-float p-4 p-xl-5 h-100 home-feature-card">
                    <div class="text-dkm-blue mb-2 mb-lg-3">
                        <i class="bi bi-book"></i>
                    </div>

                    <h5 class="fw-medium">Pendidikan & Dakwah</h5>

                    <p class="mb-0">
                        Membina generasi qur'ani melalui TPA, remaja masjid, serta literasi keislaman bagi seluruh lapisan masyarakat.
                    </p>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="bg-white border-radius-1 box-shadow hover-float p-4 p-xl-5 h-100 home-feature-card">
                    <div class="text-dkm-blue mb-2 mb-lg-3">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                    <h5 class="fw-medium">Pemberdayaan Sosial</h5>

                    <p class="mb-0">
                        Menyalurkan Zakat, Infaq, dan Shadaqah secara amanah untuk kesejahteraan umat dan warga sekitar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="profil" class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-6">
                <div class="box-shadow border-radius overflow-hidden">
                    <img class="home-profile-image"
                         src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}"
                         alt="DKM Al Hikmah">
                </div>
            </div>

            <div class="col-12 col-lg-6 home-profile-content">
                <h6 class="font-small uppercase text-dkm-blue letter-spacing-1">
                    Profil Masjid
                </h6>

                <h2 class="fw-normal mb-lg-3">
                    Membangun Umat, Menebar Manfaat di DKM Al Hikmah
                </h2>

                <p>
                    DKM Al Hikmah hadir sebagai pusat peribadahan dan pembinaan umat yang inklusif.
                    Kami berkomitmen untuk menyediakan lingkungan yang nyaman bagi jamaah untuk beribadah,
                    belajar, dan bersosialisasi berdasarkan nilai-nilai Al-Qur'an dan Sunnah.
                </p>

                <div class="row g-3 mt-3">
                    <div class="col-12 col-sm-6">
                        <div class="home-check-item">
                            <i class="bi bi-check-circle text-dkm-blue"></i>
                            <span>Berdiri Sejak 19xx</span>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="home-check-item">
                            <i class="bi bi-check-circle text-dkm-blue"></i>
                            <span>Kapasitas 1000+ Jamaah</span>
                        </div>
                    </div>
                </div>

                <a class="button-text-2 mt-4" href="{{ route('profil.sejarah') }}">
                    Selengkapnya tentang Sejarah Kami
                </a>
            </div>
        </div>
    </div>
</div>

<div class="section border-top bg-light-gray">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-normal">Layanan & Fasilitas</h2>
        </div>

        <div class="row g-4" data-cues="fadeIn">
            <div class="col-12 col-md-4">
                <div class="feature-box text-center home-service-card">
                    <div class="feature-box-icon bg-dkm-blue text-white">
                        <i class="fas fa-mosque"></i>
                    </div>

                    <h5 class="fw-medium">Musala Kantor & Plant</h5>

                    <p>
                        Penyediaan ruang ibadah yang bersih dan nyaman di lingkungan kerja untuk mendukung produktivitas jasmani dan rohani.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="feature-box text-center home-service-card">
                    <div class="feature-box-icon bg-dkm-blue text-white">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>

                    <h5 class="fw-medium">Transparansi Kas</h5>

                    <p>
                        Laporan keuangan yang diperbarui secara rutin sebagai bentuk amanah kami dalam mengelola dana umat.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="feature-box text-center home-service-card">
                    <div class="feature-box-icon bg-dkm-blue text-white">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>

                    <h5 class="fw-medium">Tabungan Qurban/Umroh</h5>

                    <p>
                        Program bimbingan dan pengelolaan dana untuk membantu jamaah mewujudkan niat ibadah mulia.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-xl bg-image parallax home-cta-bg"
     data-bg-src="{{ asset('assets/images/dkm/parallax-bg.jpg') }}">
    <div class="position-relative overflow-hidden home-cta-section">
        <div class="container position-relative text-center text-white">
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                    <div class="d-inline-flex align-items-center px-4 py-2 mb-4 rounded-pill home-cta-pill"
                         style="background: rgba(30, 64, 175, 0.35); border: 1px solid rgba(255,255,255,0.28); backdrop-filter: blur(10px);">
                        <i class="bi bi-heart-fill me-2 text-white"></i>

                        <span class="font-small uppercase letter-spacing-1 text-white">
                            Dukung Program Kebaikan
                        </span>
                    </div>

                    <h1 class="display-4 font-family-outfit fw-bold mb-3 text-white home-cta-title">
                        Mari Berkontribusi dalam Dakwah
                    </h1>

                    <p class="lead mb-0 text-white">
                        Setiap rupiah yang Anda infaq-kan menjadi investasi akhirat dan membantu memakmurkan masjid kita tercinta.
                    </p>

                    <div class="mt-5">
                        <a class="button button-lg button-radius button-white shadow"
                           href="{{ route('infaq.index') }}">
                            Salurkan Infaq Sekarang
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection