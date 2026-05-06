<footer class="text-white-50">
    <div class="section-sm bg-dark">
        <div class="container">
            <div class="row g-4">
                <!-- Brand/Logo Section -->
                <div class="col-12 col-lg-3">
                    <h3 class="text-white uppercase letter-spacing-1 mb-3">DKM Al-Hikmah</h3>
                    <p class="small">Memakmurkan Masjid, Mengabdi untuk Umat. Wadah silaturahmi dan kegiatan keislaman di lingkungan Plant & Office.</p>
                </div>

                <!-- Useful Links (Quick Access) -->
                <div class="col-6 col-sm-6 col-lg-3">
                    <h6 class="font-small fw-medium uppercase text-white mb-3">Navigasi</h6>
                    <ul class="list-dash animate-links list-unstyled">
                        <li><a href="{{ route('profil.index') }}" class="text-decoration-none">Profil DKM</a></li>
                        <li><a href="{{ route('kegiatan.index') }}" class="text-decoration-none">Kegiatan</a></li>
                        <li><a href="{{ route('laporan.index') }}" class="text-decoration-none">Laporan Keuangan</a></li>
                        <li><a href="{{ route('infaq.index') }}" class="text-decoration-none">Infaq</a></li>
                    </ul>
                </div>

                <!-- Additional Links (Resources) -->
                <div class="col-6 col-sm-6 col-lg-3">
                    <h6 class="font-small fw-medium uppercase text-white mb-3">Musala</h6>
                    <ul class="list-dash animate-links list-unstyled">
                        <li><a href="{{ route('musala.show', 'musala-kantor') }}" class="text-decoration-none">Musala Kantor</a></li>
                        <li><a href="{{ route('musala.show', 'musala-plant') }}" class="text-decoration-none">Musala Plant</a></li>
                        {{-- <li><a href="#" class="text-decoration-none">Jadwal Shalat</a></li>
                        <li><a href="#" class="text-decoration-none">E-Library</a></li> --}}
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <h6 class="font-small fw-medium uppercase text-white mb-3">Kontak & Lokasi</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2 text-success"></i> Kawasan Industri Plant, Indonesia</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2 text-success"></i> dkm.alhikmah@company.com</li>
                        <li class="mb-2"><i class="bi bi-whatsapp me-2 text-success"></i> +62 812 3456 7890</li>
                    </ul>
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div>

    <!-- Bottom Copyright -->
    <div class="bg-black py-4"> 
        <div class="container">
            <div class="row align-items-center g-2 g-lg-3">
                <div class="col-12 col-md-6 text-center text-md-start">
                    <p class="mb-0 small">&copy; 2026 <strong>DKM Al-Hikmah</strong>. Built with <i class="bi bi-heart-fill text-danger"></i> by Naomi.</p>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a class="button-circle button-circle-sm button-circle-social-facebook" href="#"><i class="bi bi-facebook"></i></a></li>
                        <li class="list-inline-item"><a class="button-circle button-circle-sm button-circle-social-instagram" href="#"><i class="bi bi-instagram"></i></a></li>
                        <li class="list-inline-item"><a class="button-circle button-circle-sm button-circle-social-youtube" href="#"><i class="bi bi-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top -->
<div class="scrolltotop icon-lg">
    <a class="button-circle button-circle-md button-circle-dark shadow" href="#"><i class="bi bi-arrow-up-short"></i></a>
</div>