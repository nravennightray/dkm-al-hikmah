@extends('admin.layout.app')

@section('title', 'Edit Musala')
@section('page_title', 'Edit Musala')
@section('page_subtitle', 'Perbarui data sub musala kantor atau plant')

@section('css')
<style>
    /* =========================
       HEADER (MATCH KEGIATAN STYLE)
       ========================= */
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

    /* =========================
       FORM SYSTEM (MATCH KEGIATAN)
       ========================= */
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
        min-height: 120px;
        resize: vertical;
    }

    .admin-form-help {
        margin-top: 7px;
        font-size: 12px;
        color: #94a3b8;
    }

    .admin-error {
        margin-top: 7px;
        font-size: 12px;
        font-weight: 700;
        color: #dc2626;
    }

    /* =========================
       IMAGE
       ========================= */
    .image-upload-box {
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
        background: #f8fafc;
        padding: 18px;
    }

    .image-preview {
        width: 100%;
        height: 260px;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        background: #fff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        color: #94a3b8;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
    }

    .image-placeholder i {
        font-size: 30px;
        color: #2563eb;
    }

    .current-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    /* =========================
       BUTTONS
       ========================= */
    .admin-btn-light {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #475569;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
    }

    .admin-btn-light:hover {
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
        color: #2563eb;
    }

    @media (max-width: 768px) {
        .form-page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-form-grid {
            grid-template-columns: 1fr;
        }

        .image-preview {
            height: 220px;
        }
    }
</style>
@endsection

@section('content')

@php
    $typeOptions = $typeOptions ?? [
        'plant' => 'Musala Plant',
        'kantor' => 'Musala Kantor',
    ];

    $facilitiesText = is_array($musala['facilities'] ?? null)
        ? implode(';', $musala['facilities'])
        : ($musala['facilities'] ?? '');

    $image = $musala['image'] ?? '';
    $imagePath = public_path('image/musala/' . $image);

    $hasImage = !empty($image) && file_exists($imagePath);

    $imageUrl = $hasImage
        ? asset('image/musala/' . $image) . '?v=' . filemtime($imagePath)
        : asset('assets/images/dkm/default-image.jpg');
@endphp

{{-- HEADER --}}
<div class="form-page-header">
    <div>
        <span class="form-eyebrow">Form Musala</span>
        <h3 class="form-title">Edit Musala</h3>
        <p class="form-subtitle">
            Perbarui data sub musala berdasarkan kategori Musala Kantor atau Musala Plant.
        </p>
    </div>

    <a href="{{ route('admin.musala.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

{{-- FORM --}}
<div class="admin-card p-4">

    <form action="{{ route('admin.musala.update', $musala['slug']) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="admin-form-grid">
            <div>
                <label class="admin-form-label">
                    Jenis Musala
                </label>

                <select name="type"
                        class="admin-form-control"
                        required>
                    <option value="">Pilih Jenis Musala</option>

                    @foreach($typeOptions as $typeValue => $typeLabel)
                        <option value="{{ $typeValue }}"
                            @selected(old('type', $musala['type'] ?? '') === $typeValue)>
                            {{ $typeLabel }}
                        </option>
                    @endforeach
                </select>

                @error('type')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="admin-form-label">
                    Nama Sub Musala
                </label>

                <input type="text"
                    name="title"
                    class="admin-form-control"
                    value="{{ old('title', $musala['title'] ?? '') }}"
                    placeholder="Contoh: Musala Plant 1 / Musala Kantor 1"
                    required>

                @error('title')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="admin-form-label">
                    Lokasi
                </label>

                <input type="text"
                    name="location"
                    class="admin-form-control"
                    value="{{ old('location', $musala['location'] ?? '') }}"
                    placeholder="Contoh: Area Plant 1 / Gedung Kantor Lantai 1"
                    required>

                @error('location')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="admin-form-label">
                    Kapasitas
                </label>

                <input type="text"
                    name="capacity"
                    class="admin-form-control"
                    value="{{ old('capacity', $musala['capacity'] ?? '') }}"
                    placeholder="Contoh: 50 Jamaah"
                    required>

                @error('capacity')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="admin-form-label">
                    Urutan
                </label>

                <input type="number"
                    name="sort_order"
                    class="admin-form-control"
                    value="{{ old('sort_order', $musala['sort_order'] ?? '') }}"
                    min="1"
                    placeholder="Contoh: 1">

                <div class="admin-form-help">
                    Urutan tampil di dalam kategori Musala Plant atau Musala Kantor.
                </div>

                @error('sort_order')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="admin-form-label">
                    Status
                </label>

                <select name="status"
                        class="admin-form-control">
                    <option value="active"
                        @selected(old('status', $musala['status'] ?? 'active') === 'active')>
                        Active
                    </option>

                    <option value="inactive"
                        @selected(old('status', $musala['status'] ?? 'active') === 'inactive')>
                        Inactive
                    </option>
                </select>

                @error('status')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label class="admin-form-label">
                    Fasilitas
                </label>

                <textarea name="facilities"
                        class="admin-form-control"
                        placeholder="AC;Wudhu;Mukena"
                        required>{{ old('facilities', $facilitiesText) }}</textarea>

                <div class="admin-form-help">
                    Pisahkan dengan tanda <b>;</b>
                </div>

                @error('facilities')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label class="admin-form-label">
                    Deskripsi
                </label>

                <textarea name="desc"
                        class="admin-form-control"
                        rows="3"
                        placeholder="Deskripsi tambahan untuk Musala">{{ old('desc', $musala['desc'] ?? '') }}</textarea>

                <div class="admin-form-help">
                    Deskripsi khusus untuk sub musala ini.
                </div>

                @error('desc')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label class="admin-form-label">
                    Gambar
                </label>

                <div class="image-upload-box">

                    @if($hasImage)
                        <div class="current-badge">
                            <i class="bi bi-image"></i>
                            Gambar saat ini
                        </div>
                    @endif

                    <div class="image-preview">
                        @if($hasImage)
                            <img src="{{ $imageUrl }}"
                                alt="{{ $musala['title'] ?? 'Musala' }}">
                        @else
                            <div class="image-placeholder">
                                <i class="bi bi-image"></i>
                                <span>No Image Available</span>
                            </div>
                        @endif
                    </div>

                    <input type="file"
                        name="image"
                        class="admin-form-control"
                        accept="image/*">

                    <div class="admin-form-help">
                        Kosongkan jika tidak ingin mengganti gambar.
                    </div>

                    @error('image')
                        <div class="admin-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="d-flex justify-content-end gap-2 mt-4">

            <a href="{{ route('admin.musala.index') }}"
               class="admin-btn-light">
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