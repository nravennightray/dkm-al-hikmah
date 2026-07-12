@extends('admin.layout.app')

@section('title', 'Keuangan')
@section('page_title', 'Keuangan')
@section('page_subtitle', 'Kelola transaksi tabungan jamaah dan kas DKM AL HIKMAH')

@section('css')
<style>
    .keuangan-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 24px;
        border-radius: 24px;
        background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        border: 1px solid rgba(37, 99, 235, 0.12);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        margin-bottom: 24px;
    }

    .keuangan-eyebrow {
        display: inline-flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 6px 12px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .keuangan-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .keuangan-subtitle {
        max-width: 680px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .keuangan-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
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

    .keuangan-table {
        width: 100%;
    }

    .keuangan-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .keuangan-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #eef2f7;
    }

    .keuangan-table tr:last-child td {
        border-bottom: none;
    }

    .keuangan-table th.text-center,
    .keuangan-table td.text-center {
        text-align: center;
    }

    .trx-number {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
    }

    .trx-code {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        color: #0f172a;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .trx-main {
        min-width: 240px;
    }

    .trx-title {
        margin-bottom: 5px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        line-height: 1.35;
    }

    .trx-meta {
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .trx-note {
        max-width: 320px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .trx-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 7px 10px;
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

    .trx-action-deposit {
        background: #ecfdf5;
        color: #047857;
    }

    .trx-action-withdraw {
        background: #fff7ed;
        color: #c2410c;
    }

    .trx-action-expense {
        background: #fef2f2;
        color: #dc2626;
    }

    .trx-status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .trx-status-approved {
        background: #ecfdf5;
        color: #047857;
    }

    .trx-status-rejected {
        background: #fef2f2;
        color: #dc2626;
    }

    .trx-amount {
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        white-space: nowrap;
    }

    .trx-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
    }

    .trx-mini-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .trx-mini-btn i {
        font-size: 15px;
        line-height: 1;
    }

    .trx-mini-approve {
        color: #047857;
        background: #ecfdf5;
        border-color: rgba(4, 120, 87, 0.14);
    }

    .trx-mini-approve:hover {
        color: #ffffff;
        background: #047857;
        border-color: #047857;
    }

    .trx-mini-reject {
        color: #dc2626;
        background: #fef2f2;
        border-color: rgba(220, 38, 38, 0.12);
    }

    .trx-mini-reject:hover {
        color: #ffffff;
        background: #dc2626;
        border-color: #dc2626;
    }

    .trx-empty {
        padding: 56px 24px;
        text-align: center;
    }

    .trx-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 24px;
    }

    .keuangan-pagination {
        padding: 18px 20px;
        border-top: 1px solid #eef2f7;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .keuangan-pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
    }

    .keuangan-pagination-links {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .keuangan-page-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .keuangan-page-btn:hover {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
    }

    .keuangan-page-btn.active {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .keuangan-page-btn.disabled {
        color: #cbd5e1;
        background: #f8fafc;
        cursor: not-allowed;
    }

    .finance-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(7px);
    }

    .finance-modal-backdrop.show {
        display: flex;
    }

    .finance-modal {
        width: 100%;
        max-width: 500px;
        border-radius: 26px;
        background: #ffffff;
        padding: 28px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.28);
        animation: financeModalIn 0.18s ease-out;
    }

    .finance-modal-icon {
        width: 58px;
        height: 58px;
        margin-bottom: 16px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .finance-modal-icon-approve {
        background: #ecfdf5;
        color: #047857;
    }

    .finance-modal-icon-reject {
        background: #fef2f2;
        color: #dc2626;
    }

    .finance-modal-title {
        margin-bottom: 8px;
        color: #0f172a;
        font-size: 22px;
        font-weight: 850;
    }

    .finance-modal-text {
        margin-bottom: 18px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .finance-modal-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .finance-modal-summary div {
        padding: 14px;
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
    }

    .finance-modal-summary span {
        display: block;
        margin-bottom: 5px;
        color: #94a3b8;
        font-size: 12px;
        font-weight: 700;
    }

    .finance-modal-summary strong {
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
    }

    .finance-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .finance-modal-cancel,
    .finance-modal-confirm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .finance-modal-cancel {
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #475569;
    }

    .finance-modal-cancel:hover {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
    }

    .finance-modal-confirm-approve {
        border: 1px solid #047857;
        background: #047857;
        color: #ffffff;
    }

    .finance-modal-confirm-approve:hover {
        background: #065f46;
        border-color: #065f46;
    }

    .finance-modal-confirm-reject {
        border: 1px solid #dc2626;
        background: #dc2626;
        color: #ffffff;
    }

    .finance-modal-confirm-reject:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    @keyframes financeModalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(0.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @media (max-width: 576px) {
        .finance-modal-summary {
            grid-template-columns: 1fr;
        }

        .finance-modal-actions {
            flex-direction: column-reverse;
        }

        .finance-modal-cancel,
        .finance-modal-confirm {
            width: 100%;
        }
    }

    @keyframes rejectModalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(0.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @media (max-width: 768px) {
        .keuangan-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .keuangan-header-actions {
            justify-content: stretch;
        }

        .keuangan-header-actions a {
            width: 100%;
        }

        .keuangan-pagination {
            flex-direction: column;
            align-items: stretch;
        }

        .keuangan-pagination-links {
            justify-content: center;
            flex-wrap: wrap;
        }

        .keuangan-pagination-info {
            text-align: center;
        }
    }

    .finance-field {
        margin-top: 16px;
    }

    .finance-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
        color: #0f172a;
        font-size: 13px;
        font-weight: 850;
    }

    .finance-label span {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 700;
    }

    .finance-textarea {
        width: 100%;
        min-height: 110px;
        resize: vertical;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: #f8fafc;
        padding: 13px 14px;
        color: #0f172a;
        font-size: 14px;
        line-height: 1.6;
        outline: none;
        transition: all 0.2s ease;
    }

    .finance-textarea::placeholder {
        color: #94a3b8;
    }

    .finance-textarea:focus {
        background: #ffffff;
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
    }

    .finance-upload {
        position: relative;
    }

    .finance-upload-input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .finance-upload-box {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        min-height: 86px;
        padding: 16px;
        border: 1.5px dashed rgba(37, 99, 235, 0.35);
        border-radius: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .finance-upload-box:hover {
        border-color: #2563eb;
        background: #eff6ff;
        transform: translateY(-1px);
    }

    .finance-upload-icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        background: #dbeafe;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .finance-upload-title {
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        margin-bottom: 4px;
    }

    .finance-upload-text {
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .finance-upload-filename {
        display: none;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        background: #ecfdf5;
        color: #047857;
        font-size: 13px;
        font-weight: 800;
    }

    .finance-upload-filename.show {
        display: inline-flex;
    }

    .finance-upload-filename i {
        font-size: 15px;
    }

    .finance-modal .admin-form-help {
        margin-top: 8px;
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.5;
    }

    .finance-input,
    .finance-select {
        width: 100%;
        min-height: 44px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #f8fafc;
        padding: 10px 12px;
        color: #0f172a;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
    }

    .finance-input:focus,
    .finance-select:focus {
        background: #ffffff;
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
    }

    .finance-filter-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .finance-modal-confirm-export {
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #ffffff;
    }

    .finance-modal-confirm-export:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    .finance-modal-icon-export {
        background: #eff6ff;
        color: #2563eb;
    }

    @media (max-width: 576px) {
        .finance-filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

@php
    $currentRole = strtolower(session('sheet_user.role') ?? 'karyawan');
    $canApprove = in_array($currentRole, ['superadmin', 'admin'], true);
@endphp

<div class="keuangan-page-header">
    <div>
        <span class="keuangan-eyebrow">
            Transaksi Tabungan
        </span>

        <h3 class="keuangan-title">
            Riwayat Keuangan
        </h3>

        <p class="keuangan-subtitle">
            Pantau transaksi setor, ambil tabungan, dan penggunaan kas DKM. Transaksi pending perlu disetujui admin sebelum saldo berubah.
        </p>
    </div>

    <div class="keuangan-header-actions">
        <button type="button"
                class="admin-btn-light"
                id="openExportModalBtn">
            <i class="bi bi-file-earmark-excel"></i>
            Export Excel
        </button>

        <a href="{{ route('admin.keuangan.deposit.create') }}" class="admin-btn-blue">
            <i class="bi bi-plus-lg"></i>
            Setor
        </a>

        <a href="{{ route('admin.keuangan.withdraw.create') }}" class="admin-btn-light">
            <i class="bi bi-arrow-down-circle"></i>
            Ambil
        </a>

        @if($canApprove)
            <a href="{{ route('admin.keuangan.kas.expense.create') }}" class="admin-btn-light">
                <i class="bi bi-cash-coin"></i>
                Kas Keluar
            </a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 mb-4">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-0 rounded-4 mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ session('error') }}
    </div>
@endif

<div class="admin-card overflow-hidden">
    @if(($transactions ?? collect())->count())

        <div class="table-responsive">
            <table class="table keuangan-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 70px;">No</th>
                        <th>Kode</th>
                        <th>Transaksi</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Aksi</th>
                        <th class="text-end">Nominal</th>
                        <th class="text-center">Status</th>
                        <th>Catatan</th>
                        <th class="text-center" style="width: 130px;">Approval</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transactions as $trx)
                        @php
                            $idTransaction = $trx['id_transaction'] ?? null;
                            $code = $trx['transaction_code'] ?? '-';
                            $requestedBy = $trx['requested_by_name'] ?? '-';
                            $targetUser = $trx['target_user_name'] ?? '-';
                            $fundType = strtolower($trx['fund_type'] ?? '-');
                            $actionType = strtolower($trx['action_type'] ?? '-');
                            $amount = (float) ($trx['amount'] ?? 0);
                            $status = strtolower($trx['status'] ?? 'pending');
                            $note = $trx['note'] ?? '-';
                            $adminNote = $trx['admin_note'] ?? '';
                            $requestedAt = $trx['requested_at'] ?? '-';

                            $actionLabel = match ($actionType) {
                                'deposit' => 'Setor',
                                'withdraw' => 'Ambil',
                                'expense' => 'Kas Keluar',
                                default => ucfirst($actionType),
                            };

                            $fundLabel = match ($fundType) {
                                'qurban' => 'Qurban',
                                'umrah' => 'Umrah',
                                'kas' => 'Kas',
                                default => ucfirst($fundType),
                            };
                        @endphp

                        <tr>
                            <td class="text-center">
                                <span class="trx-number">
                                    {{ method_exists($transactions, 'firstItem') ? $transactions->firstItem() + $loop->index : $loop->iteration }}
                                </span>
                            </td>

                            <td>
                                <span class="trx-code">
                                    {{ $code }}
                                </span>
                            </td>

                            <td>
                                <div class="trx-main">
                                    <div class="trx-title">
                                        {{ $actionLabel }} {{ $fundLabel }}
                                    </div>

                                    <div class="trx-meta">
                                        Request: {{ $requestedBy }}<br>
                                        Target: {{ $targetUser ?: '-' }}<br>
                                        {{ $requestedAt }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="trx-badge trx-fund-{{ $fundType }}">
                                    <i class="bi bi-wallet2"></i>
                                    {{ $fundLabel }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="trx-badge trx-action-{{ $actionType }}">
                                    @if($actionType === 'deposit')
                                        <i class="bi bi-arrow-up-circle"></i>
                                    @elseif($actionType === 'withdraw')
                                        <i class="bi bi-arrow-down-circle"></i>
                                    @else
                                        <i class="bi bi-cash"></i>
                                    @endif

                                    {{ $actionLabel }}
                                </span>
                            </td>

                            <td class="text-end">
                                <span class="trx-amount">
                                    Rp {{ number_format($amount, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="trx-badge trx-status-{{ $status }}">
                                    @if($status === 'approved')
                                        <i class="bi bi-check-circle"></i>
                                    @elseif($status === 'rejected')
                                        <i class="bi bi-x-circle"></i>
                                    @else
                                        <i class="bi bi-clock"></i>
                                    @endif

                                    {{ $status }}
                                </span>
                            </td>

                            <td>
                                <div class="trx-note">
                                    {{ $note ?: '-' }}

                                    @if($adminNote)
                                        <br>
                                        <strong>Admin:</strong> {{ $adminNote }}
                                    @endif

                                    @if(! empty($trx['approval_evidence'] ?? null))
                                        <br>
                                        <a href="{{ asset($trx['approval_evidence']) }}"
                                        target="_blank"
                                        class="fw-bold text-decoration-none">
                                            <i class="bi bi-paperclip"></i>
                                            Lihat Bukti
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <td class="text-center">
                                @if($canApprove && $status === 'pending' && $idTransaction)
                                    <div class="trx-action-group">
                                        <button type="button"
                                                class="trx-mini-btn trx-mini-approve approve-trigger"
                                                title="Setujui"
                                                data-action="{{ route('admin.keuangan.approve', $idTransaction) }}"
                                                data-code="{{ $code }}"
                                                data-title="{{ $actionLabel }} {{ $fundLabel }}"
                                                data-amount="Rp {{ number_format($amount, 0, ',', '.') }}">
                                            <i class="bi bi-check-lg"></i>
                                        </button>

                                        <button type="button"
                                                class="trx-mini-btn trx-mini-reject reject-trigger"
                                                title="Tolak"
                                                data-action="{{ route('admin.keuangan.reject', $idTransaction) }}"
                                                data-code="{{ $code }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
            <div class="keuangan-pagination">
                <div class="keuangan-pagination-info">
                    Menampilkan {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }}
                    dari {{ $transactions->total() }} transaksi
                </div>

                <div class="keuangan-pagination-links">
                    @if($transactions->onFirstPage())
                        <span class="keuangan-page-btn disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $transactions->previousPageUrl() }}" class="keuangan-page-btn">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @foreach($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                        @if($page == $transactions->currentPage())
                            <span class="keuangan-page-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="keuangan-page-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($transactions->hasMorePages())
                        <a href="{{ $transactions->nextPageUrl() }}" class="keuangan-page-btn">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="keuangan-page-btn disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    @else
        <div class="trx-empty">
            <div class="trx-empty-icon">
                <i class="bi bi-wallet2"></i>
            </div>

            <h5 class="fw-bold mb-2">
                Belum ada transaksi
            </h5>

            <p class="text-muted mb-4">
                Transaksi setor, ambil tabungan, dan kas keluar akan muncul di sini.
            </p>

            <a href="{{ route('admin.keuangan.deposit.create') }}" class="admin-btn-blue">
                <i class="bi bi-plus-lg"></i>
                Buat Transaksi Pertama
            </a>
        </div>
    @endif
</div>

<div class="finance-modal-backdrop" id="exportModalBackdrop">
    <div class="finance-modal">
        <div class="finance-modal-icon finance-modal-icon-export">
            <i class="bi bi-file-earmark-excel"></i>
        </div>

        <h4 class="finance-modal-title">
            Export Laporan Excel
        </h4>

        <p class="finance-modal-text">
            Pilih filter laporan. Jika tanggal dikosongkan, sistem akan memakai periode bulan berjalan.
        </p>

        <form action="{{ route('admin.keuangan.export') }}" method="GET" id="exportForm">
            <div class="finance-filter-grid">

                @if($canApprove)
                    <div class="finance-field">
                        <label for="export_target_user_id" class="finance-label">
                            Karyawan
                            <span>Opsional</span>
                        </label>

                        <select id="export_target_user_id"
                                name="target_user_id"
                                class="finance-select">
                            <option value="all">Semua Karyawan & Kas</option>

                            @foreach(($exportUsers ?? collect()) as $user)
                                <option value="{{ $user['id_user'] ?? '' }}">
                                    {{ $user['name'] ?? '-' }} — {{ $user['email'] ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="finance-field">
                    <label for="export_start_date" class="finance-label">
                        Dari Tanggal
                    </label>

                    <input type="date"
                           id="export_start_date"
                           name="start_date"
                           class="finance-input"
                           value="">
                </div>

                <div class="finance-field">
                    <label for="export_end_date" class="finance-label">
                        Sampai Tanggal
                    </label>

                    <input type="date"
                           id="export_end_date"
                           name="end_date"
                           class="finance-input"
                           value="">
                </div>

                <div class="finance-field">
                    <label for="export_fund_type" class="finance-label">
                        Jenis Dana
                        <span>Opsional</span>
                    </label>

                    <select id="export_fund_type"
                            name="fund_type"
                            class="finance-select">
                        <option value="">Semua</option>
                        <option value="qurban">Qurban</option>
                        <option value="umrah">Umrah</option>
                        <option value="kas">Kas</option>
                    </select>
                </div>

                <div class="finance-field">
                    <label for="export_status" class="finance-label">
                        Status
                        <span>Opsional</span>
                    </label>

                    <select id="export_status"
                            name="status"
                            class="finance-select">
                        <option value="">Semua</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <div class="finance-modal-actions">
                <button type="button" class="finance-modal-cancel" data-close-modal>
                    Batal
                </button>

                <button type="submit" class="finance-modal-confirm finance-modal-confirm-export">
                    <i class="bi bi-download"></i>
                    Download Excel
                </button>
            </div>
        </form>
    </div>
</div>

<div class="finance-modal-backdrop" id="approveModalBackdrop">
    <div class="finance-modal">
        <div class="finance-modal-icon finance-modal-icon-approve">
            <i class="bi bi-check-circle"></i>
        </div>

        <h4 class="finance-modal-title">
            Setujui Transaksi?
        </h4>

        <p class="finance-modal-text">
            Transaksi <strong id="approveTransactionCode">ini</strong> akan disetujui dan saldo akan langsung diperbarui.
        </p>

        <div class="finance-modal-summary">
            <div>
                <span>Jenis</span>
                <strong id="approveTransactionTitle">-</strong>
            </div>

            <div>
                <span>Nominal</span>
                <strong id="approveTransactionAmount">-</strong>
            </div>
        </div>

        <form action="#"
              method="POST"
              enctype="multipart/form-data"
              id="approveForm">
            @csrf

            <div class="finance-field">
                <label for="approve_admin_note" class="finance-label">
                    Catatan Admin
                    <span>Opsional</span>
                </label>

                <textarea id="approve_admin_note"
                        name="admin_note"
                        rows="3"
                        class="finance-textarea"
                        placeholder="Contoh: Bukti pembayaran valid."></textarea>
                </div>

                <div class="finance-field">
                    <label for="approval_evidence" class="finance-label">
                        Bukti / Receipt
                        <span>Wajib</span>
                    </label>

                    <div class="finance-upload">
                        <input type="file"
                            id="approval_evidence"
                            name="approval_evidence"
                            class="finance-upload-input"
                            accept=".jpg,.jpeg,.png,.webp,.pdf"
                            required>

                        <label for="approval_evidence" class="finance-upload-box">
                            <span class="finance-upload-icon">
                                <i class="bi bi-cloud-arrow-up"></i>
                            </span>

                            <span>
                                <span class="finance-upload-title">
                                    Upload bukti approval
                                </span>

                                <span class="finance-upload-text">
                                    Klik untuk memilih file JPG, PNG, WebP, atau PDF. Maksimal 4MB.
                                </span>
                            </span>
                        </label>

                        <div class="finance-upload-filename" id="approvalEvidenceName">
                            <i class="bi bi-paperclip"></i>
                            <span>Belum ada file dipilih</span>
                        </div>
                    </div>
                </div>

            <div class="finance-modal-actions">
                <button type="button" class="finance-modal-cancel" data-close-modal>
                    Batal
                </button>

                <button type="submit" class="finance-modal-confirm finance-modal-confirm-approve">
                    <i class="bi bi-check-lg"></i>
                    Setujui
                </button>
            </div>
        </form>
    </div>
</div>

<div class="finance-modal-backdrop" id="rejectModalBackdrop">
    <div class="finance-modal">
        <div class="finance-modal-icon finance-modal-icon-reject">
            <i class="bi bi-x-circle"></i>
        </div>

        <h4 class="finance-modal-title">
            Tolak Transaksi?
        </h4>

        <p class="finance-modal-text">
            Transaksi <strong id="rejectTransactionCode">ini</strong> akan ditandai sebagai rejected.
            Saldo tidak akan berubah.
        </p>

        <form action="#" method="POST" id="rejectForm">
            @csrf

            <div class="finance-field">
                <label for="reject_admin_note" class="finance-label">
                    Alasan Penolakan
                    <span>Disarankan</span>
                </label>

                <textarea id="reject_admin_note"
                        name="admin_note"
                        rows="4"
                        class="finance-textarea"
                        placeholder="Contoh: Bukti pembayaran belum valid."></textarea>

                <div class="admin-form-help">
                    Opsional, tapi disarankan agar user tahu alasan transaksi ditolak.
                </div>
            </div>

            <div class="finance-modal-actions">
                <button type="button" class="finance-modal-cancel" data-close-modal>
                    Batal
                </button>

                <button type="submit" class="finance-modal-confirm finance-modal-confirm-reject">
                    <i class="bi bi-x-lg"></i>
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    const approvalEvidenceInput = document.getElementById('approval_evidence');
    const approvalEvidenceName = document.getElementById('approvalEvidenceName');

    const openExportModalBtn = document.getElementById('openExportModalBtn');

    const exportModalBackdrop = document.getElementById('exportModalBackdrop');
    const approveModalBackdrop = document.getElementById('approveModalBackdrop');
    const rejectModalBackdrop = document.getElementById('rejectModalBackdrop');

    const approveForm = document.getElementById('approveForm');
    const rejectForm = document.getElementById('rejectForm');

    const approveTransactionCode = document.getElementById('approveTransactionCode');
    const approveTransactionTitle = document.getElementById('approveTransactionTitle');
    const approveTransactionAmount = document.getElementById('approveTransactionAmount');

    const rejectTransactionCode = document.getElementById('rejectTransactionCode');

    function resetApprovalEvidenceName() {
        if (!approvalEvidenceName) {
            return;
        }

        approvalEvidenceName.classList.remove('show');

        const filenameText = approvalEvidenceName.querySelector('span');

        if (filenameText) {
            filenameText.textContent = 'Belum ada file dipilih';
        }
    }

    function closeFinanceModals() {
        if (exportModalBackdrop) {
            exportModalBackdrop.classList.remove('show');
        }

        if (approveModalBackdrop) {
            approveModalBackdrop.classList.remove('show');
        }

        if (rejectModalBackdrop) {
            rejectModalBackdrop.classList.remove('show');
        }

        if (approveForm) {
            approveForm.action = '#';
            approveForm.reset();
            resetApprovalEvidenceName();
        }

        if (rejectForm) {
            rejectForm.action = '#';
            rejectForm.reset();
        }
    }

    if (openExportModalBtn && exportModalBackdrop) {
        openExportModalBtn.addEventListener('click', function () {
            exportModalBackdrop.classList.add('show');
        });
    }

    document.querySelectorAll('.approve-trigger').forEach((button) => {
        button.addEventListener('click', function () {
            if (!approveForm || !approveModalBackdrop) {
                return;
            }

            approveForm.action = this.dataset.action || '#';

            if (approveTransactionCode) {
                approveTransactionCode.textContent = this.dataset.code || 'ini';
            }

            if (approveTransactionTitle) {
                approveTransactionTitle.textContent = this.dataset.title || '-';
            }

            if (approveTransactionAmount) {
                approveTransactionAmount.textContent = this.dataset.amount || '-';
            }

            resetApprovalEvidenceName();

            approveModalBackdrop.classList.add('show');
        });
    });

    document.querySelectorAll('.reject-trigger').forEach((button) => {
        button.addEventListener('click', function () {
            if (!rejectForm || !rejectModalBackdrop) {
                return;
            }

            rejectForm.action = this.dataset.action || '#';

            if (rejectTransactionCode) {
                rejectTransactionCode.textContent = this.dataset.code || 'ini';
            }

            rejectModalBackdrop.classList.add('show');
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach((button) => {
        button.addEventListener('click', closeFinanceModals);
    });

    [exportModalBackdrop, approveModalBackdrop, rejectModalBackdrop].forEach((backdrop) => {
        if (!backdrop) {
            return;
        }

        backdrop.addEventListener('click', function (event) {
            if (event.target === backdrop) {
                closeFinanceModals();
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeFinanceModals();
        }
    });

    if (approvalEvidenceInput && approvalEvidenceName) {
        approvalEvidenceInput.addEventListener('change', function () {
            const file = this.files && this.files.length ? this.files[0] : null;
            const filenameText = approvalEvidenceName.querySelector('span');

            if (!file) {
                resetApprovalEvidenceName();
                return;
            }

            approvalEvidenceName.classList.add('show');

            if (filenameText) {
                filenameText.textContent = file.name;
            }
        });
    }
</script>
@endsection