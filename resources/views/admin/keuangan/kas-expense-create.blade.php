@extends('admin.layout.app')

@section('title', 'Kas Keluar')
@section('page_title', 'Kas Keluar')
@section('page_subtitle', 'Catat penggunaan kas DKM AL HIKMAH')

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
        grid-template-columns: 1fr;
        gap: 22px;
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
        min-height: 130px;
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

    .kas-warning {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        border-radius: 18px;
        background: #fef2f2;
        border: 1px solid rgba(220, 38, 38, 0.14);
        color: #475569;
        margin-bottom: 24px;
    }

    .kas-warning i {
        color: #dc2626;
        font-size: 20px;
        line-height: 1.2;
        flex-shrink: 0;
    }

    .kas-warning-title {
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        margin-bottom: 4px;
    }

    .kas-warning-text {
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
        background: #fef2f2;
        color: #dc2626;
        font-size: 13px;
        font-weight: 850;
    }

    .amount-preview.show {
        display: inline-flex;
        align-items: center;
        gap: 8px;
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

    .kas-confirm-btn {
        border-color: #dc2626;
        background: #dc2626;
    }

    .kas-confirm-btn:hover {
        border-color: #b91c1c;
        background: #b91c1c;
        box-shadow: 0 12px 24px rgba(220, 38, 38, 0.22);
    }

    @media (max-width: 768px) {
        .form-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .form-page-header .admin-btn-light {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

<div class="form-page-header">
    <div>
        <span class="form-eyebrow">
            Kas DKM
        </span>

        <h3 class="form-title">
            Catat Kas Keluar
        </h3>

        <p class="form-subtitle">
            Catat penggunaan dana kas DKM untuk kebutuhan operasional, perlengkapan musala, atau kegiatan internal.
        </p>
    </div>

    <a href="{{ route('admin.keuangan.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card admin-form-card p-4">
    <div class="kas-warning">
        <i class="bi bi-exclamation-triangle"></i>

        <div>
            <div class="kas-warning-title">
                Transaksi Langsung Disetujui
            </div>

            <p class="kas-warning-text">
                Pengeluaran kas hanya bisa dilakukan oleh admin atau superadmin. Setelah disimpan, saldo kas akan langsung berkurang dan transaksi tercatat sebagai approved.
            </p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.keuangan.kas.expense.store') }}"
          method="POST"
          onsubmit="return confirm('Catat pengeluaran kas ini? Saldo kas akan langsung berkurang.')">
        @csrf

        <div class="admin-form-grid">
            <div>
                <label for="amount" class="admin-form-label">
                    Nominal Kas Keluar
                </label>

                <input type="number"
                       id="amount"
                       name="amount"
                       value="{{ old('amount') }}"
                       class="admin-form-control"
                       placeholder="Contoh: 250000"
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

            <div>
                <label for="note" class="admin-form-label">
                    Keterangan Penggunaan
                </label>

                <textarea id="note"
                          name="note"
                          rows="5"
                          class="admin-form-control"
                          placeholder="Contoh: Pembelian perlengkapan kebersihan musala."
                          required>{{ old('note') }}</textarea>

                <div class="admin-form-help">
                    Wajib diisi agar penggunaan kas mudah dilacak saat laporan.
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

            <button type="submit" class="admin-btn-blue kas-confirm-btn">
                <i class="bi bi-check-lg"></i>
                Catat Kas Keluar
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