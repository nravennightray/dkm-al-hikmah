

    <!-- Header -->
		<div class="header right header-color-dark transparent-light sticky-autohide">
			<div class="container">
				<!-- Logo -->
				<div class="header-logo">
					<h3 class="uppercase letter-spacing-1"><a href="#">DKM AL HIKMAH</a></h3>
					<!-- 
					<img class="logo-dark" src="../assets/images/your-logo-dark.png" alt="">
					<img class="logo-light" src="../assets/images/your-logo-light.png" alt=""> 
					-->
				</div>
				<!-- Menu -->
				<div class="header-menu">
					<ul class="nav">
						<li class="nav-item">
							<a class="nav-link" href="{{ route('profil.index') }}">Profil</a>
                            <ul class="nav-dropdown">
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('profil.sejarah') }}">Sejarah</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('profil.visi-misi') }}">Visi dan Misi</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('profil.struktur') }}">Struktur Organisasi</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('profil.kepengurusan') }}">Kepengurusan</a></li>
							</ul>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('kegiatan.index') }}">Kegiatan</a>
							<ul class="nav-dropdown">
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('kegiatan.category', 'kajian-ikhwan') }}">Kajian Ikhwan</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('kegiatan.category', 'kajian-akhwat') }}">Kajian Akhwat</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('kegiatan.category', 'gema-rahmah') }}">Gema Rahmah</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('kegiatan.category', 'idul-qurban') }}">Idul Qurban</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('kegiatan.category', 'khitanan-massal') }}">Khitanan Massal</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('kegiatan.category', 'santunan-yatim') }}">Santunan Yatim & Dhuafa</a></li>
							</ul>
						</li>
                        <li class="nav-item">
							<a class="nav-link" href="{{ route('laporan.index') }}">Laporan Keuangan</a>
							<ul class="nav-dropdown">
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('laporan.show', 'laporan-kas') }}">Laporan Kas</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('laporan.show', 'tabungan-umroh') }}">Tabungan Umroh</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('laporan.show', 'tabungan-qurban') }}">Tabungan Qurban</a></li>
							</ul>
						</li>
                        <li class="nav-item">
							<a class="nav-link" href="{{ route('musala.index') }}">Musala Plant</a>
							<ul class="nav-dropdown">
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('musala.show', 'musala-kantor') }}">Musala Kantor</a></li>
								<li class="nav-dropdown-item"><a class="nav-dropdown-link" href="{{ route('musala.show', 'musala-plant') }}">Musala Plant</a></li>
							</ul>
						</li>
                        <li class="nav-item">
							<a class="nav-link" href="{{ route('infaq.index') }}">Infaq</a>
						</li>
					</ul>
				</div>
				<!-- Menu Toggle -->
				<button class="header-toggle">
					<span></span>
				</button>
			</div><!-- end container -->
		</div>
		<!-- end Header -->