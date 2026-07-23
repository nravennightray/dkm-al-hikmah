@extends('admin.layout.app')

@section('title', 'Dashboard')
@section('page_title', $isAdmin ? 'Dashboard Admin' : 'Dashboard Keuangan')
@section('page_subtitle', $isAdmin ? 'Ringkasan keuangan dan aktivitas DKM AL HIKMAH' : 'Ringkasan tabungan dan transaksi kamu')

@section('css')
<style>
    .finance-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .finance-summary-card {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 26px;
        min-height: 160px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
    }

    .finance-summary-card::before {
        content: "";
        position: absolute;
        inset: 0 auto 0 0;
        width: 7px;
        background: #2563eb;
    }

    .finance-summary-card.green::before {
        background: #15803d;
    }

    .finance-summary-card.orange::before {
        background: #f97316;
    }

    .finance-summary-card.blue::before {
        background: #2563eb;
    }

    .finance-summary-card.solid {
        background: #1f8f5a;
        border-color: #1f8f5a;
        color: #ffffff;
    }

    .finance-summary-card.solid::before {
        display: none;
    }

    .finance-summary-icon {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 20px;
    }

    .finance-summary-card.green .finance-summary-icon {
        background: #ecfdf5;
        color: #15803d;
    }

    .finance-summary-card.orange .finance-summary-icon {
        background: #fff7ed;
        color: #f97316;
    }

    .finance-summary-card.solid .finance-summary-icon {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
    }

    .finance-summary-label {
        margin-bottom: 8px;
        color: #64748b;
        font-size: 13px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .finance-summary-card.solid .finance-summary-label {
        color: rgba(255, 255, 255, 0.78);
    }

    .finance-summary-value {
        color: #0f172a;
        font-size: 32px;
        font-weight: 900;
        line-height: 1.1;
    }

    .finance-summary-card.green .finance-summary-value {
        color: #15803d;
    }

    .finance-summary-card.orange .finance-summary-value {
        color: #c2410c;
    }

    .finance-summary-card.solid .finance-summary-value {
        color: #ffffff;
    }

    .finance-summary-help {
        margin-top: 10px;
        color: #94a3b8;
        font-size: 13px;
    }

    .finance-summary-card.solid .finance-summary-help {
        color: rgba(255, 255, 255, 0.72);
    }

    .dashboard-grid-2 {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(360px, 0.8fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .dashboard-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .dashboard-section-title {
        margin-bottom: 4px;
        color: #0f172a;
        font-size: 19px;
        font-weight: 900;
    }

    .dashboard-section-subtitle {
        margin-bottom: 0;
        color: #64748b;
        font-size: 13px;
    }

    .finance-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .finance-tab-btn {
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        background: #ffffff;
        color: #64748b;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .finance-tab-btn.active,
    .finance-tab-btn:hover {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .finance-tab-panel {
        display: none;
    }

    .finance-tab-panel.active {
        display: block;
    }

    .finance-table {
        width: 100%;
    }

    .finance-table th {
        padding: 13px 14px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        font-size: 12px;
        font-weight: 850;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .finance-table td {
        padding: 14px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
        font-size: 13px;
    }

    .finance-table tr:last-child td {
        border-bottom: none;
    }

    .trx-title {
        color: #0f172a;
        font-weight: 850;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .trx-meta {
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .trx-meta {
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }

    .trx-amount.plus {
        color: #047857;
    }

    .trx-amount.minus {
        color: #dc2626;
    }

    .trx-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .trx-fund-qurban {
        background: #fef3c7;
        color: #92400e;
    }

    .trx-fund-umrah {
        background: #eff6ff;
        color: #2563eb;
    }

    .trx-fund-kas {
        background: #f0fdf4;
        color: #15803d;
    }

    .trx-fund-infaq {
        background: #fdf2f8;
        color: #be185d;
    }

    .pending-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .pending-card {
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        padding: 16px;
    }

    .pending-code {
        display: inline-flex;
        margin-bottom: 8px;
        padding: 5px 9px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        color: #2563eb;
        font-size: 12px;
        font-weight: 850;
    }

    .pending-title {
        color: #0f172a;
        font-size: 14px;
        font-weight: 900;
        margin-bottom: 6px;
    }

    .pending-meta {
        color: #64748b;
        font-size: 12px;
        line-height: 1.6;
    }

    .pending-amount {
        margin-top: 10px;
        color: #0f172a;
        font-size: 18px;
        font-weight: 900;
    }

    .admin-btn-light {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #ffffff;
        color: #475569;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .admin-btn-light:hover {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
    }

    .dashboard-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .dashboard-stat {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .dashboard-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .category-mini-card {
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 18px;
        height: 100%;
    }

    .category-mini-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    @media (max-width: 991px) {
        .finance-summary-grid,
        .dashboard-grid-2,
        .dashboard-grid-3,
        .category-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="finance-summary-grid">
    <div class="finance-summary-card green">
        <div class="finance-summary-icon">
            <i class="bi bi-piggy-bank"></i>
        </div>

        <div class="finance-summary-label">
            {{ $isAdmin ? 'Total Qurban' : 'Tabungan Qurban' }}
        </div>

        <div class="finance-summary-value">
            Rp {{ number_format($financeStats['qurban'] ?? 0, 0, ',', '.') }}
        </div>

        <div class="finance-summary-help">
            {{ $isAdmin ? 'Akumulasi semua jamaah' : 'Saldo qurban kamu saat ini' }}
        </div>
    </div>

    <div class="finance-summary-card orange">
        <div class="finance-summary-icon">
            <i class="bi bi-airplane"></i>
        </div>

        <div class="finance-summary-label">
            {{ $isAdmin ? 'Total Umrah' : 'Tabungan Umrah' }}
        </div>

        <div class="finance-summary-value">
            Rp {{ number_format($financeStats['umrah'] ?? 0, 0, ',', '.') }}
        </div>

        <div class="finance-summary-help">
            {{ $isAdmin ? 'Akumulasi semua jamaah' : 'Saldo umrah kamu saat ini' }}
        </div>
    </div>

    @if($isAdmin)
    <div class="finance-summary-card solid">
        <div class="finance-summary-icon">
            <i class="bi bi-cash-coin"></i>
        </div>

        <div class="finance-summary-label">
            Kas DKM
        </div>

        <div class="finance-summary-value">
            Rp {{ number_format($financeStats['kas'] ?? 0, 0, ',', '.') }}
        </div>

        <div class="finance-summary-help">
            Saldo kas aktif
        </div>
    </div>
    @endif
</div>

@if($isAdmin)
    <div class="dashboard-grid-3">
        <div class="dashboard-stat p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted small mb-1">Total Kegiatan</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_kegiatans'] ?? 0 }}</h3>
                </div>

                <div class="dashboard-stat-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted small mb-1">Kategori</p>
                    <h3 class="fw-bold mb-0">{{ $stats['total_categories'] ?? 0 }}</h3>
                </div>

                <div class="dashboard-stat-icon">
                    <i class="bi bi-grid-3x3-gap"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-stat p-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-muted small mb-1">Pending Approval</p>
                    <h3 class="fw-bold mb-0">{{ $financeStats['pending_count'] ?? 0 }}</h3>
                </div>

                <div class="dashboard-stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="admin-card p-4 mb-4">
    <div class="dashboard-section-header">
        <div>
            <h5 class="dashboard-section-title">
                Riwayat Transaksi
            </h5>

            <p class="dashboard-section-subtitle">
                {{ $isAdmin  ? 'Monitoring seluruh transaksi tabungan, infaq, dan kas DKM.'  : 'Riwayat transaksi tabungan dan infaq kamu.' }}
            </p>
        </div>

        <a href="{{ route('admin.keuangan.index') }}" class="admin-btn-light">
            <i class="bi bi-arrow-right"></i>
            Detail
        </a>
    </div>

    <div class="finance-tabs">
        <button type="button" class="finance-tab-btn active" data-tab-target="all"> Semua </button>
        <button type="button" class="finance-tab-btn" data-tab-target="qurban"> Qurban </button>
        <button type="button" class="finance-tab-btn" data-tab-target="umrah"> Umrah </button>
        <button type="button" class="finance-tab-btn" data-tab-target="infaq"> Infaq  </button>
        @if($isAdmin)
            <button type="button" class="finance-tab-btn" data-tab-target="kas"> Kas </button>
        @endif
    </div>

    @foreach($financeTabs as $tabKey => $transactions)
        @if(in_array($tabKey, ['all','qurban','umrah','infaq','kas']))
            <div class="finance-tab-panel {{ $tabKey === 'all' ? 'active' : '' }}" data-tab-panel="{{ $tabKey }}">
                @if($transactions->count())
                    <div class="table-responsive">
                        <table class="table finance-table mb-0">
                            <thead>
                                <tr>
                                    <th> Transaksi </th>
                                    @if($isAdmin)
                                        <th>
                                            User
                                        </th>
                                    @endif
                                    <th class="text-center"> Jenis </th>
                                    <th> Tanggal </th>
                                    <th class="text-end"> Nominal </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($transactions->take(10) as $trx)
                                    @php
                                        $fundType = strtolower($trx['fund_type'] ?? '-');
                                        $actionType = strtolower($trx['action_type'] ?? '-');
                                        $amount = (float) ($trx['amount'] ?? 0);


                                        $actionLabel = match($actionType){
                                            'deposit' => 'Setor',
                                            'withdraw' => 'Ambil',
                                            'expense' => 'Kas Keluar',
                                            'salary_deduction' => 'Infaq',
                                            default => ucfirst(str_replace('_', ' ', $actionType))
                                        };

                                        $fundLabel = match($fundType){
                                            'qurban' => 'Qurban',
                                            'umrah' => 'Umrah',
                                            'infaq' => 'Infaq',
                                            'kas' => 'Kas',
                                            default => ucfirst($fundType)
                                        };

                                        $amountClass = in_array($actionType,['withdraw','expense']) ? 'minus' : 'plus';
                                        $amountPrefix = in_array($actionType,['withdraw','expense']) ? '-' : '+';
                                    @endphp

                                    <tr>
                                        <td>
                                            <div class="trx-title">
                                                {{ $actionLabel }}
                                                {{ $fundLabel }}
                                            </div>
                                            <div class="trx-meta">
                                                {{ $trx['transaction_code'] ?? '-' }}
                                            </div>
                                        </td>

                                        @if($isAdmin)
                                            <td>
                                                <div class="trx-title">
                                                    {{ $trx['target_user_name'] ?? '-' }}
                                                </div>
                                                <div class="trx-meta">
                                                    Request:
                                                    {{ $trx['requested_by_name'] ?? '-' }}
                                                </div>
                                            </td>
                                        @endif

                                        <td class="text-center">
                                            <span class="trx-badge trx-fund-{{ $fundType }}">
                                                {{ $fundLabel }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="trx-meta">
                                                {{ $trx['requested_at'] ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="trx-amount {{ $amountClass }}">
                                                {{ $amountPrefix }}
                                                Rp {{ number_format($amount,0,',','.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-wallet2 fs-2 text-primary"></i>
                        <p class="text-muted mt-3 mb-0">
                            Belum ada transaksi.
                        </p>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</div>

@if($isAdmin)
    <div class="admin-card p-4">
        <div class="dashboard-section-header">
            <div>
                <h5 class="dashboard-section-title">
                    Kategori Kegiatan
                </h5>

                <p class="dashboard-section-subtitle">
                    Kategori yang terdaftar di Google Sheet.
                </p>
            </div>
        </div>

        <div class="category-grid">
            @forelse($categories ?? [] as $category)
                <div class="category-mini-card">
                    <div class="d-flex align-items-start gap-3">
                        <div class="category-mini-icon">
                            <i class="bi bi-folder"></i>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-1">
                                {{ $category['name'] ?? '-' }}
                            </h6>

                            <p class="text-muted small mb-0">
                                {{ $category['desc'] ?? 'Tidak ada deskripsi.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">Belum ada kategori.</p>
            @endforelse
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.finance-tab-btn');
        const tabPanels = document.querySelectorAll('.finance-tab-panel');

        tabButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const target = button.getAttribute('data-tab-target');

                tabButtons.forEach(function (item) {
                    item.classList.remove('active');
                });

                tabPanels.forEach(function (panel) {
                    panel.classList.remove('active');
                });

                button.classList.add('active');

                const activePanel = document.querySelector('[data-tab-panel="' + target + '"]');

                if (activePanel) {
                    activePanel.classList.add('active');
                }
            });
        });
    });
</script>
@endsection