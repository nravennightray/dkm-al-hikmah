
@extends('master.layout.app')

@section('title', 'DKM AL HIKMAH')

@section('content')
    <div class="section-2xl bg-image parallax" data-bg-src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}">
        <!-- Removed 'backdrop-filter-blur' here -->
        <div class="section-divider-curve-bottom" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="container">
                <div class="row align-items-center g-5">
                    
                    <!-- Left Content -->
                    <div class="col-12 order-lg-1">
                        <h1 class="display-3 font-family-outfit fw-bold text-white">DKM AL-HIKMAH PT SRI</h1>
                        
                        <p class="lead text-white-50 mt-3">
                            Menjadi pusat syiar Islam yang inklusif, modern, dan menebar manfaat bagi seluruh jamaah. 
                            Mari bergabung bersama kami dalam memakmurkan masjid dan membangun ukhuwah.
                        </p>

                        <div class="d-flex gap-3 mt-4">
                            <a href="#about" class="button button-lg button-radius button-white shadow">Tentang Kami</a>
                            <a href="#activities" class="button button-lg button-radius button-outline-white">Kegiatan Rutin</a>
                        </div>

                        <!-- Small Stat/Badge Row -->
                        <div class="d-flex align-items-center mt-5 pt-3 border-top border-white-10">
                            <div class="me-4">
                                <h4 class="mb-0 text-white">5+</h4>
                                <span class="font-small text-white-50 uppercase">Program Mingguan</span>
                            </div>
                            <div>
                                <h4 class="mb-0 text-white">1000+</h4>
                                <span class="font-small text-white-50 uppercase">Jamaah Aktif</span>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end bg-dark-* -->
    </div>

    <div class="n-margin-6">
        <div class="container icon-5xl">
            <div class="row g-4">
                <!-- Feature box 1: Ibadah -->
                <div class="col-12 col-lg-4">
                    <!-- Added h-100 to the card div -->
                    <div class="bg-white border-radius-1 box-shadow hover-float p-4 p-xl-5 h-100">
                        <div class="text-success mb-2 mb-lg-3">
                            <!-- Swapped to 'bi-moon-stars' which is more universally supported than 'bi-mosque' -->
                            <i class="bi bi-moon-stars"></i>
                        </div>
                        <h5 class="fw-medium">Pusat Ibadah</h5>
                        <p>Menyelenggarakan shalat berjamaah, kajian rutin, dan peringatan hari besar Islam dengan nyaman dan khidmat.</p>
                    </div>
                </div>

                <!-- Feature box 2: Pendidikan -->
                <div class="col-12 col-lg-4">
                    <!-- Added h-100 here too -->
                    <div class="bg-white border-radius-1 box-shadow hover-float p-4 p-xl-5 h-100">
                        <div class="text-success mb-2 mb-lg-3">
                            <i class="bi bi-book"></i>
                        </div>
                        <h5 class="fw-medium">Pendidikan & Dakwah</h5>
                        <p>Membina generasi qur'ani melalui TPA, remaja masjid, serta literasi keislaman bagi seluruh lapisan masyarakat.</p>
                    </div>
                </div>

                <!-- Feature box 3: Sosial -->
                <div class="col-12 col-lg-4">
                    <!-- Added h-100 here too -->
                    <div class="bg-white border-radius-1 box-shadow hover-float p-4 p-xl-5 h-100">
                        <div class="text-success mb-2 mb-lg-3">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h5 class="fw-medium">Pemberdayaan Sosial</h5>
                        <p>Menyalurkan Zakat, Infaq, dan Shadaqah secara amanah untuk kesejahteraan umat dan warga sekitar.</p>
                    </div>
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div>

    <div id="kegiatan" class="section">
        <div class="container">
            <!-- Section Title -->
            <div class="section-title text-center mb-5">
                <h6 class="font-small uppercase text-success letter-spacing-1">Dokumentasi</h6>
                <h2 class="fw-normal">Galeri Kegiatan Kami</h2>
            </div>

            <div class="row portfolio-grid g-3 border-radius">
                <!-- Box 1: Kajian Ikhwan -->
                <div class="col-12 col-md-6 col-lg-4 portfolio-item">
                    <div class="portfolio-box shadow-sm border-radius">
                        <div class="portfolio-img">
                            <img src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}" alt="Kajian Ikhwan">
                        </div>
                        <a href="#"></a>
                        <div class="portfolio-title">
                            <div>
                                <h5 class="fw-normal">Kajian Ikhwan</h5>
                                <span>Ibadah</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Gema Rahmah -->
                <div class="col-12 col-md-6 col-lg-4 portfolio-item">
                    <div class="portfolio-box shadow-sm border-radius">
                        <div class="portfolio-img">
                            <img src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}" alt="Gema Rahmah">
                        </div>
                        <a href="#"></a>
                        <div class="portfolio-title">
                            <div>
                                <h5 class="fw-normal">Gema Rahmah</h5>
                                <span>Sosial</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box 3: Santunan Yatim -->
                <div class="col-12 col-md-6 col-lg-4 portfolio-item">
                    <div class="portfolio-box shadow-sm border-radius">
                        <div class="portfolio-img">
                            <img src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}" alt="Santunan Yatim">
                        </div>
                        <a href="#"></a>
                        <div class="portfolio-title">
                            <div>
                                <h5 class="fw-normal">Santunan Yatim</h5>
                                <span>Sosial</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box 4: Kajian Akhwat -->
                <div class="col-12 col-md-6 col-lg-4 portfolio-item">
                    <div class="portfolio-box shadow-sm border-radius">
                        <div class="portfolio-img">
                            <img src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}" alt="Kajian Akhwat">
                        </div>
                        <a href="#"></a>
                        <div class="portfolio-title">
                            <div>
                                <h5 class="fw-normal">Kajian Akhwat</h5>
                                <span>Ibadah</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box 5: Idul Qurban -->
                <div class="col-12 col-md-6 col-lg-4 portfolio-item">
                    <div class="portfolio-box shadow-sm border-radius">
                        <div class="portfolio-img">
                            <img src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}" alt="Idul Qurban">
                        </div>
                        <a href="#"></a>
                        <div class="portfolio-title">
                            <div>
                                <h5 class="fw-normal">Idul Qurban</h5>
                                <span>Hari Besar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box 6: Khitanan Massal -->
                <div class="col-12 col-md-6 col-lg-4 portfolio-item">
                    <div class="portfolio-box shadow-sm border-radius">
                        <div class="portfolio-img">
                            <img src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}" alt="Khitanan Massal">
                        </div>
                        <a href="#"></a>
                        <div class="portfolio-title">
                            <div>
                                <h5 class="fw-normal">Khitanan Massal</h5>
                                <span>Sosial</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end row/portfolio-grid -->
        </div><!-- end container -->
    </div>

    <div id="profil" class="section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <div class="box-shadow">
                        <!-- Replace with a photo of the Mosque building -->
                        <img class="border-radius" src="{{ asset('assets/images/dkm/dkm-pic-1.jpeg') }}" alt="DKM Al Hikmah">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h6 class="font-small uppercase text-success letter-spacing-1">Profil Masjid</h6>
                    <h2 class="fw-normal mb-lg-3">Membangun Umat, Menebar Manfaat di DKM Al Hikmah</h2>
                    <p>DKM Al Hikmah hadir sebagai pusat peribadahan dan pembinaan umat yang inklusif. Kami berkomitmen untuk menyediakan lingkungan yang nyaman bagi jamaah untuk beribadah, belajar, dan bersosialisasi berdasarkan nilai-nilai Al-Qur'an dan Sunnah.</p>
                    <div class="row g-2 mt-3">
                        <div class="col-6"><i class="bi bi-check-circle text-success me-2"></i> Berdiri Sejak 19xx</div>
                        <div class="col-6"><i class="bi bi-check-circle text-success me-2"></i> Kapasitas 1000+ Jamaah</div>
                    </div>
                    <a class="button-text-2 mt-4" href="#">Selengkapnya tentang Sejarah Kami</a>
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
                <!-- Box 1 -->
                <div class="col-12 col-md-4">
                    <div class="feature-box text-center">
                        <div class="feature-box-icon bg-success text-white">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <h5 class="fw-medium">Musala Kantor & Plant</h5>
                        <p>Penyediaan ruang ibadah yang bersih dan nyaman di lingkungan kerja untuk mendukung produktivitas jasmani dan rohani.</p>
                    </div>
                </div>
                <!-- Box 2 -->
                <div class="col-12 col-md-4">
                    <div class="feature-box text-center">
                        <div class="feature-box-icon bg-success text-white">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="fw-medium">Transparansi Kas</h5>
                        <p>Laporan keuangan yang diperbarui secara rutin sebagai bentuk amanah kami dalam mengelola dana umat.</p>
                    </div>
                </div>
                <!-- Box 3 -->
                <div class="col-12 col-md-4">
                    <div class="feature-box text-center">
                        <div class="feature-box-icon bg-success text-white">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h5 class="fw-medium">Tabungan Qurban/Umroh</h5>
                        <p>Program bimbingan dan pengelolaan dana untuk membantu jamaah mewujudkan niat ibadah mulia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section pt-0">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-12 col-lg-5 order-lg-2">
                    <img src="{{ asset('assets/images/dkm/dkm-pic-2.jpg') }}" alt="Info Kajian" class="border-radius">
                </div>
                <div class="col-12 col-lg-7 order-lg-1">
                    <h3 class="mb-4 fw-normal">Pertanyaan Sering Diajukan (FAQ)</h3>
                    <ul class="accordion single-open rounded">
                        <li class="active">
                            <div class="accordion-title"><h5 class="fw-medium">Bagaimana cara menyalurkan Infaq/Sedekah?</h5></div>
                            <div class="accordion-content"><p>Anda dapat menyalurkan infaq langsung melalui kotak amal di masjid atau melalui transfer bank ke rekening resmi DKM Al Hikmah yang tertera di menu Infaq.</p></div>
                        </li>
                        <li>
                            <div class="accordion-title"><h5 class="fw-medium">Apakah ada kajian rutin untuk Muslimah?</h5></div>
                            <div class="accordion-content"><p>Ya, kami menyelenggarakan Kajian Akhwat secara rutin setiap hari [Sebutkan Hari] ba'da [Sebutkan Waktu] di area utama masjid.</p></div>
                        </li>
                        <li>
                            <div class="accordion-title"><h5 class="fw-medium">Bagaimana cara mendaftar Tabungan Umroh?</h5></div>
                            <div class="accordion-content"><p>Silakan hubungi sekretariat DKM atau pengurus di Musala Kantor untuk mendapatkan formulir pendaftaran dan rincian program.</p></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="section-xl bg-image parallax" data-bg-src="{{ asset('assets/images/dkm/parallax-bg.jpg') }}">
        <div style="background-color: rgba(25, 135, 84, 0.7); padding: 100px 0;">
            <div class="container text-center text-white">
                <div class="row">
                    <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                        <h1 class="display-4 font-family-outfit fw-normal">Mari Berkontribusi dalam Dakwah</h1>
                        <p class="lead mb-4">Setiap rupiah yang Anda infaq-kan menjadi investasi akhirat dan membantu memakmurkan masjid kita tercinta.</p>
                        <div class="mt-4">
                            <a class="button button-lg button-radius button-white" href="#">Salurkan Infaq Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection