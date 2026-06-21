<style>
    :root {
        --dkm-blue-dark: #1e40af;
        --dkm-blue-main: #2563eb;
        --dkm-blue-light: #0ea5e9;
        --dkm-blue-soft: #eff6ff;

        --dkm-bg: #f8fafc;
        --dkm-text: #0f172a;
        --dkm-muted: #64748b;
        --dkm-border: #e5e7eb;
        --dkm-card-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: var(--dkm-bg);
        color: var(--dkm-text);
    }

    /* =========================================================
       Main Admin Structure
    ========================================================= */

    .admin-shell {
        min-height: 100vh;
        display: flex;
    }

    .admin-main {
        flex: 1;
        margin-left: 280px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .admin-content {
        flex: 1;
        padding: 28px;
    }

    /* =========================================================
       Sidebar
    ========================================================= */

    .admin-sidebar {
        width: 280px;
        min-height: 100vh;
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.96) 0%,
            rgba(37, 99, 235, 0.94) 55%,
            rgba(14, 165, 233, 0.90) 100%
        );
        color: #ffffff;
        position: fixed;
        inset: 0 auto 0 0;
        z-index: 40;
    }

    .admin-sidebar-logo {
        padding: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.18);
    }

    .admin-brand-link {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #ffffff;
        text-decoration: none;
    }

    .admin-brand-logo,
    .admin-sidebar-logo img {
        height: 46px;
        width: auto;
        flex-shrink: 0;
    }

    .admin-brand-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
        min-width: 0;
    }

    .admin-brand-title {
        color: #ffffff;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    .admin-brand-subtitle {
        margin-top: 4px;
        color: rgba(255, 255, 255, 0.68);
        font-size: 12px;
        font-weight: 500;
    }

    .admin-sidebar-menu {
        padding: 18px;
    }

    .admin-sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 6px;
        padding: 12px 14px;
        border-radius: 14px;
        color: rgba(255, 255, 255, 0.82);
        font-size: 14px;
        font-weight: 650;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .admin-sidebar-link i {
        width: 20px;
        text-align: center;
        font-size: 16px;
    }

    .admin-sidebar-link:hover,
    .admin-sidebar-link.active {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.18);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
    }

    /* =========================================================
       Topbar / Header
    ========================================================= */

    .admin-topbar {
        min-height: 82px;
        background: #ffffff;
        border-bottom: 1px solid var(--dkm-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 0 28px;
        position: sticky;
        top: 0;
        z-index: 30;
    }

    .admin-topbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }

    .admin-page-heading {
        min-width: 0;
    }

    .admin-page-eyebrow {
        display: inline-flex;
        margin-bottom: 3px;
        color: var(--dkm-blue-main);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .admin-page-heading h1 {
        margin: 0;
        color: var(--dkm-text);
        font-size: 22px;
        font-weight: 850;
        line-height: 1.2;
    }

    .admin-page-heading p {
        margin: 4px 0 0;
        color: var(--dkm-muted);
        font-size: 13px;
        font-weight: 500;
        line-height: 1.4;
    }

    .admin-mobile-toggle {
        display: none;
        width: 40px;
        height: 40px;
        border: 1px solid var(--dkm-border);
        border-radius: 12px;
        background: #ffffff;
        color: var(--dkm-blue-main);
        font-size: 22px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .admin-mobile-toggle:hover {
        background: var(--dkm-blue-soft);
        border-color: rgba(37, 99, 235, 0.22);
    }

    /* =========================================================
       Topbar User
    ========================================================= */

    .admin-user-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .admin-user-info {
        align-items: center;
        gap: 10px;
        padding: 7px 10px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
    }

    .admin-user-name {
        color: var(--dkm-text);
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    .admin-user-role {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 999px;
        background: var(--dkm-blue-soft);
        color: var(--dkm-blue-main);
        font-size: 11px;
        font-weight: 800;
        text-transform: capitalize;
        line-height: 1;
    }

    .admin-user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: var(--dkm-blue-soft);
        color: var(--dkm-blue-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        flex-shrink: 0;
    }

    .admin-logout-btn {
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 13px;
        border-radius: 12px;
        border: 1px solid #fecaca;
        background: #ffffff;
        color: #dc2626;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .admin-logout-btn:hover {
        background: #dc2626;
        border-color: #dc2626;
        color: #ffffff;
    }

    /* =========================================================
       Cards / Buttons
    ========================================================= */

    .admin-card {
        background: #ffffff;
        border: 1px solid var(--dkm-border);
        border-radius: 22px;
        box-shadow: var(--dkm-card-shadow);
    }

    .admin-btn-blue {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border: 1px solid var(--dkm-blue-main);
        border-radius: 12px;
        background: var(--dkm-blue-main);
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .admin-btn-blue:hover {
        color: #ffffff;
        background: #1d4ed8;
        border-color: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
    }

    /* =========================================================
       Footer
    ========================================================= */

    .admin-footer {
        min-height: 64px;
        padding: 18px 28px;
        background: #ffffff;
        border-top: 1px solid var(--dkm-border);
        color: var(--dkm-muted);
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    /* =========================================================
       Responsive
    ========================================================= */

    @media (max-width: 991px) {
        .admin-sidebar {
            transform: translateX(-100%);
            transition: all 0.25s ease;
        }

        .admin-sidebar.show {
            transform: translateX(0);
        }

        .admin-main {
            margin-left: 0;
        }

        .admin-mobile-toggle {
            display: inline-flex;
        }

        .admin-topbar {
            padding: 14px 20px;
            align-items: flex-start;
        }

        .admin-page-heading h1 {
            font-size: 19px;
        }

        .admin-page-heading p {
            font-size: 12px;
        }

        .admin-content {
            padding: 20px;
        }

        .admin-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 575px) {
        .admin-topbar {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-user-badge {
            justify-content: space-between;
        }

        .admin-logout-btn span {
            display: none;
        }
    }
</style>