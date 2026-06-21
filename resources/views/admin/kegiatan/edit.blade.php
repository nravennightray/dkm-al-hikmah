@extends('admin.layout.app')

@section('title', 'Edit Kegiatan')
@section('page_title', 'Edit Kegiatan')
@section('page_subtitle', 'Perbarui data kegiatan DKM AL HIKMAH')

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

    .image-upload-box {
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
        background: #f8fafc;
        padding: 18px;
    }

    .image-preview {
        width: 100%;
        height: 280px;
        border-radius: 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .image-preview-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
    }

    .image-preview-placeholder i {
        font-size: 32px;
        color: #2563eb;
    }

    .current-image-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        padding: 7px 11px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
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

        .image-preview {
            height: 220px;
        }
    }
</style>
@endsection

@section('content')

@php
    $currentTitle = $post['title'] ?? '-';
    $currentSlug = $post['slug'] ?? '';
    $currentImage = $post['image'] ?? '';
    $currentImageUrl = (! empty($currentSlug) && ! empty($currentImage))
        ? asset('image/kegiatan/' . $currentSlug . '/' . $currentImage)
        : null;
@endphp

<div class="form-page-header">
    <div>
        <span class="form-eyebrow">
            Form Kegiatan
        </span>

        <h3 class="form-title">
            Edit Kegiatan
        </h3>

        <p class="form-subtitle">
            Perbarui data kegiatan <strong>{{ $currentTitle }}</strong>. Jika slug diubah, folder gambar juga akan ikut disesuaikan.
        </p>
    </div>

    <a href="{{ route('admin.kegiatan.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card admin-form-card p-4">
    <form action="{{ route('admin.kegiatan.update', $post['slug']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="admin-form-grid">
            <div>
                <label for="title" class="admin-form-label">
                    Judul Kegiatan
                </label>

                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', $post['title'] ?? '') }}"
                       class="admin-form-control"
                       placeholder="Contoh: Kajian Rutin Ahad Pagi"
                       required>

                @error('title')
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
                       value="{{ old('slug', $post['slug'] ?? '') }}"
                       class="admin-form-control"
                       placeholder="Contoh: kajian-rutin-ahad-pagi">

                <div class="admin-form-help">
                    Jika slug diubah, link publik dan folder gambar akan ikut berubah.
                </div>

                @error('slug')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="category_slug" class="admin-form-label">
                    Kategori
                </label>

                <select id="category_slug"
                        name="category_slug"
                        class="admin-form-control"
                        required>
                    <option value="">Pilih kategori</option>

                    @foreach($categories as $category)
                        @php
                            $categorySlug = $category['slug'] ?? '';
                            $selectedCategory = old('category_slug', $post['category_slug'] ?? '');
                        @endphp

                        <option value="{{ $categorySlug }}"
                            @selected($selectedCategory === $categorySlug)>
                            {{ $category['name'] ?? '-' }}
                        </option>
                    @endforeach
                </select>

                @error('category_slug')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="date" class="admin-form-label">
                    Tanggal Kegiatan
                </label>

                <input type="date"
                       id="date"
                       name="date"
                       value="{{ old('date', $post['date'] ?? '') }}"
                       class="admin-form-control">

                @error('date')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label for="image" class="admin-form-label">
                    Gambar Utama
                </label>

                <div class="image-upload-box">
                    @if($currentImageUrl)
                        <div class="current-image-badge">
                            <i class="bi bi-image"></i>
                            Gambar saat ini: {{ $currentImage }}
                        </div>
                    @endif

                    <div class="image-preview" id="imagePreviewBox">
                        @if($currentImageUrl)
                            <img src="{{ $currentImageUrl }}"
                                 alt="{{ $currentTitle }}"
                                 id="imagePreview">
                        @else
                            <img src=""
                                 alt="Preview gambar"
                                 id="imagePreview"
                                 style="display: none;">

                            <div class="image-preview-placeholder" id="imagePreviewPlaceholder">
                                <i class="bi bi-image"></i>
                                <span>Preview gambar akan muncul di sini</span>
                            </div>
                        @endif

                        @if($currentImageUrl)
                            <div class="image-preview-placeholder"
                                 id="imagePreviewPlaceholder"
                                 style="display: none;">
                                <i class="bi bi-image"></i>
                                <span>Preview gambar akan muncul di sini</span>
                            </div>
                        @endif
                    </div>

                    <input type="file"
                           id="image"
                           name="image"
                           class="admin-form-control"
                           accept="image/jpeg,image/png,image/jpg,image/webp">

                    <div class="admin-form-help">
                        Kosongkan jika tidak ingin mengganti gambar. Jika upload gambar baru, sistem akan mengganti gambar lama menjadi file WebP.
                    </div>

                    @error('image')
                        <div class="admin-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="admin-form-group-full">
                <label for="excerpt" class="admin-form-label">
                    Excerpt
                </label>

                <textarea id="excerpt"
                          name="excerpt"
                          rows="3"
                          class="admin-form-control"
                          placeholder="Tulis ringkasan singkat kegiatan...">{{ old('excerpt', $post['excerpt'] ?? '') }}</textarea>

                <div class="admin-form-help">
                    Ringkasan pendek yang tampil di kartu kegiatan.
                </div>

                @error('excerpt')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label for="content" class="admin-form-label">
                    Konten
                </label>

                <textarea id="content"
                          name="content"
                          rows="8"
                          class="admin-form-control"
                          placeholder="Tulis isi lengkap kegiatan...">{{ old('content', $post['content'] ?? '') }}</textarea>

                @error('content')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="admin-form-group-full">
                <label for="quote" class="admin-form-label">
                    Quote
                </label>

                <textarea id="quote"
                          name="quote"
                          rows="3"
                          class="admin-form-control"
                          placeholder="Opsional. Contoh: Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia lainnya.">{{ old('quote', $post['quote'] ?? '') }}</textarea>

                @error('quote')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.kegiatan.index') }}" class="admin-btn-light">
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

@section('script')
<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewPlaceholder = document.getElementById('imagePreviewPlaceholder');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            if (!imagePreview.getAttribute('src')) {
                imagePreview.style.display = 'none';
                imagePreviewPlaceholder.style.display = 'flex';
            }

            return;
        }

        const imageUrl = URL.createObjectURL(file);

        imagePreview.src = imageUrl;
        imagePreview.style.display = 'block';
        imagePreviewPlaceholder.style.display = 'none';
    });
</script>
@endsection