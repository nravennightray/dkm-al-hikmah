@extends('master.layout.app')

@section('title', 'Laporan Keuangan - DKM Al Hikmah')

@section('css')
<style>
    .laporan-hero {
        background: linear-gradient(180deg, rgba(30, 64, 175, 0.98) 0%, rgba(37, 99, 235, 0.95) 55%, rgba(14, 165, 233, 0.92) 100%);
    }

    .kas-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        margin-top: -70px;
        position: relative;
        z-index: 2;
    }

    .kas-summary-card {
        min-height: 170px;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.9);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        padding: 30px;
        position: relative;
        overflow: hidden;
    }

    .kas-summary-card::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 7px;
        background: #198754;
    }

    .kas-summary-card.danger::before {
        background: #dc3545;
    }

    .kas-summary-card.solid {
        background: #198754;
        border-color: #198754;
        color: #ffffff;
    }

    .kas-summary-card.solid::before {
        display: none;
    }

    .kas-summary-label {
        margin-bottom: 12px;
        color: #6c757d;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .kas-summary-card.solid .kas-summary-label {
        color: rgba(255, 255, 255, 0.76);
    }

    .kas-summary-value {
        margin-bottom: 0;
        color: #198754;
        font-size: 36px;
        font-weight: 900;
        line-height: 1.1;
    }

    .kas-summary-card.danger .kas-summary-value {
        color: #dc3545;
    }

    .kas-summary-card.solid .kas-summary-value {
        color: #ffffff;
    }

    .kas-summary-icon {
        width: 52px;
        height: 52px;
        border-radius: 18px;
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 18px;
    }

    .kas-summary-card.danger .kas-summary-icon {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .kas-summary-card.solid .kas-summary-icon {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
    }

    .kas-history-card {
        margin-top: 44px;
        border-radius: 26px;
        background: #ffffff;
        border: 1px solid #e9ecef;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .kas-history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 28px 32px;
        border-bottom: 1px solid #e9ecef;
    }

    .kas-history-title {
        margin-bottom: 6px;
        color: #111827;
        font-size: 26px;
        font-weight: 800;
    }

    .kas-history-subtitle {
        margin-bottom: 0;
        color: #6c757d;
        font-size: 14px;
    }

    .kas-update-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 999px;
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .kas-table {
        width: 100%;
        margin-bottom: 0;
    }

    .kas-table th {
        padding: 18px 24px;
        color: #111827;
        background: #ffffff;
        border-bottom: 2px solid #e9ecef;
        font-size: 15px;
        font-weight: 850;
        white-space: nowrap;
    }

    .kas-table td {
        padding: 18px 24px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
        font-size: 15px;
    }

    .kas-table tr:last-child td {
        border-bottom: none;
    }

    .kas-date {
        color: #111827;
        white-space: nowrap;
    }

    .kas-note {
        color: #111827;
        font-weight: 600;
    }

    .kas-code {
        margin-top: 4px;
        color: #6c757d;
        font-size: 12px;
    }

    .kas-out {
        color: #dc3545;
        font-weight: 850;
        white-space: nowrap;
    }

    .kas-proof-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.25s ease;
    }

    .kas-proof-link:hover {
        color: #ffffff;
        background: #198754;
    }

    .kas-empty {
        padding: 70px 24px;
        text-align: center;
    }

    .kas-empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 22px;
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 18px;
    }

    .transparency-note {
        margin-top: 40px;
        padding: 28px;
        border-radius: 24px;
        background: #ffffff;
        border-left: 5px solid #198754;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    @media (max-width: 991px) {
        .kas-summary-grid {
            grid-template-columns: 1fr;
            margin-top: -40px;
        }

        .kas-history-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')

<div class="section-xl laporan-hero">
    <div class="container text-center pt-5">
        <h1 class="fw-normal text-white display-4">Laporan Keuangan</h1>
        <p class="text-white-50 mb-0">
            Transparansi penggunaan kas DKM AL HIKMAH secara terbuka.
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <div class="kas-summary-grid">
            <div class="kas-summary-card">
                <div class="kas-summary-icon">
                    <i class="fas fa-wallet"></i>
                </div>

                <div class="kas-summary-label">
                    Saldo Kas Saat Ini
                </div>

                <h2 class="kas-summary-value">
                    Rp {{ number_format($kasBalance ?? 0, 0, ',', '.') }}
                </h2>
            </div>

            <div class="kas-summary-card danger">
                <div class="kas-summary-icon">
                    <i class="fas fa-arrow-up-right-from-square"></i>
                </div>

                <div class="kas-summary-label">
                    Total Kas Terpakai
                </div>

                <h2 class="kas-summary-value">
                    Rp {{ number_format($totalKeluar ?? 0, 0, ',', '.') }}
                </h2>
            </div>

            <div class="kas-summary-card solid">
                <div class="kas-summary-icon">
                    <i class="fas fa-circle-check"></i>
                </div>

                <div class="kas-summary-label">
                    Transaksi Tercatat
                </div>

                <h2 class="kas-summary-value">
                    {{ ($transactions ?? collect())->count() }}
                </h2>
            </div>
        </div>

        <div class="kas-history-card">
            <div class="kas-history-header">
                <div>
                    <h3 class="kas-history-title">
                        Riwayat Penggunaan Kas
                    </h3>

                    <p class="kas-history-subtitle">
                        Hanya menampilkan transaksi kas keluar yang sudah disetujui.
                    </p>
                </div>

                <span class="kas-update-badge">
                    <i class="fas fa-clock"></i>
                    Update: {{ $lastUpdate ?? '-' }}
                </span>
            </div>

            @if(($transactions ?? collect())->count())
                <div class="table-responsive">
                    <table class="table kas-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th class="text-end">Kas Keluar</th>
                                <th class="text-center">Bukti</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($transactions as $trx)
                                @php
                                    $approvedAt = $trx['approved_at'] ?? $trx['requested_at'] ?? '-';
                                    $amount = (float) ($trx['amount'] ?? 0);
                                    $note = $trx['note'] ?? 'Penggunaan kas';
                                    $code = $trx['transaction_code'] ?? '-';
                                    $evidence = $trx['approval_evidence'] ?? '';
                                @endphp

                                <tr>
                                    <td class="kas-date">
                                        {{ $approvedAt }}
                                    </td>

                                    <td>
                                        <div class="kas-note">
                                            {{ $note }}
                                        </div>

                                        <div class="kas-code">
                                            {{ $code }}
                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <span class="kas-out">
                                            Rp {{ number_format($amount, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if(! empty($evidence))
                                            <a href="{{ asset($evidence) }}"
                                               target="_blank"
                                               class="kas-proof-link">
                                                <i class="fas fa-paperclip"></i>
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="kas-empty">
                    <div class="kas-empty-icon">
                        <i class="fas fa-wallet"></i>
                    </div>

                    <h5 class="fw-bold mb-2">
                        Belum Ada Penggunaan Kas
                    </h5>

                    <p class="text-muted mb-0">
                        Riwayat penggunaan kas yang sudah disetujui akan muncul di halaman ini.
                    </p>
                </div>
            @endif
        </div>

        <div class="transparency-note">
            <div class="row align-items-center">
                <div class="col-md-1 text-center d-none d-md-block">
                    <i class="fas fa-info-circle text-success fa-2x"></i>
                </div>

                <div class="col-md-11">
                    <h5 class="fw-normal mb-1">Komitmen Transparansi</h5>

                    <p class="text-muted small mb-0">
                        Semua laporan penggunaan kas di atas berasal dari transaksi kas yang telah disetujui admin.
                        Jika Anda memiliki pertanyaan mengenai penggunaan dana, silakan hubungi pengurus melalui sekretariat masjid.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection