<style>
    .dkm-header-auth {
        display: flex !important;
        align-items: center;
        margin-left: 16px;
        flex-shrink: 0;
    }

    .header-menu .nav .nav-item.dkm-mobile-auth {
        display: none !important;
    }

    .dkm-mobile-logout-form {
        margin: 0;
    }

    .dkm-mobile-logout-btn {
        width: 100%;
        border: 0;
        background: transparent;
        color: inherit;
        font: inherit;
        text-align: left;
        cursor: pointer;
    }

    @media (max-width: 991px) {
        .header .container {
            display: flex;
            align-items: center;
        }

        .header-logo {
            min-width: 0;
            flex: 1;
        }

        .dkm-header-title {
            font-size: 17px;
            line-height: 1.2;
            white-space: nowrap;
        }

        .dkm-header-auth {
            display: none !important;
        }

        .header-menu .nav .nav-item.dkm-mobile-auth {
            display: block !important;
        }

        .header-toggle {
            margin-left: 12px;
            flex-shrink: 0;
        }

        .header-menu {
            max-height: calc(100vh - 80px);
            overflow-y: auto;
        }
    }

    @media (max-width: 420px) {
        .dkm-header-title {
            font-size: 14px;
            letter-spacing: 0.04em;
        }

        .header-logo img {
            height: 34px !important;
        }

        .header-logo a {
            margin-right: 8px !important;
        }
    }
</style>

<!-- Header -->
<div class="header right header-color-dark transparent-light sticky-autohide">
    <div class="container">

        <!-- Logo -->
        <div class="header-logo d-flex align-items-center">
            <a href="{{ route('dashboard.index') }}" class="me-3">
                <img class="logo-dark"
                     src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}"
                     alt="DKM AL HIKMAH"
                     style="height: 40px; width: auto;">

                <img class="logo-light"
                     src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}"
                     alt="DKM AL HIKMAH"
                     style="height: 40px; width: auto;">
            </a>

            <h3 class="dkm-header-title uppercase letter-spacing-1 mb-0">
                <a href="{{ route('dashboard.index') }}" class="text-decoration-none text-white">
                    DKM AL HIKMAH
                </a>
            </h3>
        </div>

        <!-- Menu -->
        <div class="header-menu">
            <ul class="nav">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profil.index') }}">
                        Profil
                    </a>

                    @if(!empty($profilNavbar) && $profilNavbar->isNotEmpty())
                        <ul class="nav-dropdown">
                            @foreach($profilNavbar as $item)
                                @php
                                    $routeName = $item['route_name'] ?? null;
                                @endphp

                                @if($routeName && \Illuminate\Support\Facades\Route::has($routeName))
                                    <li class="nav-dropdown-item">
                                        <a class="nav-dropdown-link" href="{{ route($routeName) }}">
                                            {{ $item['title'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kegiatan.index') }}">
                        Kegiatan
                    </a>

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
                                <a class="nav-dropdown-link"
                                   href="{{ route('kegiatan.category', $navCategory['slug']) }}">
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
                    <a class="nav-link" href="{{ route('laporan.index') }}">
                        Laporan Keuangan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('musala.index') }}">
                        Musala
                    </a>

                    <ul class="nav-dropdown">
                        <li class="nav-dropdown-item">
                            <a class="nav-dropdown-link" href="{{ route('musala.category', 'plant') }}">
                                Musala Plant
                            </a>
                        </li>

                        <li class="nav-dropdown-item">
                            <a class="nav-dropdown-link" href="{{ route('musala.category', 'kantor') }}">
                                Musala Kantor
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('infaq.index') }}">
                        Infaq
                    </a>
                </li>

                <!-- Mobile Auth Only -->
                <li class="nav-item dkm-mobile-auth">
                    @auth
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                    @endauth
                </li>

                @auth
                    <li class="nav-item dkm-mobile-auth">
                        <form action="{{ route('logout') }}"
                              method="POST"
                              class="dkm-mobile-logout-form">
                            @csrf

                            <button type="submit"
                                    class="nav-link dkm-mobile-logout-btn">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth

            </ul>
        </div>

        <!-- Desktop Auth Only -->
        <div class="dkm-header-auth">
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
        <button class="header-toggle" type="button">
            <span></span>
        </button>

    </div>
</div>
<!-- end Header -->