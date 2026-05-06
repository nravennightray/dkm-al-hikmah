@extends('master.layout.app')

@section('title', 'Daftar Kegiatan - DKM Al Hikmah')

@section('css')
<style>
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        background-color: #f0fdf4 !important;
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>
@endsection

@section('content')
<div class="section-xl" style="background: linear-gradient(180deg, #0a2e1d 0%, #198754 100%);">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Kegiatan Kami</h1>
        <p class="text-white-50">Program rutin dan temporer untuk memakmurkan masjid dan umat.</p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">
        <div class="row g-4">
            {{-- Category Card Helper --}}
            @php
                $categories = [
                    ['name' => 'Kajian Ikhwan', 'slug' => 'kajian-ikhwan', 'icon' => 'fa-hands-helping', 'desc' => 'Program pembinaan khusus untuk jamaah laki-laki.'],
                    ['name' => 'Kajian Akhwat', 'slug' => 'kajian-akhwat', 'icon' => 'fa-female', 'desc' => 'Majelis ilmu dan silaturahmi khusus jamaah perempuan.'],
                    ['name' => 'Gema Rahmah', 'slug' => 'gema-rahmah', 'icon' => 'fa-microphone', 'desc' => 'Kegiatan syiar Islam dan festival keagamaan.'],
                    ['name' => 'Idul Qurban', 'slug' => 'idul-qurban', 'icon' => 'fa-sheep', 'desc' => 'Pengelolaan dan pendistribusian hewan qurban tahunan.'],
                    ['name' => 'Khitanan Massal', 'slug' => 'khitanan-massal', 'icon' => 'fa-child', 'desc' => 'Bakti sosial khitanan bagi anak-anak yang membutuhkan.'],
                    ['name' => 'Santunan Yatim', 'slug' => 'santunan-yatim', 'icon' => 'fa-heart', 'desc' => 'Penyaluran bantuan dan kepedulian bagi anak yatim & dhuafa.'],
                ];
            @endphp

            @foreach($categories as $cat)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('kegiatan.category', $cat['slug']) }}" class="text-decoration-none">
                    <div class="p-4 bg-white border-radius shadow-sm h-100 hover-card transition border-bottom border-success border-3">
                        <div class="text-success mb-3">
                            <i class="fas {{ $cat['icon'] }} fa-2x"></i>
                        </div>
                        <h4 class="text-dark fw-normal">{{ $cat['name'] }}</h4>
                        <p class="text-muted small mb-3">{{ $cat['desc'] }}</p>
                        <span class="text-success small fw-bold">Lihat Program <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection