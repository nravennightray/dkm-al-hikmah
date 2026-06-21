@extends('admin.layout.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori')
@section('page_subtitle', 'Perbarui kategori kegiatan DKM AL HIKMAH')

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
        max-width: 620px;
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
            Form Kategori
        </span>

        <h3 class="form-title">
            Edit Kategori Kegiatan
        </h3>

        <p class="form-subtitle">
            Perbarui data kategori <strong>{{ $category['name'] ?? '-' }}</strong> yang tersimpan di Google Sheet.
        </p>
    </div>

    <a href="{{ route('admin.kategori.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card admin-form-card p-4">
    <form action="{{ route('admin.kategori.update', $category['slug']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="admin-form-grid">
            <div>
                <label for="name" class="admin-form-label">
                    Nama Kategori
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $category['name'] ?? '') }}"
                       class="admin-form-control"
                       placeholder="Contoh: Kajian Ikhwan"
                       required>

                @error('name')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="slug" class="admin-form-label">
                    Slug
                </label>

                <input type="text"
                       id="slug"
                       name="slug"
                       value="{{ old('slug', $category['slug'] ?? '') }}"
                       class="admin-form-control"
                       placeholder="Contoh: kajian-ikhwan">

                <div class="admin-form-help">
                    Jika slug diubah, link kategori publik juga akan berubah.
                </div>

                @error('slug')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label for="icon" class="admin-form-label">
                    Icon
                </label>

                <input type="text"
                       id="icon"
                       name="icon"
                       value="{{ old('icon', $category['icon'] ?? 'fa-folder') }}"
                       class="admin-form-control"
                       placeholder="Contoh: fa-book-open">

                <div class="admin-form-help">
                    Isi dengan class Font Awesome, contoh: <strong>fa-book-open</strong>, <strong>fa-users</strong>, atau <strong>fa-heart</strong>.
                </div>

                @error('icon')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label for="desc" class="admin-form-label">
                    Deskripsi
                </label>

                <textarea id="desc"
                          name="desc"
                          rows="5"
                          class="admin-form-control"
                          placeholder="Tulis deskripsi singkat kategori...">{{ old('desc', $category['desc'] ?? '') }}</textarea>

                @error('desc')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.kategori.index') }}" class="admin-btn-light">
                Batal
            </a>

            <button type="submit" class="admin-btn-blue">
                <i class="bi bi-check-lg"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection