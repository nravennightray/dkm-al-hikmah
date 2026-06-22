@extends('admin.layout.app')

@section('title', 'Setor Tabungan')
@section('page_title', 'Setor Tabungan')
@section('page_subtitle', 'Ajukan transaksi setor tabungan jamaah atau kas DKM')

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
        background: #eff6ff;
        border: 1px solid rgba(37, 99, 235, 0.14);
        color: #475569;
        margin-bottom: 24px;
    }

    .keuangan-note i {
        color: #2563eb;
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
        background: #f0fdf4;
        color: #047857;
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
</style>
@endsection

@section('content')

<div class="form-page-header">
    <div>
        <span class="form-eyebrow">
            Form Keuangan
        </span>

        <h3 class="form-title">
            Setor Tabungan
        </h3>

        <p class="form-subtitle">
            Buat pengajuan setor untuk tabungan qurban, umrah, atau kas. Saldo akan bertambah setelah disetujui admin.
        </p>
    </div>

    <a href="{{ route('admin.keuangan.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card admin-form-card p-4">
    <div class="keuangan-note">
        <i class="bi bi-info-circle"></i>

        <div>
            <div class="keuangan-note-title">
                Menunggu Persetujuan Admin
            </div>

            <p class="keuangan-note-text">
                Data setor yang dikirim akan masuk sebagai transaksi pending. Saldo baru akan berubah setelah transaksi disetujui oleh admin atau superadmin.
            </p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.keuangan.deposit.store') }}" method="POST">
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
                        Pilih nama jamaah atau karyawan yang melakukan setor.
                    </div>
                @else
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

                    <span class="fund-pill">
                        <i class="bi bi-cash-coin"></i>
                        Kas
                    </span>
                </div>

                @error('fund_type')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label for="amount" class="admin-form-label">
                    Nominal Setor
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
                          placeholder="Contoh: Setor tabungan qurban bulan Juni.">{{ old('note') }}</textarea>

                <div class="admin-form-help">
                    Opsional. Bisa diisi keterangan pembayaran atau periode setor.
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

            <button type="submit" class="admin-btn-blue">
                <i class="bi bi-send"></i>
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

@endsection

@section('script')
<script>
    const amountInput = document.getElementById('amount');
    const amountPreview = document.getElementById('amountPreview');
    const amountPreviewText = document.getElementById('amountPreviewText');

    function formatRupiah(value) {
        const number = Number(value || 0);

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(number);
    }

    function updateAmountPreview() {
        const value = amountInput.value;

        if (!value || Number(value) <= 0) {
            amountPreview.classList.remove('show');
            amountPreviewText.textContent = 'Rp 0';
            return;
        }

        amountPreview.classList.add('show');
        amountPreviewText.textContent = formatRupiah(value);
    }

    amountInput.addEventListener('input', updateAmountPreview);

    updateAmountPreview();
</script>
@endsection