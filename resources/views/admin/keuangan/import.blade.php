@extends('admin.layout.app')

@section('title', 'Import Transaksi')
@section('page_title', 'Import Transaksi')
@section('page_subtitle', 'Import transaksi keuangan dari file Excel')


@section('css')

<style>
    .import-page-header {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:18px;
        padding:24px;
        margin-bottom:24px;
        border-radius:24px;
        background:
            linear-gradient(
                180deg,
                #ffffff 0%,
                #eff6ff 100%
            );
        border:1px solid rgba(37,99,235,.12);
        box-shadow:
            0 10px 30px rgba(15,23,42,.04);
    }

    .import-title {
        margin-bottom:8px;
        color:#0f172a;
        font-size:26px
        font-weight:850;
    }

    .import-subtitle {
        margin:0;
        color:#64748b;
        font-size:14px;
    }

    .import-info {
        display:flex;
        gap:14px;
        padding:18px;
        margin-bottom:24px;
        border-radius:18px;
        background:#eff6ff;
        border:1px solid rgba(37,99,235,.15);
    }

    .import-info i {
        width:40px;
        height:40px;
        display:flex;
        align-items:center;
        justify-content:center;
        border-radius:12px;
        background:#dbeafe;
        color:#2563eb;
    }

    .import-table {
        width:100%;
        border-collapse:collapse;
    }

    .import-table th {
        background:#f8fafc;
        color:#64748b;
        font-size:12px;
        text-transform:uppercase;
        padding:12px;
    }

    .import-table td {
        padding:12px;
        border-bottom:1px solid #eef2f7;
    }

    .import-upload {
        width:100%;
        padding:18px;
        border-radius:18px;
        border:1px dashed rgba(37,99,235,.35);
        background:#f8fbff;
    }

    .import-actions {
        display:flex;
        justify-content:flex-end;
        gap:10px;
        margin-top:24px;
    }

    @media(max-width:768px){
        .import-page-header {
            flex-direction:column;
            align-items:stretch;
        }

        .import-actions {
            flex-direction:column;
        }
    }
</style>
@endsection

@section('content')

<div class="import-page-header">
    <div>
        <h3 class="import-title">
            Import Transaksi Keuangan
        </h3>

        <p class="import-subtitle">
            Import transaksi tabungan, infaq, qurban, umrah, dan kas melalui file Excel.
        </p>
    </div>

    <a href="{{ route('admin.keuangan.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card p-4">
    <div class="import-info">
        <i class="bi bi-info-circle"></i>
        <div>
            <strong> Format Excel </strong>

            <p class="text-muted mb-0 mt-1">
                Kolom wajib:
                <b>NRP</b>,
                <b>Jenis Transaksi</b>,
                <b>Aksi</b>,
                <b>Nominal</b>.
                Tanggal boleh dikosongkan.
            </p>
        </div>
    </div>

    <div class="mb-4">
        <table class="import-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NRP</th>
                    <th>Jenis Transaksi</th>
                    <th>Aksi</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>123456</td>
                    <td>Qurban</td>
                    <td>Setor</td>
                    <td>500000</td>
                    <td>12/07/2026</td>
                </tr>
            </tbody>
        </table>
    </div>

    <form action="{{ route('admin.keuangan.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="import-upload">
            <label class="form-label fw-bold">
                File Excel
            </label>
            <input type="file" name="file" class="form-control rounded-4" accept=".xlsx,.xls,.csv" required>
            <small class="text-muted">
                Format:
                XLSX, XLS, CSV
                maksimal 4MB.
            </small>
        </div>

        @error('file')
            <div class="text-danger small mt-2">
                {{ $message }}
            </div>
        @enderror

        <div class="import-actions">
            <a href="{{ route('admin.keuangan.index') }}" class="admin-btn-light">
                Batal
            </a>

            <button type="submit" class="admin-btn-blue">
                <i class="bi bi-upload"></i>
                Import Sekarang
            </button>
        </div>
    </form>
</div>
@endsection