@extends('master.layout.app')

@section('title', ucwords(str_replace('-', ' ', $slug)) . ' - ' . ucwords(str_replace('-', ' ', $category)))

@section('content')
<div class="section-sm" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container pt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kegiatan.category', $category) }}" class="text-white-50">{{ ucwords(str_replace('-', ' ', $category)) }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Detail Artikel</li>
            </ol>
        </nav>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-normal mb-3">{{ ucwords(str_replace('-', ' ', $slug)) }}</h1>
                <div class="d-flex align-items-center mb-4 text-muted">
                    <span class="me-3"><i class="far fa-calendar-alt me-1"></i> 10 Mei 2026</span>
                    <span><i class="far fa-folder me-1"></i> {{ ucwords(str_replace('-', ' ', $category)) }}</span>
                </div>

                <div class="mb-5 shadow-sm border-radius overflow-hidden">
                    <img src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}" class="img-fluid w-100" alt="Detail">
                </div>

                <div class="content-area lead-drop-cap">
                    <p>Ini adalah isi detail dari kegiatan <strong>{{ $slug }}</strong>. Saat ini data masih bersifat dinamis berdasarkan URL.</p>
                    <p>Nantinya, bagian ini akan menampilkan teks lengkap, hadits-hadits yang dibahas, serta kesimpulan dari kajian yang telah dilaksanakan.</p>
                    
                    <blockquote class="p-4 bg-light border-start border-success border-4 my-4 italic">
                        "Barangsiapa yang menempuh jalan untuk mencari ilmu, maka Allah akan mudahkan baginya jalan menuju surga." (HR. Muslim)
                    </blockquote>

                    <p>Semoga kegiatan ini membawa keberkahan bagi seluruh jamaah DKM Al Hikmah.</p>
                </div>

                <hr class="my-5">
                
                <!-- Back Button -->
                <a href="{{ route('kegiatan.category', $category) }}" class="btn btn-outline-success">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke {{ ucwords(str_replace('-', ' ', $category)) }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection