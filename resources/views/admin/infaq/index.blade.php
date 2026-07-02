@extends('admin.layout.app')

@section('title', 'Infaq')

@section('css')
<style>
    .infaq-page {
        padding: 24px;
    }

    .infaq-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .infaq-title h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
    }

    .infaq-title p {
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

    .admin-btn-primary.disabled,
    .admin-btn-primary:disabled {
        opacity: 0.55;
        pointer-events: none;
        cursor: not-allowed;
    }

    .admin-alert {
        padding: 14px 16px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: 600;
    }

    .admin-alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .admin-alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .infaq-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(360px, 0.8fr);
        gap: 22px;
        align-items: start;
    }

    .infaq-card {
        background: #ffffff;
        border-radius: 22px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        border: 1px solid rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .infaq-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .infaq-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .infaq-card-title-icon {
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

    .infaq-card-title h5 {
        margin: 0;
        color: #0f172a;
        font-size: 17px;
        font-weight: 800;
    }

    .infaq-card-title p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .infaq-card-body {
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

    textarea.form-control-custom {
        min-height: 110px;
        resize: vertical;
        line-height: 1.6;
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

    .qris-preview-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 14px;
    }

    .qris-preview-card img {
        width: 132px;
        height: 132px;
        object-fit: contain;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding: 8px;
    }

    .qris-preview-empty {
        width: 132px;
        height: 132px;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        background: #ffffff;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        flex-shrink: 0;
    }

    .qris-preview-info strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .qris-preview-info span {
        color: #64748b;
        font-size: 12px;
        word-break: break-all;
    }

    .settings-footer {
        display: flex;
        justify-content: flex-end;
        padding-top: 22px;
        margin-top: 22px;
        border-top: 1px solid #e2e8f0;
    }

    .account-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .summary-card {
        padding: 16px;
        border-radius: 16px;
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.05);
    }

    .summary-card span {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .summary-card strong {
        display: block;
        color: #0f172a;
        font-size: 24px;
        line-height: 1;
    }

    .account-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .account-card {
        padding: 18px;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.10);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    }

    .account-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .account-bank {
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

    .account-number {
        margin: 10px 0 4px;
        color: #0f172a;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 0.04em;
        word-break: break-all;
    }

    .account-holder {
        color: #64748b;
        font-size: 13px;
    }

    .status-badge {
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

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .account-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
    }

    .account-sort {
        color: #64748b;
        font-size: 12px;
    }

    .account-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .action-edit {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .action-edit:hover {
        background: #bfdbfe;
        color: #1d4ed8;
    }

    .action-toggle-active {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-toggle-active:hover {
        background: #fecaca;
        color: #991b1b;
    }

    .action-toggle-inactive {
        background: #dcfce7;
        color: #166534;
    }

    .action-toggle-inactive:hover {
        background: #bbf7d0;
        color: #166534;
    }

    .action-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-delete:hover {
        background: #fecaca;
        color: #991b1b;
    }

    .empty-state {
        padding: 46px 20px;
        text-align: center;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
    }

    .empty-state-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .empty-state h4 {
        margin-bottom: 8px;
        font-weight: 800;
        color: #0f172a;
    }

    .empty-state p {
        margin-bottom: 18px;
        color: #64748b;
    }

    .delete-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 1050;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.55);
    }

    .delete-modal-backdrop.show {
        display: flex;
    }

    .delete-modal {
        width: 100%;
        max-width: 430px;
        padding: 24px;
        border-radius: 22px;
        background: #ffffff;
        box-shadow: 0 28px 70px rgba(15, 23, 42, 0.28);
    }

    .delete-modal-icon {
        width: 62px;
        height: 62px;
        border-radius: 20px;
        background: #fee2e2;
        color: #991b1b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
    }

    .delete-modal h4 {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .delete-modal p {
        color: #64748b;
        margin-bottom: 22px;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-btn-cancel,
    .modal-btn-delete {
        border: none;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .modal-btn-cancel {
        background: #f1f5f9;
        color: #334155;
    }

    .modal-btn-delete {
        background: #dc2626;
        color: #ffffff;
    }

    @media (max-width: 1100px) {
        .infaq-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .infaq-page {
            padding: 18px;
        }

        .infaq-header,
        .infaq-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .infaq-header .admin-btn-primary,
        .infaq-card-header .admin-btn-primary {
            width: 100%;
        }

        .account-summary {
            grid-template-columns: 1fr;
        }

        .qris-preview-card {
            align-items: flex-start;
            flex-direction: column;
        }

        .qris-preview-card img,
        .qris-preview-empty {
            width: 100%;
            height: 220px;
        }

        .settings-footer {
            justify-content: stretch;
        }

        .settings-footer .admin-btn-primary {
            width: 100%;
        }

        .account-card-top,
        .account-meta {
            align-items: flex-start;
            flex-direction: column;
        }

        .account-actions {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

@php
    $settings = $settings ?? [];
    $accounts = $accounts ?? collect();

    $totalAccounts = $accounts->count();
    $activeAccounts = $accounts->filter(fn ($item) => strtolower($item['status'] ?? '') === 'active')->count();
    $inactiveAccounts = $accounts->filter(fn ($item) => strtolower($item['status'] ?? '') === 'inactive')->count();

    $qrisImage = $settings['qris_image'] ?? '';
    $qrisImageUrl = !empty($qrisImage)
        ? asset('image/infaq/' . $qrisImage)
        : null;

    $canAddAccount = $totalAccounts < 3;
@endphp

<div class="infaq-page">

    <div class="infaq-header">
        <div class="infaq-title">
            <h1>Infaq</h1>
            <p>Kelola tampilan QRIS dan rekening bank untuk halaman Infaq & Sedekah.</p>
        </div>

        <a href="{{ route('infaq.index') }}" target="_blank" class="admin-btn-secondary">
            <i class="bi bi-box-arrow-up-right"></i>
            Lihat Halaman
        </a>
    </div>

    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="admin-alert admin-alert-danger">
            <strong>Data belum valid.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="infaq-grid">

        <div class="infaq-card">
            <div class="infaq-card-header">
                <div class="infaq-card-title">
                    <div class="infaq-card-title-icon">
                        <i class="bi bi-qr-code"></i>
                    </div>

                    <div>
                        <h5>Pengaturan QRIS & Halaman</h5>
                        <p>Ubah teks hero, QRIS, dan catatan transfer.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.infaq.settings.update') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="infaq-card-body">

                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label for="hero_badge" class="form-label">
                                Badge Hero <span class="required">*</span>
                            </label>

                            <input type="text"
                                   name="hero_badge"
                                   id="hero_badge"
                                   value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}"
                                   class="form-control-custom @error('hero_badge') is-invalid @enderror"
                                   required>

                            @error('hero_badge')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="hero_title" class="form-label">
                                Judul Hero <span class="required">*</span>
                            </label>

                            <input type="text"
                                   name="hero_title"
                                   id="hero_title"
                                   value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                                   class="form-control-custom @error('hero_title') is-invalid @enderror"
                                   required>

                            @error('hero_title')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="hero_quote" class="form-label">
                                Quote Hero
                            </label>

                            <input type="text"
                                   name="hero_quote"
                                   id="hero_quote"
                                   value="{{ old('hero_quote', $settings['hero_quote'] ?? '') }}"
                                   class="form-control-custom @error('hero_quote') is-invalid @enderror">

                            @error('hero_quote')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="qris_badge" class="form-label">
                                Badge QRIS <span class="required">*</span>
                            </label>

                            <input type="text"
                                   name="qris_badge"
                                   id="qris_badge"
                                   value="{{ old('qris_badge', $settings['qris_badge'] ?? '') }}"
                                   class="form-control-custom @error('qris_badge') is-invalid @enderror"
                                   required>

                            @error('qris_badge')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="qris_title" class="form-label">
                                Judul QRIS <span class="required">*</span>
                            </label>

                            <input type="text"
                                   name="qris_title"
                                   id="qris_title"
                                   value="{{ old('qris_title', $settings['qris_title'] ?? '') }}"
                                   class="form-control-custom @error('qris_title') is-invalid @enderror"
                                   required>

                            @error('qris_title')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="qris_description" class="form-label">
                                Deskripsi QRIS <span class="required">*</span>
                            </label>

                            <textarea name="qris_description"
                                      id="qris_description"
                                      class="form-control-custom @error('qris_description') is-invalid @enderror"
                                      required>{{ old('qris_description', $settings['qris_description'] ?? '') }}</textarea>

                            @error('qris_description')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                Preview QRIS
                            </label>

                            <div class="qris-preview-card">
                                @if($qrisImageUrl)
                                    <img src="{{ $qrisImageUrl }}" alt="QRIS Infaq">
                                @else
                                    <div class="qris-preview-empty">
                                        <i class="bi bi-qr-code"></i>
                                    </div>
                                @endif

                                <div class="qris-preview-info">
                                    <strong>{{ $qrisImageUrl ? 'QRIS Saat Ini' : 'Belum Ada QRIS' }}</strong>

                                    @if($qrisImageUrl)
                                        <span>{{ $qrisImage }}</span>
                                    @else
                                        <span>Upload gambar QRIS untuk ditampilkan di halaman publik.</span>
                                    @endif
                                </div>
                            </div>

                            <input type="file"
                                   name="qris_image_upload"
                                   id="qris_image_upload"
                                   accept="image/png,image/jpeg,image/jpg,image/webp"
                                   class="form-control-custom @error('qris_image_upload') is-invalid @enderror">

                            <div class="form-help">
                                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2MB. File akan dikonversi ke WEBP.
                            </div>

                            @error('qris_image_upload')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="qris_note" class="form-label">
                                Catatan QRIS
                            </label>

                            <textarea name="qris_note"
                                      id="qris_note"
                                      class="form-control-custom @error('qris_note') is-invalid @enderror">{{ old('qris_note', $settings['qris_note'] ?? '') }}</textarea>

                            @error('qris_note')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="bank_title" class="form-label">
                                Judul Transfer Bank <span class="required">*</span>
                            </label>

                            <input type="text"
                                   name="bank_title"
                                   id="bank_title"
                                   value="{{ old('bank_title', $settings['bank_title'] ?? '') }}"
                                   class="form-control-custom @error('bank_title') is-invalid @enderror"
                                   required>

                            @error('bank_title')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="status" class="form-label">
                                Status Halaman <span class="required">*</span>
                            </label>

                            <select name="status"
                                    id="status"
                                    class="form-select-custom @error('status') is-invalid @enderror"
                                    required>
                                @php
                                    $settingsStatus = old('status', $settings['status'] ?? 'active');
                                @endphp

                                <option value="active" {{ $settingsStatus === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $settingsStatus === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="bank_description" class="form-label">
                                Deskripsi Transfer Bank <span class="required">*</span>
                            </label>

                            <textarea name="bank_description"
                                      id="bank_description"
                                      class="form-control-custom @error('bank_description') is-invalid @enderror"
                                      required>{{ old('bank_description', $settings['bank_description'] ?? '') }}</textarea>

                            @error('bank_description')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="transfer_note" class="form-label">
                                Catatan Transfer
                            </label>

                            <textarea name="transfer_note"
                                      id="transfer_note"
                                      class="form-control-custom @error('transfer_note') is-invalid @enderror">{{ old('transfer_note', $settings['transfer_note'] ?? '') }}</textarea>

                            @error('transfer_note')
                                <div class="invalid-feedback-custom">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="settings-footer">
                        <button type="submit" class="admin-btn-primary">
                            <i class="bi bi-save"></i>
                            Simpan Pengaturan
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <div>
            <div class="account-summary">
                <div class="summary-card">
                    <span>Total Rekening</span>
                    <strong>{{ $totalAccounts }}</strong>
                </div>

                <div class="summary-card">
                    <span>Aktif</span>
                    <strong>{{ $activeAccounts }}</strong>
                </div>

                <div class="summary-card">
                    <span>Nonaktif</span>
                    <strong>{{ $inactiveAccounts }}</strong>
                </div>
            </div>

            <div class="infaq-card">
                <div class="infaq-card-header">
                    <div class="infaq-card-title">
                        <div class="infaq-card-title-icon">
                            <i class="bi bi-bank"></i>
                        </div>

                        <div>
                            <h5>Rekening Bank</h5>
                            <p>Maksimal 3 rekening bank.</p>
                        </div>
                    </div>

                    @if($canAddAccount)
                        <a href="{{ route('admin.infaq.accounts.create') }}" class="admin-btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Tambah
                        </a>
                    @else
                        <span class="admin-btn-primary disabled">
                            <i class="bi bi-lock"></i>
                            Maks. 3
                        </span>
                    @endif
                </div>

                <div class="infaq-card-body">
                    @if($accounts->count())
                        <div class="account-list">
                            @foreach($accounts as $account)
                                @php
                                    $id = $account['id_account'] ?? '';
                                    $bank = $account['bank'] ?? '-';
                                    $number = $account['number'] ?? '-';
                                    $holder = $account['holder'] ?? '-';
                                    $sortOrder = $account['sort_order'] ?? '0';
                                    $status = strtolower($account['status'] ?? 'inactive');

                                    $statusClass = $status === 'active'
                                        ? 'status-active'
                                        : 'status-inactive';

                                    $toggleClass = $status === 'active'
                                        ? 'action-toggle-active'
                                        : 'action-toggle-inactive';

                                    $toggleIcon = $status === 'active'
                                        ? 'bi-eye-slash'
                                        : 'bi-eye';

                                    $toggleTitle = $status === 'active'
                                        ? 'Nonaktifkan'
                                        : 'Aktifkan';
                                @endphp

                                <div class="account-card">
                                    <div class="account-card-top">
                                        <div>
                                            <span class="account-bank">
                                                {{ $bank }}
                                            </span>

                                            <div class="account-number">
                                                {{ $number }}
                                            </div>

                                            <div class="account-holder">
                                                a.n {{ $holder }}
                                            </div>
                                        </div>

                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>

                                    <div class="account-meta">
                                        <div class="account-sort">
                                            Urutan: {{ $sortOrder }}
                                        </div>

                                        <div class="account-actions">
                                            <a href="{{ route('admin.infaq.accounts.edit', $id) }}"
                                               class="action-btn action-edit"
                                               title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('admin.infaq.accounts.toggle-status', $id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                        class="action-btn {{ $toggleClass }}"
                                                        title="{{ $toggleTitle }}">
                                                    <i class="bi {{ $toggleIcon }}"></i>
                                                </button>
                                            </form>

                                            <button type="button"
                                                    class="action-btn action-delete delete-trigger"
                                                    title="Hapus"
                                                    data-action="{{ route('admin.infaq.accounts.destroy', $id) }}"
                                                    data-title="{{ $bank }} - {{ $number }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="bi bi-bank"></i>
                            </div>

                            <h4>Belum Ada Rekening</h4>

                            <p>
                                Tambahkan rekening bank untuk ditampilkan di halaman infaq.
                            </p>

                            <a href="{{ route('admin.infaq.accounts.create') }}" class="admin-btn-primary">
                                <i class="bi bi-plus-circle"></i>
                                Tambah Rekening
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<div class="delete-modal-backdrop" id="deleteModal">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="bi bi-trash"></i>
        </div>

        <h4>Hapus Rekening Bank?</h4>

        <p id="deleteModalText">
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="delete-modal-actions">
                <button type="button" class="modal-btn-cancel" id="deleteCancel">
                    Batal
                </button>

                <button type="submit" class="modal-btn-delete">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteModalText = document.getElementById('deleteModalText');
        const deleteCancel = document.getElementById('deleteCancel');

        document.querySelectorAll('.delete-trigger').forEach(function (button) {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-action');
                const title = this.getAttribute('data-title');

                deleteForm.setAttribute('action', action);
                deleteModalText.textContent = 'Rekening "' + title + '" akan dihapus permanen.';

                modal.classList.add('show');
            });
        });

        deleteCancel.addEventListener('click', function () {
            modal.classList.remove('show');
            deleteForm.removeAttribute('action');
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.remove('show');
                deleteForm.removeAttribute('action');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                modal.classList.remove('show');
                deleteForm.removeAttribute('action');
            }
        });
    });
</script>
@endsection