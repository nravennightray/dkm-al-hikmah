@extends('admin.layout.app')

@php
    $isEdit = !empty($account);

    $title = $isEdit ? 'Edit Rekening Bank' : 'Tambah Rekening Bank';

    $action = $isEdit
        ? route('admin.infaq.accounts.update', $account['id_account'])
        : route('admin.infaq.accounts.store');

    $status = old('status', $account['status'] ?? 'active');
@endphp

@section('title', $title)

@section('css')
<style>
    .infaq-form-page {
        padding: 24px;
    }

    .infaq-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .infaq-form-title h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
    }

    .infaq-form-title p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .admin-btn-primary,
    .admin-btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        border: none;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .admin-btn-primary {
        background: #2563eb;
        color: #ffffff;
    }

    .admin-btn-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .admin-btn-secondary {
        background: #f1f5f9;
        color: #334155;
    }

    .admin-btn-secondary:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .infaq-form-card {
        max-width: 860px;
        background: #ffffff;
        border-radius: 22px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        border: 1px solid rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .infaq-form-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .infaq-form-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .infaq-form-card-header h5 {
        margin: 0;
        color: #0f172a;
        font-size: 17px;
        font-weight: 800;
    }

    .infaq-form-card-header p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .infaq-form-card-body {
        padding: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 800;
        color: #334155;
    }

    .required {
        color: #dc2626;
    }

    .form-control-custom,
    .form-select-custom {
        width: 100%;
        min-height: 46px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-control-custom:focus,
    .form-select-custom:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
    }

    .form-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
    }

    .invalid-feedback-custom {
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
        font-weight: 600;
    }

    .preview-card {
        padding: 18px;
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    .preview-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .preview-bank {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: linear-gradient(135deg, #1e40af, #2563eb, #0ea5e9);
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .preview-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }

    .preview-status.active {
        background: #dcfce7;
        color: #166534;
    }

    .preview-status.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .preview-number {
        color: #0f172a;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: 0.04em;
        word-break: break-all;
        margin-bottom: 4px;
    }

    .preview-holder {
        color: #64748b;
        font-size: 13px;
    }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .alert-errors {
        max-width: 860px;
        padding: 14px 16px;
        border-radius: 14px;
        margin-bottom: 20px;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        font-size: 14px;
    }

    .alert-errors ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    @media (max-width: 768px) {
        .infaq-form-page {
            padding: 18px;
        }

        .infaq-form-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .infaq-form-header .admin-btn-secondary {
            width: 100%;
        }

        .infaq-form-card-header {
            align-items: flex-start;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .form-footer .admin-btn-primary,
        .form-footer .admin-btn-secondary {
            width: 100%;
        }

        .preview-title {
            align-items: flex-start;
            flex-direction: column;
        }

        .preview-number {
            font-size: 22px;
        }
    }
</style>
@endsection

@section('content')

<div class="infaq-form-page">

    <div class="infaq-form-header">
        <div class="infaq-form-title">
            <h1>{{ $title }}</h1>
            <p>
                {{ $isEdit ? 'Perbarui data rekening bank untuk halaman infaq.' : 'Tambahkan rekening bank baru untuk halaman infaq.' }}
            </p>
        </div>

        <a href="{{ route('admin.infaq.index') }}" class="admin-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert-errors">
            <strong>Data belum valid.</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="POST">
        @csrf

        <div class="infaq-form-card">
            <div class="infaq-form-card-header">
                <div class="infaq-form-card-icon">
                    <i class="bi bi-bank"></i>
                </div>

                <div>
                    <h5>Data Rekening Bank</h5>
                    <p>Maksimal 3 rekening dapat ditampilkan di halaman publik.</p>
                </div>
            </div>

            <div class="infaq-form-card-body">
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label for="bank" class="form-label">
                            Nama Bank <span class="required">*</span>
                        </label>

                        <input type="text"
                               name="bank"
                               id="bank"
                               value="{{ old('bank', $account['bank'] ?? '') }}"
                               class="form-control-custom @error('bank') is-invalid @enderror"
                               placeholder="Contoh: Bank Syariah Indonesia"
                               required>

                        @error('bank')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="number" class="form-label">
                            Nomor Rekening <span class="required">*</span>
                        </label>

                        <input type="text"
                               name="number"
                               id="number"
                               value="{{ old('number', $account['number'] ?? '') }}"
                               class="form-control-custom @error('number') is-invalid @enderror"
                               placeholder="Contoh: 1234567890"
                               required>

                        <div class="form-help">
                            Boleh diisi angka saja atau dengan spasi sesuai kebutuhan tampilan.
                        </div>

                        @error('number')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="holder" class="form-label">
                            Atas Nama <span class="required">*</span>
                        </label>

                        <input type="text"
                               name="holder"
                               id="holder"
                               value="{{ old('holder', $account['holder'] ?? '') }}"
                               class="form-control-custom @error('holder') is-invalid @enderror"
                               placeholder="Contoh: DKM Al Hikmah"
                               required>

                        @error('holder')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="sort_order" class="form-label">
                            Urutan
                        </label>

                        <input type="number"
                               name="sort_order"
                               id="sort_order"
                               value="{{ old('sort_order', $account['sort_order'] ?? 0) }}"
                               class="form-control-custom @error('sort_order') is-invalid @enderror"
                               min="0"
                               placeholder="0">

                        <div class="form-help">
                            Angka kecil tampil lebih dulu.
                        </div>

                        @error('sort_order')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="status" class="form-label">
                            Status <span class="required">*</span>
                        </label>

                        <select name="status"
                                id="status"
                                class="form-select-custom @error('status') is-invalid @enderror"
                                required>
                            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>
                                Nonaktif
                            </option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Preview Tampilan
                        </label>

                        <div class="preview-card">
                            <div class="preview-title">
                                <span class="preview-bank" id="previewBank">
                                    {{ old('bank', $account['bank'] ?? 'Nama Bank') }}
                                </span>

                                <span class="preview-status {{ $status }}" id="previewStatus">
                                    {{ $status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>

                            <div class="preview-number" id="previewNumber">
                                {{ old('number', $account['number'] ?? '0000000000') }}
                            </div>

                            <div class="preview-holder">
                                a.n <span id="previewHolder">{{ old('holder', $account['holder'] ?? 'Nama Pemilik Rekening') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.infaq.index') }}" class="admin-btn-secondary">
                    Batal
                </a>

                <button type="submit" class="admin-btn-primary">
                    <i class="bi bi-save"></i>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Rekening' }}
                </button>
            </div>
        </div>
    </form>

</div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bankInput = document.getElementById('bank');
        const numberInput = document.getElementById('number');
        const holderInput = document.getElementById('holder');
        const statusInput = document.getElementById('status');

        const previewBank = document.getElementById('previewBank');
        const previewNumber = document.getElementById('previewNumber');
        const previewHolder = document.getElementById('previewHolder');
        const previewStatus = document.getElementById('previewStatus');

        function updatePreview() {
            previewBank.textContent = bankInput.value.trim() || 'Nama Bank';
            previewNumber.textContent = numberInput.value.trim() || '0000000000';
            previewHolder.textContent = holderInput.value.trim() || 'Nama Pemilik Rekening';

            const status = statusInput.value;

            previewStatus.classList.remove('active', 'inactive');
            previewStatus.classList.add(status);

            previewStatus.textContent = status === 'active' ? 'Aktif' : 'Nonaktif';
        }

        [bankInput, numberInput, holderInput, statusInput].forEach(function (input) {
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        });

        updatePreview();
    });
</script>
@endsection