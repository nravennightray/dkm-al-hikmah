@extends('admin.layout.app')

@section('title', 'Import User')
@section('page_title', 'Import User')
@section('page_subtitle', 'Impor akun karyawan dari file Excel')

@section('css')
<style>
    .import-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 24px;
        margin-bottom: 24px;
        border-radius: 24px;
        background: linear-gradient(
            180deg,
            #ffffff 0%,
            #eff6ff 100%
        );
        border: 1px solid rgba(37,99,235,.12);
        box-shadow:
            0 10px 30px rgba(15,23,42,.04);
    }

    .import-eyebrow {
        display:inline-flex;
        align-items:center;
        padding:6px 12px;
        margin-bottom:10px;
        border-radius:999px;
        background:#eff6ff;
        color:#2563eb;
        font-size:12px;
        font-weight:800;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .import-title {
        margin-bottom:8px;
        color:#0f172a;
        font-size:26px;
        font-weight:850;
    }

    .import-subtitle {
        margin:0;
        max-width:650px;
        color:#64748b;
        font-size:14px;
        line-height:1.7;
    }

    .import-form-card {
        padding:28px;
    }

    .import-info-box {
        display:flex;
        align-items:flex-start;
        gap:14px;
        padding:18px;
        margin-bottom:24px;
        border-radius:18px;
        background:#eff6ff;
        border:1px solid rgba(37,99,235,.15);
    }

    .import-info-icon {
        width:42px;
        height:42px;
        flex-shrink:0;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#dbeafe;
        color:#2563eb;
        font-size:20px;
    }

    .import-info-title {
        color:#0f172a;
        font-size:14px;
        font-weight:850;
        margin-bottom:5px;
    }

    .import-info-text {
        margin:0;
        color:#64748b;
        font-size:13px;
        line-height:1.6;
    }

    .import-label {
        display:block;
        margin-bottom:8px;
        color:#0f172a;
        font-size:14px;
        font-weight:800;
    }

    .import-input {
        width:100%;
        height:48px;
        padding:10px 14px;
        border-radius:14px;
        border:1px solid #e5e7eb;
        background:#ffffff;
        font-size:14px;
        color:#0f172a;
        transition:.2s ease;
    }

    .import-input:focus {
        border-color:rgba(37,99,235,.45);
        box-shadow:
        0 0 0 4px rgba(37,99,235,.10);
        outline:none;
    }

    .import-help {
        margin-top:8px;
        color:#94a3b8;
        font-size:12px;
    }

    .import-actions {
        display:flex;
        justify-content:flex-end;
        gap:10px;
        margin-top:24px;
    }

    .import-btn {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        height:42px;
        padding:0 18px;
        border-radius:12px;
        font-size:14px;
        font-weight:800;
        text-decoration:none;
        transition:.2s ease;
    }

    .import-btn-primary {
        background:#2563eb;
        color:#fff;
        border:1px solid #2563eb;
    }

    .import-btn-primary:hover {
        background:#1d4ed8;
        color:#fff;
    }

    .import-btn-secondary {
        background:#fff;
        color:#475569;
        border:1px solid #e5e7eb;
    }

    .import-btn-secondary:hover {
        background:#eff6ff;
        color:#2563eb;
    }

    @media(max-width:768px){
        .import-page-header {
            flex-direction:column;
            align-items:stretch;
        }

        .import-actions {
            flex-direction:column;
        }

        .import-btn {
            width:100%;
        }
    }
</style>
@endsection


@section('content')
<div class="import-page-header">
    <div>
        <span class="import-eyebrow"> Import Data </span>
        <h3 class="import-title"> Import User </h3>
        <p class="import-subtitle">
            Tambahkan akun karyawan secara massal menggunakan file Excel.
        </p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card import-form-card">
    <div class="import-info-box">
        <div class="import-info-icon">
            <i class="bi bi-info-circle"></i>
        </div>


        <div>
            <div class="import-info-title">
                Format File Import
            </div>

            <p class="import-info-text">
                File Excel hanya membutuhkan kolom: <strong>nrp</strong> dan <strong>name</strong>. User yang sudah tersedia akan dilewati otomatis.
            </p>
        </div>
    </div>

    <form action="{{ route('admin.users.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file" class="import-label">
                Pilih File Excel
            </label>

            <input id="file" type="file" name="file" class="import-input" accept=".xlsx,.xls,.csv" required>
            <div class="import-help">
                Format yang didukung: XLSX, XLS, CSV.
            </div>

            @error('file')
                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="alert alert-info border-0 rounded-4 mt-4 mb-0">
            <i class="bi bi-person-plus me-2"></i>
            User baru akan dibuat sebagai: <strong>karyawan</strong>,
            status: <strong>active</strong>, email kosong, password menggunakan NRP.
        </div>

        <div class="import-actions">
            <a href="{{ route('admin.users.index') }}" class="import-btn import-btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Batal
            </a>

            <button type="submit" class="import-btn import-btn-primary">
                <i class="bi bi-upload"></i>
                Import Sekarang
            </button>
        </div>
    </form>
</div>
@endsection