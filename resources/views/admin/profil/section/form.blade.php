@extends('admin.layout.app')

@php
    $isEdit = !empty($item);
    $columns = $config['columns'] ?? [];
    $keyColumn = $config['key'] ?? 'id';
    $label = $config['label'] ?? 'Profil DKM';
    $sheet = $config['sheet'] ?? '-';
    $imageColumn = $config['image_column'] ?? null;

    $keyValue = $item[$keyColumn] ?? null;

    $action = $isEdit
        ? route('admin.profil.section.update', [$section, $keyValue])
        : route('admin.profil.section.store', $section);

    $pageTitle = $isEdit ? 'Edit ' . $label : 'Tambah ' . $label;
@endphp

@section('title', $pageTitle)
@section('page_title', $pageTitle)
@section('page_subtitle', 'Kelola data pada sheet ' . $sheet)

@section('css')
<style>
    .profil-form-header {
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

    .profil-form-eyebrow {
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

    .profil-form-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .profil-form-subtitle {
        max-width: 720px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .profil-btn-light {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #475569;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .profil-btn-light:hover {
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
        color: #2563eb;
    }

    .profil-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .profil-form-group-full {
        grid-column: 1 / -1;
    }

    .profil-form-label {
        display: block;
        margin-bottom: 8px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 800;
    }

    .profil-required {
        color: #dc2626;
    }

    .profil-form-control {
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

    .profil-form-control:focus {
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
    }

    textarea.profil-form-control {
        min-height: 130px;
        resize: vertical;
    }

    .profil-form-help {
        margin-top: 7px;
        font-size: 12px;
        color: #94a3b8;
        line-height: 1.5;
    }

    .profil-error {
        margin-top: 7px;
        font-size: 12px;
        font-weight: 700;
        color: #dc2626;
    }

    .profil-readonly {
        background: #f8fafc;
        color: #64748b;
    }

    .profil-image-box {
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
        background: #f8fafc;
        padding: 18px;
    }

    .profil-image-preview {
        width: 100%;
        height: 260px;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        color: #94a3b8;
    }

    .profil-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profil-current-badge {
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

    .profil-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 28px;
    }

    @media (max-width: 768px) {
        .profil-form-header {
            flex-direction: column;
            align-items: stretch;
        }

        .profil-form-grid {
            grid-template-columns: 1fr;
        }

        .profil-form-actions {
            flex-direction: column-reverse;
        }

        .profil-form-actions a,
        .profil-form-actions button {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

<div class="profil-form-header">
    <div>
        <span class="profil-form-eyebrow">
            {{ $sheet }}
        </span>

        <h3 class="profil-form-title">
            {{ $pageTitle }}
        </h3>

        <p class="profil-form-subtitle">
            {{ $isEdit ? 'Perbarui data' : 'Tambahkan data baru' }}
            untuk section <strong>{{ $label }}</strong>.
        </p>
    </div>

    <a href="{{ route('admin.profil.section.index', $section) }}" class="profil-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger border-0 rounded-4 mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ $errors->first() }}
    </div>
@endif

<div class="admin-card p-4">
    <form action="{{ $action }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="profil-form-grid">
            @foreach($columns as $column)
                @php
                    $value = old($column, $item[$column] ?? '');
                    $title = ucwords(str_replace('_', ' ', $column));
                    $isRequired = in_array($column, $config['required'] ?? [], true);
                    $isAutoId = str_starts_with($column, 'id_');
                    $isTextarea = in_array($column, [
                        'description',
                        'section_body_1',
                        'section_body_2',
                        'quote_text',
                        'subtitle',
                    ], true);
                    $isFullWidth = $isTextarea || $column === $imageColumn;
                @endphp

                {{-- Auto ID: show readonly only when editing --}}
                @if($isAutoId)
                    @if($isEdit)
                        <div>
                            <label class="profil-form-label">
                                {{ $title }}
                            </label>

                            <input type="text"
                                   class="profil-form-control profil-readonly"
                                   value="{{ $value }}"
                                   readonly>

                            <div class="profil-form-help">
                                ID dibuat otomatis oleh sistem.
                            </div>
                        </div>
                    @endif

                    @continue
                @endif

                {{-- Image filename + upload --}}
                @if($column === $imageColumn)
                    <div class="profil-form-group-full">
                        <label class="profil-form-label">
                            Gambar
                        </label>

                        <div class="profil-image-box">
                            @if(!empty($value))
                                <div class="profil-current-badge">
                                    <i class="bi bi-image"></i>
                                    Gambar saat ini: {{ $value }}
                                </div>

                                <div class="profil-image-preview">
                                    <img src="{{ asset('image/profil/' . $value) }}"
                                         alt="Preview">
                                </div>
                            @else
                                <div class="profil-image-preview">
                                    <div class="text-center">
                                        <i class="bi bi-image fs-1"></i>
                                        <div class="small mt-2">No Image Available</div>
                                    </div>
                                </div>
                            @endif

                            <input type="hidden"
                                   name="{{ $column }}"
                                   value="{{ $value }}">

                            <input type="file"
                                   name="image_upload"
                                   class="profil-form-control"
                                   accept="image/*">

                            @error('image_upload')
                                <div class="profil-error">{{ $message }}</div>
                            @enderror

                            @error($column)
                                <div class="profil-error">{{ $message }}</div>
                            @enderror

                            <div class="profil-form-help">
                                Kosongkan jika tidak ingin mengganti gambar. File akan disimpan sebagai WebP di folder <strong>public/image/profil</strong>.
                            </div>
                        </div>
                    </div>

                    @continue
                @endif

                {{-- Status --}}
                @if($column === 'status')
                    <div>
                        <label class="profil-form-label">
                            Status
                            @if($isRequired)
                                <span class="profil-required">*</span>
                            @endif
                        </label>

                        <select name="status" class="profil-form-control">
                            <option value="active" {{ $value === 'active' || empty($value) ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ $value === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                        @error('status')
                            <div class="profil-error">{{ $message }}</div>
                        @enderror
                    </div>

                    @continue
                @endif

                {{-- Level --}}
                @if($column === 'level')
                    <div>
                        <label class="profil-form-label">
                            Level
                            @if($isRequired)
                                <span class="profil-required">*</span>
                            @endif
                        </label>

                        <select name="level" class="profil-form-control">
                            <option value="">Pilih Level</option>
                            <option value="main" {{ $value === 'main' ? 'selected' : '' }}>Main</option>
                            <option value="secondary" {{ $value === 'secondary' ? 'selected' : '' }}>Secondary</option>
                            <option value="field" {{ $value === 'field' ? 'selected' : '' }}>Field</option>
                        </select>

                        <div class="profil-form-help">
                            Main untuk Ketua Umum, Secondary untuk Sekretaris/Bendahara, Field untuk bidang.
                        </div>

                        @error('level')
                            <div class="profil-error">{{ $message }}</div>
                        @enderror
                    </div>

                    @continue
                @endif

                {{-- Type --}}
                @if($column === 'type')
                    <div>
                        <label class="profil-form-label">
                            Type
                            @if($isRequired)
                                <span class="profil-required">*</span>
                            @endif
                        </label>

                        <select name="type" class="profil-form-control">
                            <option value="">Pilih Type</option>
                            <option value="daily" {{ $value === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="division" {{ $value === 'division' ? 'selected' : '' }}>Division</option>
                        </select>

                        <div class="profil-form-help">
                            Daily untuk Dewan Pengurus Harian, Division untuk anggota bidang.
                        </div>

                        @error('type')
                            <div class="profil-error">{{ $message }}</div>
                        @enderror
                    </div>

                    @continue
                @endif

                {{-- Textarea fields --}}
                @if($isTextarea)
                    <div class="profil-form-group-full">
                        <label class="profil-form-label">
                            {{ $title }}
                            @if($isRequired)
                                <span class="profil-required">*</span>
                            @endif
                        </label>

                        <textarea name="{{ $column }}"
                                  class="profil-form-control"
                                  placeholder="{{ $title }}">{{ $value }}</textarea>

                        @error($column)
                            <div class="profil-error">{{ $message }}</div>
                        @enderror
                    </div>

                    @continue
                @endif

                {{-- Normal input --}}
                <div class="{{ $isFullWidth ? 'profil-form-group-full' : '' }}">
                    <label class="profil-form-label">
                        {{ $title }}
                        @if($isRequired)
                            <span class="profil-required">*</span>
                        @endif
                    </label>

                    <input type="{{ $column === 'sort_order' ? 'number' : 'text' }}"
                           name="{{ $column }}"
                           class="profil-form-control"
                           value="{{ $value }}"
                           placeholder="{{ $title }}"
                           {{ $column === 'sort_order' ? 'min=1' : '' }}>

                    @if($column === 'slug')
                        <div class="profil-form-help">
                            Jika dikosongkan, slug akan dibuat otomatis dari judul/nama.
                        </div>
                    @elseif($column === 'icon' || $column === 'hero_icon')
                        <div class="profil-form-help">
                            Contoh: <strong>fas fa-history</strong>, <strong>fas fa-users</strong>, <strong>bi bi-people</strong>.
                        </div>
                    @elseif($column === 'route_name')
                        <div class="profil-form-help">
                            Contoh: <strong>profil.sejarah</strong>, <strong>profil.visi-misi</strong>.
                        </div>
                    @elseif($column === 'page_slug')
                        <div class="profil-form-help">
                            Contoh: <strong>sejarah</strong> atau <strong>visi-misi</strong>.
                        </div>
                    @elseif($column === 'division')
                        <div class="profil-form-help">
                            Contoh: <strong>Bidang Imarah</strong>, <strong>Bidang Riayah</strong>, atau <strong>Dewan Pengurus Harian</strong>.
                        </div>
                    @endif

                    @error($column)
                        <div class="profil-error">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        </div>

        <div class="profil-form-actions">
            <a href="{{ route('admin.profil.section.index', $section) }}" class="profil-btn-light">
                Batal
            </a>

            <button type="submit" class="admin-btn-blue">
                <i class="bi bi-check-lg"></i>
                {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Data' }}
            </button>
        </div>

    </form>
</div>

@endsection