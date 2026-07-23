@extends('master.layout.app')

@section('title', ($settings['hero_title'] ?? 'Infaq & Sedekah') . ' - DKM Al Hikmah')

@section('css')
<style>
    .infaq-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .infaq-breadcrumb {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 15px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
        color: rgba(255, 255, 255, 0.82);
        font-size: 13px;
        font-weight: 700;
    }

    .infaq-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
    }

    .infaq-breadcrumb a:hover {
        text-decoration: underline;
    }

    .infaq-hero-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 14px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.16);
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .section-xl {
        padding-top: 140px !important;
        padding-bottom: 70px !important;
    }

    .infaq-section {
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
    }

    .infaq-qris-card,
    .infaq-bank-card {
        height: 100%;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.08);
    }

    .infaq-qris-card {
        padding: 32px;
        text-align: center;
    }

    .infaq-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(37, 99, 235, 0.10);
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .qris-box {
        padding: 18px;
        margin: 24px auto 18px;
        max-width: 330px;
        border-radius: 24px;
        background: linear-gradient(180deg, #eff6ff 0%, #ffffff 100%);
        border: 1px solid rgba(37, 99, 235, 0.12);
    }

    .qris-box img {
        width: 100%;
        max-width: 270px;
        height: auto;
        border-radius: 18px;
        background: #ffffff;
    }

    .qris-placeholder {
        width: 100%;
        max-width: 270px;
        aspect-ratio: 1 / 1;
        margin: 0 auto;
        border-radius: 18px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 54px;
    }

    .infaq-bank-title {
        color: #0f172a;
        line-height: 1.25;
    }

    .bank-account-card {
        overflow: hidden;
        border-radius: 22px;
        background: #f8fbff;
        border: 1px solid rgba(37, 99, 235, 0.08);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        transition: all 0.25s ease;
    }

    .bank-account-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 38px rgba(37, 99, 235, 0.12);
    }

    .bank-account-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 24px;
    }

    .bank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .bank-number {
        margin: 10px 0 4px;
        color: #0f172a;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 0.04em;
        word-break: break-all;
    }

    .copy-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        border-radius: 14px;
        background: #ffffff;
        color: #2563eb;
        border: 1px solid rgba(37, 99, 235, 0.25);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.12);
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .copy-btn:hover {
        background: #eff6ff;
        transform: translateY(-1px);
    }

    .transfer-note {
        margin-top: 32px;
        padding: 22px;
        border-radius: 22px;
        background: #eff6ff;
        border: 1px solid rgba(37, 99, 235, 0.18);
        color: #475569;
        font-size: 14px;
        line-height: 1.7;
    }

    .empty-bank {
        padding: 42px 24px;
        text-align: center;
        border-radius: 24px;
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        color: #64748b;
    }

    .empty-bank-icon {
        width: 66px;
        height: 66px;
        margin: 0 auto 16px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    @media (max-width: 991px) {
        .infaq-bank-card {
            margin-top: 8px;
        }
    }

    @media (max-width: 767px) {
        .section-xl {
            padding-top: 120px !important;
            padding-bottom: 60px !important;
        }

        .section-xl h1 {
            font-size: 36px;
        }

        .infaq-qris-card {
            padding: 24px;
        }

        .bank-account-body {
            align-items: flex-start;
            flex-direction: column;
        }

        .copy-btn {
            width: 100%;
        }

        .bank-number {
            font-size: 23px;
        }
    }

    @media (max-width: 380px) {
        .section-xl h1 {
            font-size: 31px;
        }

        .bank-number {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')

@php
    $settings = $settings ?? [];
    $accounts = $accounts ?? collect();

    $heroBadge = $settings['hero_badge'] ?? 'Dukung Kebaikan';
    $heroTitle = $settings['hero_title'] ?? 'Infaq & Sedekah';
    $heroQuote = $settings['hero_quote'] ?? '"Harta tidak akan berkurang karena sedekah." (HR. Muslim)';

    $qrisBadge = $settings['qris_badge'] ?? 'QRIS Infaq';
    $qrisTitle = $settings['qris_title'] ?? 'Scan QRIS Infaq';
    $qrisDescription = $settings['qris_description'] ?? 'Salurkan infaq dengan mudah melalui QRIS resmi DKM Al Hikmah.';
    $qrisImage = $settings['qris_image'] ?? '';
    $qrisNote = $settings['qris_note'] ?? '';

    $bankTitle = $settings['bank_title'] ?? 'Transfer Bank';
    $bankDescription = $settings['bank_description'] ?? 'Anda dapat menyalurkan donasi melalui transfer ke rekening resmi DKM Al Hikmah di bawah ini:';
    $transferNote = $settings['transfer_note'] ?? '';

    $qrisImageUrl = !empty($qrisImage)
        ? asset('image/infaq/' . $qrisImage)
        : null;
@endphp

<div class="section-xl infaq-hero">
    <div class="container text-center pt-5">
        <div class="infaq-breadcrumb">
            <a href="{{ url('/') }}">
                Beranda
            </a>

            <i class="fas fa-chevron-right small"></i>

            <span>
                Infaq
            </span>
        </div>

        @if(!empty($heroBadge))
            <div class="infaq-hero-badge">
                <i class="bi bi-heart-fill"></i>
                {{ $heroBadge }}
            </div>
        @endif

        <h1 class="fw-normal text-white display-4">
            {{ $heroTitle }}
        </h1>

        @if(!empty($heroQuote))
            <p class="text-white-50 mb-0">
                {{ $heroQuote }}
            </p>
        @endif
    </div>
</div>

<div class="section infaq-section">
    <div class="container">
        <div class="row g-5 align-items-stretch">

            <div class="col-lg-6">
                <div class="infaq-qris-card">
                    <div class="mb-4">
                        <span class="infaq-badge">
                            {{ $qrisBadge }}
                        </span>

                        <h4 class="fw-bold mt-3 mb-2">
                            {{ $qrisTitle }}
                        </h4>

                        <p class="text-muted small mb-0">
                            {{ $qrisDescription }}
                        </p>
                    </div>

                    <div class="qris-box">
                        @if($qrisImageUrl)
                            <img src="{{ $qrisImageUrl }}"
                                 alt="{{ $qrisTitle }}">
                        @else
                            <div class="qris-placeholder">
                                <i class="bi bi-qr-code"></i>
                            </div>
                        @endif
                    </div>

                    @if(!empty($qrisNote))
                        <p class="small text-muted mb-0">
                            {{ $qrisNote }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <div class="infaq-bank-card p-4 p-lg-5">
                    <h2 class="fw-bold mb-3 infaq-bank-title">
                        {{ $bankTitle }}
                    </h2>

                    @if(!empty($bankDescription))
                        <p class="text-muted mb-4">
                            {{ $bankDescription }}
                        </p>
                    @endif

                    @forelse($accounts as $acc)
                        @php
                            $bank = $acc['bank'] ?? '-';
                            $number = $acc['number'] ?? '-';
                            $holder = $acc['holder'] ?? '-';
                        @endphp

                        <div class="bank-account-card mb-3">
                            <div class="bank-account-body">
                                <div>
                                    <span class="bank-badge">
                                        {{ $bank }}
                                    </span>

                                    <div class="bank-number">
                                        {{ $number }}
                                    </div>

                                    <small class="text-muted">
                                        a.n {{ $holder }}
                                    </small>
                                </div>

                                <button type="button"
                                        class="copy-btn"
                                        data-copy="{{ $number }}">
                                    <i class="far fa-copy"></i>
                                    <span>Salin</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-bank">
                            <div class="empty-bank-icon">
                                <i class="bi bi-bank"></i>
                            </div>

                            <h5 class="fw-bold mb-2">
                                Rekening Belum Tersedia
                            </h5>

                            <p class="mb-0">
                                Informasi rekening bank belum tersedia saat ini.
                            </p>
                        </div>
                    @endforelse

                    @if(!empty($transferNote))
                        <div class="transfer-note">
                            <i class="fas fa-info-circle me-2" style="color: #2563eb;"></i>
                            {{ $transferNote }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function fallbackCopyText(text) {
            const textarea = document.createElement('textarea');

            textarea.value = text;
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';

            document.body.appendChild(textarea);
            textarea.select();

            try {
                document.execCommand('copy');
            } catch (err) {}

            document.body.removeChild(textarea);
        }

        document.querySelectorAll('.copy-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const text = this.getAttribute('data-copy') || '';
                const label = this.querySelector('span');
                const originalText = label.textContent;

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text);
                } else {
                    fallbackCopyText(text);
                }

                label.textContent = 'Tersalin';

                setTimeout(function () {
                    label.textContent = originalText;
                }, 1400);
            });
        });
    });
</script>
@endsection