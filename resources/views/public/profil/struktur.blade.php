@extends('master.layout.app')

@section('title', 'Struktur Organisasi - DKM Al Hikmah')

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

    .org-main-card {
        border-top: 4px solid #2563eb;
        border-radius: 24px;
        box-shadow: 0 18px 42px rgba(37, 99, 235, 0.14);
        transition: all 0.3s ease;
    }

    .org-main-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 50px rgba(37, 99, 235, 0.20);
    }

    .org-icon-main {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.26);
    }

    .org-small-card,
    .org-field-card {
        border: 1px solid rgba(37, 99, 235, 0.10);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .org-small-card:hover,
    .org-field-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(37, 99, 235, 0.12);
        border-color: rgba(37, 99, 235, 0.25);
    }

    .org-field-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 0.8rem;
        border-radius: 16px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .org-field-card:hover .org-field-icon {
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
    }

    .org-label {
        color: #2563eb;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .structure-placeholder {
        border: 1px dashed rgba(37, 99, 235, 0.35);
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
    }

    .structure-placeholder i {
        color: rgba(37, 99, 235, 0.35);
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
            <i class="fas fa-sitemap me-2 text-white"></i>
            <span class="font-small uppercase letter-spacing-1 text-white">Tata Kelola DKM</span>
        </div>

        <h1 class="fw-bold text-white display-4">Struktur Organisasi</h1>

        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="/" class="text-white text-decoration-none opacity-75">Beranda</a>
                </li>
                <li class="breadcrumb-item text-white opacity-75">Profil</li>
                <li class="breadcrumb-item active text-white" aria-current="page">Struktur</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section" style="background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h6 class="font-small uppercase letter-spacing-1 fw-bold" style="color: #2563eb;">
                Bagan Organisasi
            </h6>
            <h2 class="fw-bold">Bagan Organisasi DKM Al Hikmah</h2>
            <p class="text-muted">Sinergi dalam melayani umat dan memakmurkan masjid.</p>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-5 col-lg-4 text-center">
                <div class="org-main-card p-4 bg-white">
                    <div class="org-icon-main rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="fas fa-user-tie fa-lg"></i>
                    </div>

                    <h5 class="mb-1 fw-bold">Ketua Umum</h5>
                    <p class="org-label mb-0">Penanggung Jawab Utama</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-4 mb-5">
            <div class="col-md-4 col-lg-3 text-center">
                <div class="org-small-card p-4 bg-white shadow-sm h-100">
                    <h6 class="mb-1 fw-bold">Sekretaris</h6>
                    <p class="text-muted small mb-0">Administrasi & Surat</p>
                </div>
            </div>

            <div class="col-md-4 col-lg-3 text-center">
                <div class="org-small-card p-4 bg-white shadow-sm h-100">
                    <h6 class="mb-1 fw-bold">Bendahara</h6>
                    <p class="text-muted small mb-0">Keuangan & Infaq</p>
                </div>
            </div>
        </div>

        <div class="row g-4 text-center">
            <div class="col-6 col-lg-3">
                <div class="org-field-card p-4 bg-white h-100">
                    <div class="org-field-icon">
                        <i class="fas fa-mosque"></i>
                    </div>

                    <h6 class="mb-1 fw-bold">Bidang Idarah</h6>
                    <p class="font-small text-muted mb-0">Manajemen & Organisasi</p>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="org-field-card p-4 bg-white h-100">
                    <div class="org-field-icon">
                        <i class="fas fa-pray"></i>
                    </div>

                    <h6 class="mb-1 fw-bold">Bidang Imarah</h6>
                    <p class="font-small text-muted mb-0">Peribadahan & Dakwah</p>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="org-field-card p-4 bg-white h-100">
                    <div class="org-field-icon">
                        <i class="fas fa-tools"></i>
                    </div>

                    <h6 class="mb-1 fw-bold">Bidang Riayah</h6>
                    <p class="font-small text-muted mb-0">Pemeliharaan & Bangunan</p>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="org-field-card p-4 bg-white h-100">
                    <div class="org-field-icon">
                        <i class="fas fa-users"></i>
                    </div>

                    <h6 class="mb-1 fw-bold">Bidang Sosial</h6>
                    <p class="font-small text-muted mb-0">Zakat & Pemberdayaan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section pt-0" style="background: #ffffff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="p-2 bg-white shadow border-radius">
                    <div class="structure-placeholder p-5 border-radius">
                        <i class="fas fa-sitemap fa-3x mb-3"></i>
                        <p class="text-muted italic mb-0">
                            "Bagan Visual dalam proses finalisasi oleh pengurus."
                        </p>
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