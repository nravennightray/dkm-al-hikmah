@extends('admin.layout.app')

@php
    $isEdit = !empty($item);

    $title = $isEdit ? 'Edit Info Beranda' : 'Tambah Info Beranda';

    $action = $isEdit
        ? route('admin.home-info.update', $item['id_info'])
        : route('admin.home-info.store');

    $type = old('type', $item['type'] ?? 'info');
    $status = old('status', $item['status'] ?? 'active');
    $image = $item['image'] ?? '';

    $imageUrl = !empty($image)
        ? asset('image/home-info/' . $image)
        : null;
@endphp

@section('title', $title)

@section('css')
<style>
    .home-info-form-page {
        padding: 24px;
    }

    .home-info-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .home-info-form-title h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
    }

    .home-info-form-title p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .admin-btn-secondary,
    .admin-btn-primary {
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

    .home-info-form-card {
        background: #ffffff;
        border-radius: 22px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        border: 1px solid rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .home-info-form-body {
        padding: 24px;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 14px;
        margin-bottom: 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .form-section-title i {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .form-section-title h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
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
        min-height: 130px;
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

    .image-preview-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px;
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
    }

    .image-preview-card img {
        width: 140px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .image-preview-info strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .image-preview-info span {
        color: #64748b;
        font-size: 12px;
        word-break: break-all;
    }

    .image-empty-preview {
        width: 140px;
        height: 90px;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
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
        .home-info-form-page {
            padding: 18px;
        }

        .home-info-form-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .home-info-form-actions,
        .home-info-form-actions a {
            width: 100%;
        }

        .admin-btn-secondary,
        .admin-btn-primary {
            width: 100%;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .image-preview-card {
            align-items: flex-start;
            flex-direction: column;
        }

        .image-preview-card img,
        .image-empty-preview {
            width: 100%;
            height: 180px;
        }
    }
</style>
@endsection

@section('content')

<div class="home-info-form-page">

    <div class="home-info-form-header">
        <div class="home-info-form-title">
            <h1>{{ $title }}</h1>
            <p>
                {{ $isEdit ? 'Perbarui info, berita, atau iklan yang tampil di halaman utama.' : 'Tambahkan info, berita, atau iklan baru untuk halaman utama.' }}
            </p>
        </div>

        <div class="home-info-form-actions">
            <a href="{{ route('admin.home-info.index') }}" class="admin-btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
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

    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="home-info-form-card">
            <div class="home-info-form-body">

                <div class="form-section-title">
                    <i class="bi bi-megaphone"></i>
                    <h5>Informasi Utama</h5>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-4">
                        <label for="type" class="form-label">
                            Tipe <span class="required">*</span>
                        </label>

                        <select name="type"
                                id="type"
                                class="form-select-custom @error('type') is-invalid @enderror"
                                required>
                            <option value="info" {{ $type === 'info' ? 'selected' : '' }}>Info</option>
                            <option value="berita" {{ $type === 'berita' ? 'selected' : '' }}>Berita</option>
                            <option value="iklan" {{ $type === 'iklan' ? 'selected' : '' }}>Iklan</option>
                        </select>

                        @error('type')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="published_at" class="form-label">
                            Tanggal Publikasi
                        </label>

                        <input type="date"
                               name="published_at"
                               id="published_at"
                               value="{{ old('published_at', $item['published_at'] ?? '') }}"
                               class="form-control-custom @error('published_at') is-invalid @enderror">

                        @error('published_at')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="status" class="form-label">
                            Status <span class="required">*</span>
                        </label>

                        <select name="status"
                                id="status"
                                class="form-select-custom @error('status') is-invalid @enderror"
                                required>
                            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="title" class="form-label">
                            Judul <span class="required">*</span>
                        </label>

                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $item['title'] ?? '') }}"
                               class="form-control-custom @error('title') is-invalid @enderror"
                               placeholder="Contoh: Jadwal Kajian Rutin"
                               required>

                        @error('title')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="subtitle" class="form-label">
                            Subtitle / Label Kecil
                        </label>

                        <input type="text"
                               name="subtitle"
                               id="subtitle"
                               value="{{ old('subtitle', $item['subtitle'] ?? '') }}"
                               class="form-control-custom @error('subtitle') is-invalid @enderror"
                               placeholder="Contoh: Kajian Pekanan">

                        @error('subtitle')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">
                            Deskripsi <span class="required">*</span>
                        </label>

                        <textarea name="description"
                                  id="description"
                                  class="form-control-custom @error('description') is-invalid @enderror"
                                  placeholder="Tulis deskripsi singkat yang akan tampil di halaman utama."
                                  required>{{ old('description', $item['description'] ?? '') }}</textarea>

                        <div class="form-help">
                            Maksimal 500 karakter. Buat ringkas karena hanya tampil di section beranda.
                        </div>

                        @error('description')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-section-title mt-5">
                    <i class="bi bi-image"></i>
                    <h5>Gambar</h5>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label">
                            Preview Gambar
                        </label>

                        <div class="image-preview-card">
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" alt="{{ $item['title'] ?? 'Info Beranda' }}">
                            @else
                                <div class="image-empty-preview">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            <div class="image-preview-info">
                                <strong>{{ $imageUrl ? 'Gambar Saat Ini' : 'Belum Ada Gambar' }}</strong>

                                @if($imageUrl)
                                    <span>{{ $image }}</span>
                                @else
                                    <span>Upload gambar baru jika ingin menampilkan visual pada info beranda.</span>
                                @endif
                            </div>
                        </div>

                        <input type="file"
                               name="image_upload"
                               id="image_upload"
                               accept="image/png,image/jpeg,image/jpg,image/webp"
                               class="form-control-custom @error('image_upload') is-invalid @enderror">

                        <div class="form-help">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 2MB. File akan dikonversi ke WEBP.
                        </div>

                        @error('image_upload')
                            <div class="invalid-feedback-custom">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-section-title mt-5">
                    <i class="bi bi-sort-numeric-down"></i>
                    <h5>Urutan Tampil</h5>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-4">
                        <label for="sort_order" class="form-label">
                            Urutan
                        </label>

                        <input type="number"
                            name="sort_order"
                            id="sort_order"
                            value="{{ old('sort_order', $item['sort_order'] ?? 0) }}"
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
                </div>

            </div>

            <div class="form-footer">
                <a href="{{ route('admin.home-info.index') }}" class="admin-btn-secondary">
                    Batal
                </a>

                <button type="submit" class="admin-btn-primary">
                    <i class="bi bi-save"></i>
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Info' }}
                </button>
            </div>
        </div>
    </form>

</div>

@endsection