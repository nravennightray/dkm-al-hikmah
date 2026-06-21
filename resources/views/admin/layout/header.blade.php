<header class="admin-topbar">
    <div class="admin-topbar-left">
        <button type="button" class="admin-mobile-toggle" onclick="toggleAdminSidebar()">
            <i class="bi bi-list"></i>
        </button>

        <div class="admin-page-heading">
            <span class="admin-page-eyebrow">Admin Panel</span>

            <h1>@yield('page_title', 'Dashboard')</h1>

            <p>@yield('page_subtitle', 'Kelola data dan informasi DKM AL HIKMAH')</p>
        </div>
    </div>

    <div class="admin-user-badge">
        <div class="admin-user-info d-none d-sm-flex">
            <span class="admin-user-name">
                {{ session('sheet_user.name') ?? auth()->user()->name ?? 'Admin DKM' }}
            </span>

            <span class="admin-user-role">
                {{ session('sheet_user.role') ?? 'admin' }}
            </span>
        </div>

        <div class="admin-user-avatar">
            {{ strtoupper(substr(session('sheet_user.name') ?? auth()->user()->name ?? 'A', 0, 1)) }}
        </div>

        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf

            <button type="submit" class="admin-logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</header>