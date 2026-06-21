

    <!-- Header -->
		<div class="header right header-color-dark transparent-light sticky-autohide">
			<div class="container">
				<!-- Logo -->
				<div class="header-logo d-flex align-items-center">
					<a href="{{ route('dashboard.index') }}" class="me-3">
						<img class="logo-dark" src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}" alt="Logo" style="height: 40px; width: auto;">
						<img class="logo-light" src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}" alt="Logo" style="height: 40px; width: auto;">
					</a>

					<h3 class="uppercase letter-spacing-1 mb-0">
						<a href="{{ route('dashboard.index') }}" class="text-decoration-none text-white">DKM AL HIKMAH</a>
					</h3>
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
								@php
									$navCategories = collect($headerKegiatanCategories ?? [])
										->filter(function ($category) {
											return ! empty($category['slug'] ?? null)
												&& ! empty($category['name'] ?? null);
										})
										->values();
								@endphp
								@forelse($navCategories as $navCategory)
									<li class="nav-dropdown-item">
										<a class="nav-dropdown-link" href="{{ route('kegiatan.category', $navCategory['slug']) }}">
											{{ $navCategory['name'] }}
										</a>
									</li>
								@empty
									<li class="nav-dropdown-item">
										<a class="nav-dropdown-link" href="{{ route('kegiatan.index') }}">
											Lihat Semua Kegiatan
										</a>
									</li>
								@endforelse
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

				<div class="d-flex align-items-center ms-3">
					@auth
						<a href="{{ route('admin.dashboard') }}"
						class="button button-sm button-outline-white me-2">
							Dashboard
						</a>

						<form action="{{ route('logout') }}"
							method="POST"
							class="d-inline">
							@csrf

							<button type="submit"
									class="button button-sm button-white">
								Logout
							</button>
						</form>
					@else
						<a href="{{ route('login') }}"
						class="button button-sm button-white">
							Login
						</a>
					@endauth
				</div>
				<!-- Menu Toggle -->
				<button class="header-toggle">
					<span></span>
				</button>
			</div><!-- end container -->
		</div>
		<!-- end Header -->