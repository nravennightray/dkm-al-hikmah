@extends('master.layout.app')

@section('title', 'DKM AL HIKMAH')

@section('css')
<style>
    /* =========================================================
       HERO
       ========================================================= */
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

    /* =========================================================
       FEATURE TOP CARDS
       ========================================================= */
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

    .home-feature-card p {
        line-height: 1.7;
    }

    /* =========================================================
       HOME INFO / BERITA
       ========================================================= */
    .home-info-section {
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
    }

    .home-info-heading {
        max-width: 720px;
        margin: 0 auto 46px;
        text-align: center;
    }

    .home-info-heading h2 {
        line-height: 1.25;
    }

    .home-info-heading p {
        line-height: 1.7;
    }

    .home-info-card {
        height: 100%;
        overflow: hidden;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        transition: all 0.3s ease;
        display: flex;
        align-items: stretch;
    }

    .home-info-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
    }

    .home-info-image-wrapper {
        position: relative;
        width: 34%;
        min-width: 280px;
        overflow: hidden;
        background: #f1f5f9;
    }

    .home-info-image-wrapper img {
        width: 100%;
        height: 100%;
        min-height: 240px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .home-info-card:hover .home-info-image-wrapper img {
        transform: scale(1.05);
    }

    .home-info-placeholder {
        width: 100%;
        height: 100%;
        min-height: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 42px;
        background: linear-gradient(180deg, #f8fafc 0%, #eff6ff 100%);
    }

    .home-info-type {
        position: absolute;
        top: 16px;
        left: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
    }

    .home-info-type-info {
        color: #1d4ed8;
    }

    .home-info-type-berita {
        color: #15803d;
    }

    .home-info-type-iklan {
        color: #b45309;
    }

    .home-info-body {
        flex: 1;
        padding: 32px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .home-info-date {
        display: block;
        margin-bottom: 10px;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .home-info-body h4 {
        margin-bottom: 8px;
        color: #0f172a;
        font-weight: 800;
        line-height: 1.35;
    }

    .home-info-subtitle {
        margin-bottom: 12px;
        color: #334155;
        font-weight: 700;
    }

    .home-info-description {
        margin-bottom: 0;
        color: #64748b;
        line-height: 1.7;
    }

    .home-info-empty {
        padding: 54px 24px;
        text-align: center;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
    }

    .home-info-empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        border-radius: 24px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    /* =========================================================
       LAYANAN & FASILITAS
       ========================================================= */
    .home-services-section {
        position: relative;
        overflow: hidden;
    }

    .home-services-section .section-title h2 {
        line-height: 1.25;
    }

    .home-service-card {
        height: 100%;
        padding: 34px 28px;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        transition: all 0.3s ease;

        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .home-service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
    }

    .home-service-icon {
        width: 68px;
        height: 68px;
        min-width: 68px;
        border-radius: 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 26px;
        line-height: 1;
        box-shadow: 0 14px 26px rgba(37, 99, 235, 0.22);
        flex-shrink: 0;
    }

    .home-service-icon i {
        line-height: 1;
    }

    .home-service-content h5 {
        margin-bottom: 10px;
        color: #0f172a;
        line-height: 1.35;
    }

    .home-service-content p {
        margin-bottom: 0;
        color: #64748b;
        line-height: 1.7;
    }

    /* =========================================================
       CTA
       ========================================================= */
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

    /* =========================================================
       RESPONSIVE TABLET
       ========================================================= */
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

        .home-info-heading {
            margin-bottom: 34px;
        }

        .home-info-image-wrapper {
            width: 38%;
            min-width: 240px;
        }

        .home-info-body {
            padding: 28px;
        }

        .home-services-section {
            padding-top: 82px;
            padding-bottom: 82px;
        }

        .home-service-card {
            padding: 30px 26px;
        }

        .home-cta-section {
            padding: 86px 0;
        }

        .home-cta-title {
            font-size: 40px;
        }
    }

    /* =========================================================
       RESPONSIVE MOBILE
       ========================================================= */
    @media (max-width: 767px) {
        .home-info-heading,
        .home-services-section .section-title {
            margin-bottom: 30px !important;
        }

        .home-info-heading {
            padding-left: 4px;
            padding-right: 4px;
        }

        .section-title h2,
        .home-info-heading h2 {
            font-size: 30px;
            line-height: 1.25;
        }

        .home-info-heading p {
            font-size: 14px;
        }

        .home-info-card {
            display: block;
            border-radius: 22px;
        }

        .home-info-image-wrapper {
            width: 100%;
            min-width: 100%;
        }

        .home-info-image-wrapper img,
        .home-info-placeholder {
            min-height: 210px;
        }

        .home-info-body {
            padding: 22px;
        }

        .home-info-body h4 {
            font-size: 20px;
        }

        .home-info-description {
            font-size: 14px;
        }

        .home-services-section {
            padding-top: 72px;
            padding-bottom: 72px;
        }

        .home-service-card {
            flex-direction: row;
            align-items: flex-start;
            text-align: left;
            gap: 18px;
            padding: 24px;
            border-radius: 24px;
        }

        .home-service-icon {
            width: 58px;
            height: 58px;
            min-width: 58px;
            border-radius: 18px;
            margin-bottom: 0;
            font-size: 22px;
        }

        .home-service-content {
            flex: 1;
            min-width: 0;
        }

        .home-service-content h5 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .home-service-content p {
            font-size: 14px;
            line-height: 1.65;
        }
    }

    /* =========================================================
       RESPONSIVE SMALL MOBILE
       ========================================================= */
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
            border-radius: 22px;
        }

        .home-feature-card i {
            font-size: 42px;
        }

        .home-feature-card h5 {
            font-size: 18px;
        }

        .home-feature-card p {
            font-size: 14px;
            line-height: 1.65;
        }

        .home-info-type {
            top: 14px;
            left: 14px;
            padding: 6px 10px;
            font-size: 10px;
        }

        .home-info-image-wrapper img,
        .home-info-placeholder {
            min-height: 190px;
        }

        .home-info-body {
            padding: 20px;
        }

        .home-services-section .container {
            padding-left: 18px;
            padding-right: 18px;
        }

        .home-service-card {
            gap: 14px;
            padding: 20px;
        }

        .home-service-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            border-radius: 17px;
            font-size: 20px;
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

    /* =========================================================
       RESPONSIVE EXTRA SMALL
       ========================================================= */
    @media (max-width: 380px) {
        .home-hero-title {
            font-size: 30px;
        }

        .home-hero-text {
            font-size: 14px;
        }

        .home-info-body h4 {
            font-size: 18px;
        }

        .home-service-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .home-service-icon {
            margin-bottom: 16px;
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

                    <h5 class="fw-medium">
                        Pusat Ibadah
                    </h5>

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

                    <h5 class="fw-medium">
                        Pendidikan & Dakwah
                    </h5>

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

                    <h5 class="fw-medium">
                        Pemberdayaan Sosial
                    </h5>

                    <p class="mb-0">
                        Menyalurkan Zakat, Infaq, dan Shadaqah secara amanah untuk kesejahteraan umat dan warga sekitar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="info-beranda" class="section home-info-section">
    <div class="container">

        <div class="home-info-heading">
            <h6 class="font-small uppercase text-dkm-blue letter-spacing-1 fw-bold">
                Info Beranda
            </h6>

            <h2 class="fw-normal mb-3">
                Informasi & Berita Terbaru
            </h2>

            <p class="text-muted mb-0">
                Update kegiatan, pengumuman, dan informasi penting dari DKM Al Hikmah.
            </p>
        </div>

        <div class="row g-4">
            @forelse(($homeInfos ?? collect()) as $info)
                @php
                    $type = strtolower($info['type'] ?? 'info');
                    $title = $info['title'] ?? '-';
                    $subtitle = $info['subtitle'] ?? '';
                    $description = $info['description'] ?? '';
                    $image = $info['image'] ?? '';
                    $publishedAt = $info['published_at'] ?? '';

                    $imageUrl = !empty($image)
                        ? asset('image/home-info/' . $image)
                        : null;

                    $typeClass = in_array($type, ['info', 'berita', 'iklan'])
                        ? 'home-info-type-' . $type
                        : 'home-info-type-info';

                    try {
                        $dateLabel = !empty($publishedAt)
                            ? \Carbon\Carbon::parse($publishedAt)->translatedFormat('d F Y')
                            : '';
                    } catch (\Throwable $e) {
                        $dateLabel = $publishedAt;
                    }
                @endphp

                <div class="col-12">
                    <div class="home-info-card">
                        <div class="home-info-image-wrapper">
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $title }}"
                                     onerror="this.closest('.home-info-image-wrapper').innerHTML='<div class=&quot;home-info-placeholder&quot;><i class=&quot;bi bi-image&quot;></i></div>';">
                            @else
                                <div class="home-info-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            <span class="home-info-type {{ $typeClass }}">
                                {{ $type }}
                            </span>
                        </div>

                        <div class="home-info-body">
                            @if(!empty($dateLabel))
                                <span class="home-info-date">
                                    {{ $dateLabel }}
                                </span>
                            @endif

                            <h4>
                                {{ $title }}
                            </h4>

                            @if(!empty($subtitle))
                                <div class="home-info-subtitle">
                                    {{ $subtitle }}
                                </div>
                            @endif

                            <p class="home-info-description">
                                {{ $description }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="home-info-empty">
                        <div class="home-info-empty-icon">
                            <i class="bi bi-megaphone"></i>
                        </div>

                        <h4 class="fw-bold mb-2">
                            Belum Ada Info Terbaru
                        </h4>

                        <p class="text-muted mb-0">
                            Informasi terbaru dari DKM Al Hikmah akan tampil di sini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>

<div class="section border-top bg-light-gray home-services-section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h6 class="font-small uppercase text-dkm-blue letter-spacing-1 fw-bold">
                Layanan DKM
            </h6>

            <h2 class="fw-normal">
                Layanan & Fasilitas
            </h2>
        </div>

        <div class="row g-4" data-cues="fadeIn">
            <div class="col-12 col-lg-4">
                <div class="home-service-card">
                    <div class="home-service-icon bg-dkm-blue text-white">
                        <i class="fas fa-mosque"></i>
                    </div>

                    <div class="home-service-content">
                        <h5 class="fw-medium">
                            Musala Kantor & Plant
                        </h5>

                        <p>
                            Penyediaan ruang ibadah yang bersih dan nyaman di lingkungan kerja untuk mendukung produktivitas jasmani dan rohani.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="home-service-card">
                    <div class="home-service-icon bg-dkm-blue text-white">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>

                    <div class="home-service-content">
                        <h5 class="fw-medium">
                            Transparansi Kas
                        </h5>

                        <p>
                            Laporan keuangan yang diperbarui secara rutin sebagai bentuk amanah kami dalam mengelola dana umat.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="home-service-card">
                    <div class="home-service-icon bg-dkm-blue text-white">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>

                    <div class="home-service-content">
                        <h5 class="fw-medium">
                            Tabungan Qurban/Umroh
                        </h5>

                        <p>
                            Program bimbingan dan pengelolaan dana untuk membantu jamaah mewujudkan niat ibadah mulia.
                        </p>
                    </div>
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