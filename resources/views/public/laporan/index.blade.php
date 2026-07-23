@extends('master.layout.app')

@section('title', 'Laporan Keuangan - DKM Al Hikmah')

@section('css')
<style>
    .laporan-hero {
        background: linear-gradient(
            180deg,
            rgba(30, 64, 175, 0.98) 0%,
            rgba(37, 99, 235, 0.95) 55%,
            rgba(14, 165, 233, 0.92) 100%
        );
    }

    .laporan-breadcrumb {
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

    .laporan-breadcrumb a {
        color: #ffffff;
        text-decoration: none;
    }

    .laporan-breadcrumb a:hover {
        text-decoration: underline;
    }

    .kas-summary-grid {
        display: grid;
        gap: 24px;
        margin-top: -70px;
        position: relative;
        z-index: 2;
    }

    .kas-summary-grid.summary-count-1 {
        grid-template-columns: 1fr;
    }

    .kas-summary-grid.summary-count-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .kas-summary-grid.summary-count-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .kas-summary-grid.summary-count-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
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

    .kas-summary-grid.summary-count-4 .kas-summary-card {
        padding: 24px;
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
        word-break: break-word;
    }

    .kas-summary-grid.summary-count-4 .kas-summary-value {
        font-size: 28px;
    }

    .kas-summary-card.danger .kas-summary-value {
        color: #dc3545;
    }

    .kas-summary-card.solid .kas-summary-value {
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
        line-height: 1.7;
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

    .kas-in {
        color: #198754;
        font-weight: 850;
        white-space: nowrap;
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

    @media (max-width: 1199px) {
        .kas-summary-grid.summary-count-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .kas-summary-grid,
        .kas-summary-grid.summary-count-1,
        .kas-summary-grid.summary-count-2,
        .kas-summary-grid.summary-count-3,
        .kas-summary-grid.summary-count-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin-top: -40px;
        }

        .kas-history-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 767px) {
        .kas-summary-grid,
        .kas-summary-grid.summary-count-1,
        .kas-summary-grid.summary-count-2,
        .kas-summary-grid.summary-count-3,
        .kas-summary-grid.summary-count-4 {
            grid-template-columns: 1fr;
        }

        .kas-summary-value {
            font-size: 30px;
        }

        .kas-summary-grid.summary-count-4 .kas-summary-value {
            font-size: 30px;
        }
    }
</style>
@endsection

@section('content')

@php
    $summaryCards = $summaryCards ?? [];
    $transactions = $transactions ?? collect();
    $summaryCount = count($summaryCards);
@endphp

<div class="section-xl laporan-hero">
    <div class="container text-center pt-5">
        <div class="laporan-breadcrumb">
            <a href="{{ url('/') }}">
                Beranda
            </a>

            <i class="fas fa-chevron-right small"></i>

            <span>
                Laporan Keuangan
            </span>
        </div>

        <h1 class="fw-normal text-white display-4">
            {{ $pageTitle ?? 'Laporan Keuangan' }}
        </h1>

        <p class="text-white-50 mb-0">
            {{ $pageSubtitle ?? 'Transparansi penggunaan kas DKM AL HIKMAH secara terbuka.' }}
        </p>
    </div>
</div>

<div class="section bg-light-gray">
    <div class="container">

        <div class="kas-summary-grid summary-count-{{ $summaryCount }}">
            @foreach($summaryCards as $card)
                <div class="kas-summary-card {{ $card['class'] ?? '' }}">
                    <div class="kas-summary-icon">
                        <i class="{{ $card['icon'] ?? 'fas fa-wallet' }}"></i>
                    </div>

                    <div class="kas-summary-label">
                        {{ $card['label'] ?? '-' }}
                    </div>

                    <h2 class="kas-summary-value">
                        {{ $card['value'] ?? '0' }}
                    </h2>
                </div>
            @endforeach
        </div>

        <div class="kas-history-card">
            <div class="kas-history-header">
                <div>
                    <h3 class="kas-history-title">
                        {{ $tableTitle ?? 'Riwayat Transaksi' }}
                    </h3>

                    <p class="kas-history-subtitle">
                        {{ $tableSubtitle ?? 'Menampilkan transaksi keuangan yang tercatat.' }}
                    </p>
                </div>

                <span class="kas-update-badge">
                    <i class="fas fa-clock"></i>
                    Update: {{ $lastUpdate ?? '-' }}
                </span>
            </div>

            @if($transactions->count())
                <div class="table-responsive">
                    <table class="table kas-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Dana</th>
                                <th>Aksi</th>
                                <th>Keterangan</th>
                                <th class="text-end">Nominal</th>
                                <th class="text-center">Bukti</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($transactions as $trx)
                                @php
                                    $date = $trx['requested_at'] ?? $trx['created_at'] ?? $trx['approved_at'] ?? '-';
                                    $amount = (float) ($trx['amount'] ?? 0);

                                    $fundType = strtolower($trx['fund_type'] ?? '-');
                                    $actionType = strtolower($trx['action_type'] ?? '-');

                                    $note = $trx['note'] ?? 'Transaksi keuangan';
                                    $code = $trx['transaction_code'] ?? '-';
                                    $evidence = $trx['approval_evidence'] ?? '';

                                    $isOut = in_array($actionType, ['withdraw', 'expense'], true);

                                    $fundLabels = [
                                        'kas' => 'Kas',
                                        'qurban' => 'Qurban',
                                        'umrah' => 'Umrah',
                                        'infaq' => 'Infaq',
                                    ];

                                    $actionLabels = [
                                        'deposit' => 'Setor',
                                        'withdraw' => 'Ambil',
                                        'expense' => 'Kas Keluar',
                                        'salary_deduction' => 'Potong Gaji',
                                    ];

                                    $fundLabel = $fundLabels[$fundType] ?? ucfirst($fundType);
                                    $actionLabel = $actionLabels[$actionType] ?? ucfirst(str_replace('_', ' ', $actionType));
                                @endphp

                                <tr>
                                    <td class="kas-date">
                                        {{ $date }}
                                    </td>

                                    <td>
                                        <strong>{{ $fundLabel }}</strong>
                                    </td>

                                    <td>
                                        {{ $actionLabel }}
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
                                        <span class="{{ $isOut ? 'kas-out' : 'kas-in' }}">
                                            {{ $isOut ? '-' : '+' }}
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
                                            <span class="text-muted small">
                                                -
                                            </span>
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
                        Belum Ada Transaksi
                    </h5>

                    <p class="text-muted mb-0">
                        Riwayat transaksi akan muncul di halaman ini setelah tersedia.
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
                    <h5 class="fw-normal mb-1">
                        Komitmen Transparansi
                    </h5>

                    <p class="text-muted small mb-0">
                        @if(($viewMode ?? 'public') === 'public')
                            Semua laporan penggunaan kas di atas berasal dari transaksi kas yang telah disetujui admin.
                        @elseif(($viewMode ?? 'public') === 'karyawan')
                            Data yang ditampilkan merupakan ringkasan transaksi keuangan milik akun Anda.
                        @else
                            Data yang ditampilkan merupakan ringkasan seluruh transaksi keuangan yang tercatat di sistem.
                        @endif

                        Jika Anda memiliki pertanyaan mengenai penggunaan dana, silakan hubungi pengurus melalui sekretariat masjid.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection