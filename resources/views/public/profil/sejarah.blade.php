@extends('master.layout.app')

@section('title', 'Sejarah - DKM Al Hikmah')

@section('css')
<style>
    /* Styling for the breadcrumbs on the green background */
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5) !important;
        content: "/" !important;
    }

    .breadcrumb-item a:hover {
        color: #fff !important;
        text-decoration: underline;
    }

    /* Ensure the header has enough space for the sticky navbar */
    .section-xl {
        padding-top: 140px !important;
        padding-bottom: 70px !important;
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Sejarah Masjid</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="/" class="text-white opacity-75">Beranda</a></li>
                <li class="breadcrumb-item text-white-50">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Sejarah</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- Image Side -->
            <div class="col-12 col-lg-6">
                <div class="box-shadow border-radius overflow-hidden">
                    <!-- Placeholder for an old photo of the mosque or the founding team -->
                    <img src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}" alt="Sejarah DKM Al Hikmah" class="img-full">
                </div>
            </div>
            
            <!-- Text Side -->
            <div class="col-12 col-lg-6">
                <h6 class="font-small uppercase text-success letter-spacing-1">Asal-Usul</h6>
                <h2 class="fw-normal">Titik Awal Perjalanan Dakwah</h2>
                <p class="mt-3">
                    DKM Al Hikmah berawal dari sebuah keinginan tulus para karyawan dan warga sekitar untuk memiliki tempat ibadah yang layak di area Plant. Dimulai dari sebuah bangunan kayu sederhana pada tahun 19xx, tempat ini menjadi saksi bisu perjuangan dakwah di lingkungan industri.
                </p>
                <p>
                    Seiring bertambahnya jumlah jamaah, renovasi demi renovasi dilakukan secara gotong royong. Semangat kebersamaan inilah yang menjadi pondasi utama berdirinya DKM Al Hikmah hingga menjadi pusat kegiatan umat seperti sekarang ini.
                </p>
            </div>
        </div>

        <hr class="my-5">

        <!-- Timeline / Milestones -->
        <div class="row g-4 mt-2">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-normal">Milestones Penting</h3>
            </div>
            
            <div class="col-12 col-md-4">
                <div class="feature-box p-4 border rounded shadow-sm text-center">
                    <h4 class="text-success fw-bold">1995</h4>
                    <h5 class="fw-medium">Peletakan Batu Pertama</h5>
                    <p class="font-small">Inisiasi awal pembangunan musala kecil oleh pengurus angkatan pertama.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="feature-box p-4 border rounded shadow-sm text-center">
                    <h4 class="text-success fw-bold">2010</h4>
                    <h5 class="fw-medium">Renovasi Besar</h5>
                    <p class="font-small">Peningkatan kapasitas bangunan menjadi masjid dua lantai untuk menampung lebih banyak jamaah.</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="feature-box p-4 border rounded shadow-sm text-center">
                    <h4 class="text-success fw-bold">2024</h4>
                    <h5 class="fw-medium">Digitalisasi DKM</h5>
                    <p class="font-small">Peluncuran sistem informasi dan manajemen masjid secara digital untuk transparansi umat.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quote Section -->
<div class="section-sm bg-color-very-peri text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <i class="fas fa-quote-left fa-2x mb-3 opacity-50"></i>
                <h4 class="fw-normal italic">"Masjid bukan sekadar bangunan fisik, melainkan ruh dari kebersamaan umat dalam ketaatan."</h4>
                <p class="mt-3">— Pendiri DKM Al Hikmah</p>
            </div>
        </div>
    </div>
</div>

@endsection