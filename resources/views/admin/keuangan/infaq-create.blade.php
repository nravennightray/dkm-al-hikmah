@extends('admin.layout.app')

@section('title', 'Ajukan Infaq')
@section('page_title', 'Ajukan Infaq')
@section('page_subtitle', 'Pengajuan pemotonan gaji untuk Infaq')

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

    .admin-form-control:disabled {
        background: #f8fafc;
        color: #94a3b8;
    }

    textarea.admin-form-control {
        resize: vertical;
        min-height: 100px;
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

    .amount-options {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 10px;
    }

    .amount-option {
        position: relative;
        display: block;
    }

    .amount-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        width: 0;
        height: 0;
    }

    .amount-option-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px 14px;
        border: 2px solid #e5e7eb;
        border-radius: 14px;
        background: #ffffff;
        color: #0f172a;
        font-size: 13px;
        font-weight: 850;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .amount-option input[type="radio"]:checked + .amount-option-label {
        border-color: #2563eb;
        background: #eff6ff;
        color: #2563eb;
    }

    .amount-option-label:hover {
        border-color: rgba(37, 99, 235, 0.3);
    }

    .period-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
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

    .admin-btn-blue {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 24px;
        border: none;
        border-radius: 12px;
        background: #2563eb;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        width: 100%;
    }

    .admin-btn-blue:hover {
        background: #1d4ed8;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15);
    }

    .form-actions {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 12px;
        margin-top: 28px;
        border-top: 1px solid #e5e7eb;
        padding-top: 20px;
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

        .amount-options {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .form-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="form-page-header">
    <div>
        <span class="form-eyebrow">
            Pengajuan Pemotonan Gaji
        </span>

        <h3 class="form-title">
            Ajukan Infaq
        </h3>

        <p class="form-subtitle">
            Ajukan pemotonan gaji untuk Infaq kepada DKM Al-Hikmah. Pengajuan akan ditinjau oleh admin dan diproses sesuai dengan periode yang diminta.
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
                Pengajuan Menunggu Persetujuan
            </div>

            <p class="keuangan-note-text">
                Pengajuan pemotonan gaji Anda akan diproses oleh admin. Anda akan menerima notifikasi setelah pengajuan ditinjau.
            </p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-4 mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.keuangan.infaq.store') }}" method="POST">
        @csrf

        <div class="admin-form-grid">
            <!-- Data Pribadi Section -->
            <div>
                <label for="name" class="admin-form-label">
                    Nama Lengkap
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ $currentUser['name'] ?? session('sheet_user.name') ?? '' }}"
                       class="admin-form-control"
                       readonly>

                <div class="admin-form-help">
                    Data otomatis dari profil Anda.
                </div>
            </div>

            <div>
                <label for="nrp" class="admin-form-label">
                    NRP / Nomor Karyawan
                </label>

                <input type="text"
                       id="nrp"
                       name="nrp"
                       value="{{ $currentUser['nrp'] ?? '' }}"
                       class="admin-form-control"
                       readonly>

                <div class="admin-form-help">
                    Data otomatis dari profil Anda.
                </div>
            </div>

            <!-- Kontak Section -->
            <div class="admin-form-group-full">
                <label for="phone_number" class="admin-form-label">
                    Nomor Telepon / WhatsApp
                </label>

                <input type="tel"
                       id="phone_number"
                       name="phone_number"
                       value="{{ old('phone_number') }}"
                       class="admin-form-control"
                       placeholder="Contoh: 08123456789"
                       pattern="[0-9\+\-\s]{7,20}"
                       required>

                <div class="admin-form-help">
                    Nomor yang dapat dihubungi untuk informasi pengajuan.
                </div>

                @error('phone_number')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nominal Infaq Section -->
            <div class="admin-form-group-full">
                <label for="infaq_amount" class="admin-form-label">
                    Nominal Infaq (Pilihan)
                </label>

                <div class="amount-options">
                    @foreach($infaqAmounts as $amount)
                        <div class="amount-option">
                            <input type="radio"
                                   id="amount_{{ $amount }}"
                                   name="infaq_amount"
                                   value="{{ $amount }}"
                                   @checked(old('infaq_amount') == $amount)
                                   required>

                            <label for="amount_{{ $amount }}" class="amount-option-label">
                                Rp {{ number_format($amount, 0, ',', '.') }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="admin-form-help">
                    Pilih nominal infaq yang Anda inginkan.
                </div>

                @error('infaq_amount')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Periode Section -->
            <div class="admin-form-group-full">
                <label class="admin-form-label">
                    Periode Pemotonan
                </label>

                <div class="period-group">
                    <div>
                        <label for="period_month" class="admin-form-label" style="margin-bottom: 4px;">
                            Bulan
                        </label>

                        <select id="period_month"
                                name="period_month"
                                class="admin-form-control"
                                required>
                            <option value="">Pilih bulan</option>

                            @foreach($months as $key => $name)
                                <option value="{{ $key }}"
                                    @selected(old('period_month') == $key || date('m') == $key)>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>

                        @error('period_month')
                            <div class="admin-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="period_year" class="admin-form-label" style="margin-bottom: 4px;">
                            Tahun
                        </label>

                        <input type="number"
                               id="period_year"
                               name="period_year"
                               value="{{ old('period_year', date('Y')) }}"
                               class="admin-form-control"
                               min="2020"
                               max="2099"
                               required>

                        @error('period_year')
                            <div class="admin-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-help">
                    Tentukan bulan dan tahun untuk pemotonan gaji.
                </div>
            </div>

            <!-- Catatan Section -->
            <div class="admin-form-group-full">
                <label for="note" class="admin-form-label">
                    Catatan Tambahan
                </label>

                <textarea id="note"
                          name="note"
                          rows="3"
                          class="admin-form-control"
                          placeholder="Opsional. Tambahkan informasi tambahan jika diperlukan.">{{ old('note') }}</textarea>

                <div class="admin-form-help">
                    Opsional. Informasi tambahan untuk membantu pemrosesan pengajuan Anda.
                </div>

                @error('note')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <div></div>
            <button type="submit" class="admin-btn-blue">
                <i class="bi bi-check2-circle"></i>
                Ajukan Infaq
            </button>
        </div>
    </form>
</div>

@endsection

@section('script')
<script>
    // Add any form validation or interactivity here if needed
</script>
@endsection
