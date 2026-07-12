@extends('admin.layout.app')

@section('title', 'Ambil Tabungan')
@section('page_title', 'Ambil Tabungan')
@section('page_subtitle', 'Ajukan transaksi ambil tabungan qurban atau umrah')

@section('css')
<style>
    .form-page-header {
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

    .form-eyebrow {
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

    .form-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .form-subtitle {
        max-width: 680px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .admin-form-card {
        width: 100%;
    }

    .admin-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .admin-form-group-full {
        grid-column: 1 / -1;
    }

    .admin-form-label {
        display: block;
        margin-bottom: 8px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .admin-form-control {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #ffffff;
        padding: 12px 14px;
        color: #0f172a;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
    }

    .admin-form-control:focus {
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
    }

    textarea.admin-form-control {
        resize: vertical;
        min-height: 120px;
    }

    .admin-form-help {
        margin-top: 7px;
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.5;
    }

    .admin-error {
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
        font-weight: 700;
    }

    .keuangan-note {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        border-radius: 18px;
        background: #fff7ed;
        border: 1px solid rgba(249, 115, 22, 0.18);
        color: #475569;
        margin-bottom: 24px;
    }

    .keuangan-note i {
        color: #f97316;
        font-size: 20px;
        line-height: 1.2;
        flex-shrink: 0;
    }

    .keuangan-note-title {
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        margin-bottom: 4px;
    }

    .keuangan-note-text {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    .amount-preview {
        display: none;
        margin-top: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        background: #fff7ed;
        color: #c2410c;
        font-size: 13px;
        font-weight: 850;
    }

    .amount-preview.show {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .fund-option-help {
        margin-top: 10px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .fund-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
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

    @media (max-width: 768px) {
        .form-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .form-page-header .admin-btn-light {
            width: 100%;
        }

        .admin-form-grid {
            grid-template-columns: 1fr;
        }
    }

    .withdraw-balance-notice {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        border-radius: 18px;
        background: #eff6ff;
        border: 1px solid rgba(37, 99, 235, 0.16);
        color: #475569;
    }

    .withdraw-balance-notice.warning {
        background: #fff7ed;
        border-color: rgba(249, 115, 22, 0.20);
    }

    .withdraw-balance-notice.danger {
        background: #fef2f2;
        border-color: rgba(220, 38, 38, 0.18);
    }

    .withdraw-balance-notice i {
        color: #2563eb;
        font-size: 20px;
        line-height: 1.2;
        flex-shrink: 0;
    }

    .withdraw-balance-notice.warning i {
        color: #f97316;
    }

    .withdraw-balance-notice.danger i {
        color: #dc2626;
    }

    .withdraw-balance-title {
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        margin-bottom: 8px;
    }

    .withdraw-balance-text {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    .withdraw-balance-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        margin-top: 12px;
    }

    .withdraw-balance-pill {
        padding: 10px 12px;
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .withdraw-balance-pill span {
        display: block;
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .withdraw-balance-pill strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
    }

    @media (max-width: 768px) {
        .withdraw-balance-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="form-page-header">
    <div>
        <span class="form-eyebrow">
            Form Keuangan
        </span>

        <h3 class="form-title">
            Ambil Tabungan
        </h3>

        <p class="form-subtitle">
            Buat pengajuan ambil tabungan qurban atau umrah. Penarikan kas tidak tersedia untuk jamaah.
        </p>
    </div>

    <a href="{{ route('admin.keuangan.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card admin-form-card p-4">
    <div class="keuangan-note">
        <i class="bi bi-exclamation-circle"></i>

        <div>
            <div class="keuangan-note-title">
                Perlu Validasi Saldo
            </div>

            <p class="keuangan-note-text">
                Pengajuan ambil tabungan akan dicek berdasarkan saldo saat ini. Saldo baru akan berkurang setelah transaksi disetujui admin.
            </p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form id="withdrawForm" action="{{ route('admin.keuangan.withdraw.store') }}" method="POST">
        @csrf

        <div class="admin-form-grid">
            @php
                $currentRole = strtolower($currentRole ?? session('sheet_user.role') ?? 'karyawan');
                $canChooseUser = in_array($currentRole, ['superadmin', 'admin'], true);
                $currentUser = collect($users ?? [])->first();
            @endphp

            <div>
                <label for="target_user_id" class="admin-form-label">
                    Jamaah / Karyawan
                </label>

                @if($canChooseUser)
                    <select id="target_user_id"
                            name="target_user_id"
                            class="admin-form-control"
                            required>
                        <option value="">Pilih jamaah</option>

                        @foreach($users as $user)
                            <option value="{{ $user['id_user'] ?? '' }}"
                                @selected(old('target_user_id') == ($user['id_user'] ?? ''))>
                                {{ $user['name'] ?? '-' }} — {{ $user['email'] ?? '-' }}
                            </option>
                        @endforeach
                    </select>

                    <div class="admin-form-help">
                        Pilih jamaah atau karyawan yang ingin mengambil tabungan.
                    </div>
                @else
                    <input type="hidden"
                           id="target_user_id"
                           value="{{ $currentUser['id_user'] ?? session('sheet_user.id_user') ?? '' }}">

                    <input type="text"
                           class="admin-form-control"
                           value="{{ $currentUser['name'] ?? session('sheet_user.name') ?? 'User' }}"
                           readonly>

                    <div class="admin-form-help">
                        Pengajuan ini otomatis menggunakan akun kamu sendiri.
                    </div>
                @endif

                @error('target_user_id')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="fund_type" class="admin-form-label">
                    Jenis Tabungan
                </label>

                <select id="fund_type"
                        name="fund_type"
                        class="admin-form-control"
                        required>
                    <option value="">Pilih tabungan</option>

                    @foreach($fundTypes as $fundType)
                        <option value="{{ $fundType }}"
                            @selected(old('fund_type') === $fundType)>
                            {{ ucfirst($fundType) }}
                        </option>
                    @endforeach
                </select>

                <div class="fund-option-help">
                    <span class="fund-pill">
                        <i class="bi bi-wallet2"></i>
                        Qurban
                    </span>

                    <span class="fund-pill">
                        <i class="bi bi-airplane"></i>
                        Umrah
                    </span>
                </div>

                @error('fund_type')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <div class="withdraw-balance-notice" id="withdrawBalanceNotice">
                    <i class="bi bi-info-circle"></i>

                    <div>
                        <div class="withdraw-balance-title">
                            Informasi Saldo Tersedia
                        </div>

                        <p class="withdraw-balance-text" id="withdrawBalanceText">
                            Pilih jamaah dan jenis tabungan untuk melihat saldo yang dapat diambil.
                        </p>

                        <div class="withdraw-balance-grid d-none" id="withdrawBalanceGrid">
                            <div class="withdraw-balance-pill">
                                <span>Saldo Saat Ini</span>
                                <strong id="currentBalanceText">Rp 0</strong>
                            </div>

                            <div class="withdraw-balance-pill">
                                <span>Pending Ambil</span>
                                <strong id="pendingWithdrawText">Rp 0</strong>
                            </div>

                            <div class="withdraw-balance-pill">
                                <span>Saldo Tersedia</span>
                                <strong id="availableBalanceText">Rp 0</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- IMPORTANT: This is the missing nominal input --}}
            <div class="admin-form-group-full">
                <label for="amount" class="admin-form-label">
                    Nominal Ambil
                </label>

                <input type="number"
                       id="amount"
                       name="amount"
                       value="{{ old('amount') }}"
                       class="admin-form-control"
                       placeholder="Contoh: 50000"
                       min="1000"
                       step="1000"
                       required>

                <div class="amount-preview" id="amountPreview">
                    <i class="bi bi-cash"></i>
                    <span id="amountPreviewText">Rp 0</span>
                </div>

                <div class="admin-form-help">
                    Masukkan nominal angka tanpa titik atau koma. Minimal Rp 1.000.
                </div>

                @error('amount')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label for="note" class="admin-form-label">
                    Catatan
                </label>

                <textarea id="note"
                          name="note"
                          rows="4"
                          class="admin-form-control"
                          placeholder="Contoh: Ambil tabungan umrah untuk kebutuhan pribadi.">{{ old('note') }}</textarea>

                <div class="admin-form-help">
                    Opsional. Bisa diisi alasan atau keterangan pengambilan tabungan.
                </div>

                @error('note')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.keuangan.index') }}" class="admin-btn-light">
                Batal
            </a>

            <button type="submit" id="submitWithdrawBtn" class="admin-btn-blue">
                <i class="bi bi-send"></i>
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

@endsection

@section('script')
<script>
    const balanceSummary = @json($balanceSummary ?? []);

    const amountInput = document.getElementById('amount');
    const amountPreview = document.getElementById('amountPreview');
    const amountPreviewText = document.getElementById('amountPreviewText');

    const targetUserInput = document.getElementById('target_user_id');
    const fundTypeInput = document.getElementById('fund_type');

    const withdrawBalanceNotice = document.getElementById('withdrawBalanceNotice');
    const withdrawBalanceText = document.getElementById('withdrawBalanceText');
    const withdrawBalanceGrid = document.getElementById('withdrawBalanceGrid');

    const currentBalanceText = document.getElementById('currentBalanceText');
    const pendingWithdrawText = document.getElementById('pendingWithdrawText');
    const availableBalanceText = document.getElementById('availableBalanceText');

    let selectedAvailableBalance = null;
    let selectedBalanceKnown = false;

    function formatRupiah(value) {
        const number = Number(value || 0);

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(number);
    }

    function getSelectedBalanceData() {
        const userId = targetUserInput ? targetUserInput.value : '';
        const fundType = fundTypeInput ? fundTypeInput.value : '';

        if (!userId || !fundType) {
            return null;
        }

        if (!balanceSummary[userId] || !balanceSummary[userId][fundType]) {
            return {
                known: false,
                current_balance: 0,
                pending_withdraw: 0,
                available_balance: 0
            };
        }

        return balanceSummary[userId][fundType];
    }

    function updateBalanceNotice() {
        const data = getSelectedBalanceData();

        if (!withdrawBalanceNotice || !withdrawBalanceText || !withdrawBalanceGrid) {
            return;
        }

        withdrawBalanceNotice.classList.remove('warning', 'danger');

        if (!data) {
            selectedAvailableBalance = null;
            selectedBalanceKnown = false;

            withdrawBalanceText.textContent = 'Pilih jamaah dan jenis tabungan untuk melihat saldo yang dapat diambil.';
            withdrawBalanceGrid.classList.add('d-none');

            updateAmountPreview();
            return;
        }

        selectedBalanceKnown = data.known !== false;

        const currentBalance = Number(data.current_balance || 0);
        const pendingWithdraw = Number(data.pending_withdraw || 0);
        const availableBalance = Number(data.available_balance || 0);

        selectedAvailableBalance = availableBalance;

        currentBalanceText.textContent = formatRupiah(currentBalance);
        pendingWithdrawText.textContent = formatRupiah(pendingWithdraw);
        availableBalanceText.textContent = formatRupiah(availableBalance);

        withdrawBalanceGrid.classList.remove('d-none');

        if (!selectedBalanceKnown) {
            withdrawBalanceNotice.classList.add('warning');
            withdrawBalanceText.textContent = 'Preview saldo belum tersedia. Sistem tetap akan melakukan validasi saldo saat pengajuan dikirim.';
        } else if (availableBalance <= 0) {
            withdrawBalanceNotice.classList.add('danger');
            withdrawBalanceText.textContent = 'Saldo tersedia kosong. Pengajuan ambil tabungan tidak dapat dilakukan untuk pilihan ini.';
        } else if (pendingWithdraw > 0) {
            withdrawBalanceNotice.classList.add('warning');
            withdrawBalanceText.textContent = 'Ada pengajuan ambil tabungan yang masih pending. Saldo tersedia sudah dikurangi nominal pending tersebut.';
        } else {
            withdrawBalanceText.textContent = 'Saldo tersedia dapat digunakan untuk pengajuan ambil tabungan.';
        }

        updateAmountPreview();
    }

    function updateAmountPreview() {
        if (!amountInput || !amountPreview || !amountPreviewText) {
            return;
        }

        const value = Number(amountInput.value || 0);

        amountPreview.classList.remove('show');
        amountPreviewText.textContent = 'Rp 0';

        if (!value || value <= 0) {
            return;
        }

        amountPreview.classList.add('show');

        if (
            selectedBalanceKnown &&
            selectedAvailableBalance !== null &&
            value > selectedAvailableBalance
        ) {
            amountPreviewText.textContent = formatRupiah(value) + ' — melebihi saldo tersedia';
            return;
        }

        amountPreviewText.textContent = formatRupiah(value);
    }

    if (amountInput) {
        amountInput.addEventListener('input', updateAmountPreview);
    }

    if (targetUserInput) {
        targetUserInput.addEventListener('change', updateBalanceNotice);
    }

    if (fundTypeInput) {
        fundTypeInput.addEventListener('change', updateBalanceNotice);
    }

    updateBalanceNotice();
    updateAmountPreview();
</script>
@endsection