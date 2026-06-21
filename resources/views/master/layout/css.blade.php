<style>
    :root {
        --dkm-blue-dark: #1e3a8a;
        --dkm-blue-main: #2563eb;
        --dkm-blue-light: #0ea5e9;
        --dkm-blue-soft: #eff6ff;
    }

    .text-dkm-blue {
        color: var(--dkm-blue-main) !important;
    }

    .bg-dkm-blue {
        background: linear-gradient(
            135deg,
            var(--dkm-blue-dark) 0%,
            var(--dkm-blue-main) 55%,
            var(--dkm-blue-light) 100%
        ) !important;
    }

    .border-dkm-blue {
        border-color: var(--dkm-blue-main) !important;
    }

    .button-dkm-blue {
        background: linear-gradient(
            135deg,
            var(--dkm-blue-dark) 0%,
            var(--dkm-blue-main) 55%,
            var(--dkm-blue-light) 100%
        );
        color: #ffffff !important;
        border: none;
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.28);
        transition: all 0.25s ease;
    }

    .button-dkm-blue:hover {
        color: #ffffff !important;
        filter: brightness(0.96);
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(37, 99, 235, 0.36);
    }

    .button-outline-dkm-blue {
        color: var(--dkm-blue-main) !important;
        border: 1px solid var(--dkm-blue-main) !important;
        background: transparent;
        transition: all 0.25s ease;
    }

    .button-outline-dkm-blue:hover {
        color: #ffffff !important;
        background: var(--dkm-blue-main) !important;
        border-color: var(--dkm-blue-main) !important;
    }

    .feature-box-icon.bg-dkm-blue {
        background: linear-gradient(
            135deg,
            var(--dkm-blue-dark) 0%,
            var(--dkm-blue-main) 55%,
            var(--dkm-blue-light) 100%
        ) !important;
    }

    .dkm-blue-overlay {
        background: linear-gradient(
            135deg,
            rgba(30, 58, 138, 0.9),
            rgba(37, 99, 235, 0.86),
            rgba(14, 165, 233, 0.82)
        );
    }

    .dkm-blue-soft-bg {
        background-color: var(--dkm-blue-soft) !important;
    }
</style>