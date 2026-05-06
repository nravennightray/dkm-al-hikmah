@extends('master.layout.app')

@section('title', 'Visi & Misi - DKM Al Hikmah')

@section('css')
<style>
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5) !important;
        content: "/" !important;
    }

    .section-xl {
        padding-top: 140px !important;
        padding-bottom: 70px !important;
    }
    
    .bg-light-gray {
        background-color: #f8f9fa;
    }
    
    /* Hover effect for the core values */
    .bg-light:hover {
        background-color: #e9ecef !important;
        transition: 0.3s ease;
        transform: translateY(-5px);
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Visi & Misi</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75">Beranda</a></li>
                <li class="breadcrumb-item text-white-50">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Visi & Misi</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h6 class="font-small uppercase text-success letter-spacing-1">Visi Kami</h6>
                <h2 class="fw-normal mb-4">Terwujudnya Masjid sebagai Pusat Ibadah dan Pemberdayaan Umat yang Mandiri dan Unggul</h2>
                <p class="lead text-muted">
                    Menjadikan DKM Al Hikmah bukan hanya tempat sujud, namun juga sumber ilmu, solusi sosial, dan pusat ukhuwah bagi seluruh jamaah di lingkungan Plant dan sekitarnya.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-6">
                <h6 class="font-small uppercase text-success letter-spacing-1">Misi Kami</h6>
                <h2 class="fw-normal mb-4">Langkah Nyata Mencapai Visi</h2>
                
                <div class="d-flex mb-4">
                    <div class="me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                            <i class="fas fa-pray"></i>
                        </div>
                    </div>
                    <div>
                        <h5>Peningkatan Kualitas Ibadah</h5>
                        <p class="text-muted">Menyelenggarakan kegiatan peribadahan yang sesuai dengan Al-Qur'an dan Sunnah demi kenyamanan jamaah.</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                    <div>
                        <h5>Dakwah & Pendidikan</h5>
                        <p class="text-muted">Mengembangkan program kajian rutin dan pendidikan Islam bagi anak-anak serta dewasa.</p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                    <div>
                        <h5>Pemberdayaan Sosial</h5>
                        <p class="text-muted">Mengelola dana umat secara transparan untuk membantu fakir miskin dan program santunan.</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="box-shadow border-radius overflow-hidden">
                    <img src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}" alt="Visi Misi DKM" class="img-full">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section pt-0">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 text-center mb-2">
                <h3 class="fw-normal">Nilai-Nilai Kami (Core Values)</h3>
            </div>
            <div class="col-md-4">
                <div class="p-4 border-radius text-center bg-light">
                    <h5 class="text-success">Amanah</h5>
                    <p class="font-small mb-0">Menjaga kepercayaan umat dalam pengelolaan dana dan kegiatan masjid.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border-radius text-center bg-light">
                    <h5 class="text-success">Inklusif</h5>
                    <p class="font-small mb-0">Terbuka bagi seluruh lapisan masyarakat tanpa memandang latar belakang.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border-radius text-center bg-light">
                    <h5 class="text-success">Transparan</h5>
                    <p class="font-small mb-0">Setiap kegiatan dan aliran dana dapat dipertanggungjawabkan secara jelas.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection