@php
    $currentRole = strtolower(session('sheet_user.role') ?? 'karyawan');
    $isAdmin = in_array($currentRole, ['superadmin', 'admin'], true);
@endphp

<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-logo">
        <a href="{{ $isAdmin ? route('admin.dashboard') : route('admin.keuangan.index') }}"
           class="admin-brand-link">

            <img src="{{ asset('assets/images/dkm/dkm-logo-white.png') }}"
                 alt="DKM AL HIKMAH"
                 class="admin-brand-logo">

            <div class="admin-brand-text">
                <div class="admin-brand-title">DKM AL HIKMAH</div>
                <small class="admin-brand-subtitle">Admin Portal</small>
            </div>

        </a>
    </div>

    <nav class="admin-sidebar-menu">
        <a href="{{ route('admin.dashboard') }}"
           class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        {{-- ADMIN ONLY MENU --}}
        @if($isAdmin)
            <a href="{{ route('admin.users.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Users</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('admin.kegiatan.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i>
                <span>Kegiatan</span>
            </a>

            <a href="{{ route('admin.musala.index') }}"
               class="admin-sidebar-link {{ request()->routeIs('admin.musala.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Musala</span>
            </a>

            <a href="{{ route('admin.profil.index') }}"
                class="admin-sidebar-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Profil DKM</span>
            </a>

            <a href="{{ route('admin.home-info.index') }}"
                class="admin-sidebar-link {{ request()->routeIs('admin.home-info.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i>
                <span>Info Beranda</span>
            </a>

            <a href="{{ route('admin.infaq.index') }}"
                class="admin-sidebar-link {{ request()->routeIs('admin.infaq.*') ? 'active' : '' }}">
                <i class="bi bi-heart"></i>
                <span>Infaq</span>
            </a>
        @endif

        {{-- ALL ROLES --}}
        <a href="{{ route('admin.keuangan.index') }}"
           class="admin-sidebar-link {{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Keuangan</span>
        </a>

        <a href="{{ route('dashboard.index') }}"
           class="admin-sidebar-link">
            <i class="bi bi-globe2"></i>
            <span>Lihat Website</span>
        </a>

    </nav>
</aside>