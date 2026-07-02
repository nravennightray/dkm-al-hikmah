@extends('admin.layout.app')

@section('title', $config['label'] ?? 'Profil DKM')
@section('page_title', $config['label'] ?? 'Profil DKM')
@section('page_subtitle', 'Kelola data ' . ($config['label'] ?? 'Profil DKM'))

@section('css')
<style>
    .profil-section-header {
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

    .profil-section-eyebrow {
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

    .profil-section-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .profil-section-subtitle {
        max-width: 720px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .profil-section-actions {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
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

    .profil-table {
        width: 100%;
    }

    .profil-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .profil-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #eef2f7;
        color: #334155;
        font-size: 13px;
    }

    .profil-table tr:last-child td {
        border-bottom: none;
    }

    .profil-number {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
    }

    .profil-key-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .profil-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .profil-status-active {
        background: #ecfdf5;
        color: #059669;
    }

    .profil-status-inactive {
        background: #f8fafc;
        color: #64748b;
    }

    .profil-cell-text {
        max-width: 320px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .profil-cell-small {
        color: #64748b;
        font-size: 12px;
    }

    .profil-image-thumb {
        width: 76px;
        height: 54px;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .profil-image-placeholder {
        width: 76px;
        height: 54px;
        border-radius: 14px;
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .profil-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
    }

    .profil-action-group form {
        display: inline-flex;
        margin: 0;
    }

    .profil-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .profil-action i {
        font-size: 15px;
        line-height: 1;
    }

    .profil-action-edit {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.12);
    }

    .profil-action-edit:hover {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .profil-action-danger {
        color: #dc2626;
        background: #fef2f2;
        border-color: rgba(220, 38, 38, 0.12);
    }

    .profil-action-danger:hover {
        color: #ffffff;
        background: #dc2626;
        border-color: #dc2626;
    }

    .profil-empty {
        padding: 56px 24px;
        text-align: center;
    }

    .profil-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 24px;
    }

    .delete-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(6px);
    }

    .delete-modal-backdrop.show {
        display: flex;
    }

    .delete-modal {
        width: 100%;
        max-width: 420px;
        border-radius: 24px;
        background: #ffffff;
        padding: 28px;
        text-align: center;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.28);
        animation: deleteModalIn 0.18s ease-out;
    }

    .delete-modal-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 18px;
        border-radius: 22px;
        background: #fef2f2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .delete-modal-title {
        margin-bottom: 10px;
        color: #0f172a;
        font-size: 22px;
        font-weight: 850;
    }

    .delete-modal-text {
        margin-bottom: 24px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .delete-modal-text strong {
        color: #0f172a;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .delete-modal-cancel,
    .delete-modal-confirm {
        min-width: 120px;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .delete-modal-cancel {
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #475569;
    }

    .delete-modal-cancel:hover {
        background: #f8fafc;
    }

    .delete-modal-confirm {
        border: 1px solid #dc2626;
        background: #dc2626;
        color: #ffffff;
    }

    .delete-modal-confirm:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    @keyframes deleteModalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(0.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @media (max-width: 768px) {
        .profil-section-header {
            align-items: stretch;
            flex-direction: column;
        }

        .profil-section-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .profil-section-actions a {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .delete-modal-actions {
            flex-direction: column;
        }

        .delete-modal-cancel,
        .delete-modal-confirm {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

@php
    $columns = $config['columns'] ?? [];
    $keyColumn = $config['key'] ?? 'id';
    $label = $config['label'] ?? 'Profil DKM';
    $sheet = $config['sheet'] ?? '-';
    $imageColumn = $config['image_column'] ?? null;
    $isLocked = !empty($config['locked']);
@endphp

<div class="profil-section-header">
    <div>
        <span class="profil-section-eyebrow">
            {{ $sheet }}
        </span>

        <h3 class="profil-section-title">
            {{ $label }}
        </h3>

        <p class="profil-section-subtitle">
            Kelola data pada sheet <strong>{{ $sheet }}</strong>.
            Data ini akan digunakan untuk halaman publik Profil DKM.
        </p>
    </div>

    <div class="profil-section-actions">
        <a href="{{ route('admin.profil.index') }}" class="profil-btn-light">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>

        @if(!$isLocked)
            <a href="{{ route('admin.profil.section.create', $section) }}" class="admin-btn-blue">
                <i class="bi bi-plus-lg"></i>
                Tambah Data
            </a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 mb-4">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger border-0 rounded-4 mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ $errors->first() }}
    </div>
@endif

<div class="admin-card overflow-hidden">
    @if(($items ?? collect())->count())

        <div class="table-responsive">
            <table class="table profil-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>

                        @foreach($columns as $column)
                            <th>
                                {{ ucwords(str_replace('_', ' ', $column)) }}
                            </th>
                        @endforeach

                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $item)
                        @php
                            $keyValue = $item[$keyColumn] ?? '';
                            $displayName =
                                $item['title']
                                ?? $item['name']
                                ?? $item['role']
                                ?? $item[$keyColumn]
                                ?? 'data ini';
                        @endphp

                        <tr>
                            <td>
                                <span class="profil-number">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            @foreach($columns as $column)
                                @php
                                    $value = $item[$column] ?? '';
                                @endphp

                                <td>
                                    @if($column === $keyColumn)
                                        <span class="profil-key-badge">
                                            {{ $value ?: '-' }}
                                        </span>

                                    @elseif($column === 'status')
                                        @php
                                            $status = strtolower($value ?: 'inactive');
                                        @endphp

                                        <span class="profil-status {{ $status === 'active' ? 'profil-status-active' : 'profil-status-inactive' }}">
                                            <i class="bi {{ $status === 'active' ? 'bi-check-circle' : 'bi-dash-circle' }}"></i>
                                            {{ $status }}
                                        </span>

                                    @elseif($column === $imageColumn)
                                        @if(!empty($value))
                                            <img src="{{ asset('image/profil/' . $value) }}"
                                                 class="profil-image-thumb"
                                                 alt="Profil Image">

                                            <div class="profil-cell-small mt-1">
                                                {{ $value }}
                                            </div>
                                        @else
                                            <div class="profil-image-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif

                                    @elseif(in_array($column, ['description', 'section_body_1', 'section_body_2', 'quote_text', 'subtitle'], true))
                                        <div class="profil-cell-text">
                                            {{ $value ?: '-' }}
                                        </div>

                                    @elseif($column === 'icon' || $column === 'hero_icon')
                                        <span class="profil-key-badge">
                                            @if(!empty($value))
                                                <i class="{{ $value }} me-1"></i>
                                            @endif
                                            {{ $value ?: '-' }}
                                        </span>

                                    @else
                                        <div class="profil-cell-text">
                                            {{ $value ?: '-' }}
                                        </div>
                                    @endif
                                </td>
                            @endforeach

                            <td class="text-center">
                                <div class="profil-action-group">
                                    @if(!empty($keyValue))
                                        <a href="{{ route('admin.profil.section.edit', [$section, $keyValue]) }}"
                                           class="profil-action profil-action-edit"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        @if(!$isLocked)
                                            <form action="{{ route('admin.profil.section.destroy', [$section, $keyValue]) }}"
                                                method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button"
                                                        class="profil-action profil-action-danger delete-trigger"
                                                        title="Hapus"
                                                        data-name="{{ $displayName }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-muted small">Key kosong</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else

        <div class="profil-empty">
            <div class="profil-empty-icon">
                <i class="bi bi-folder2-open"></i>
            </div>

            <h5 class="fw-bold mb-2">
                Belum ada data
            </h5>

            <p class="text-muted mb-4">
                Tambahkan data pertama untuk section <strong>{{ $label }}</strong>.
            </p>

            @if(!$isLocked)
                <a href="{{ route('admin.profil.section.create', $section) }}" class="admin-btn-blue">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Data
                </a>
            @endif
        </div>

    @endif
</div>

<div class="delete-modal-backdrop" id="deleteModalBackdrop">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="bi bi-exclamation-triangle"></i>
        </div>

        <h4 class="delete-modal-title">
            Hapus Data?
        </h4>

        <p class="delete-modal-text">
            Data <strong id="deleteDataName">ini</strong> akan dihapus dari Google Sheet
            <strong>{{ $sheet }}</strong>.
        </p>

        <div class="delete-modal-actions">
            <button type="button" class="delete-modal-cancel" id="deleteCancelBtn">
                Batal
            </button>

            <button type="button" class="delete-modal-confirm" id="deleteConfirmBtn">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    let selectedDeleteForm = null;

    const deleteModalBackdrop = document.getElementById('deleteModalBackdrop');
    const deleteDataName = document.getElementById('deleteDataName');
    const deleteCancelBtn = document.getElementById('deleteCancelBtn');
    const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');

    document.querySelectorAll('.delete-trigger').forEach((button) => {
        button.addEventListener('click', function () {
            selectedDeleteForm = this.closest('form');

            deleteDataName.textContent = this.dataset.name || 'data ini';
            deleteModalBackdrop.classList.add('show');
        });
    });

    deleteCancelBtn.addEventListener('click', function () {
        selectedDeleteForm = null;
        deleteModalBackdrop.classList.remove('show');
    });

    deleteConfirmBtn.addEventListener('click', function () {
        if (selectedDeleteForm) {
            selectedDeleteForm.submit();
        }
    });

    deleteModalBackdrop.addEventListener('click', function (event) {
        if (event.target === deleteModalBackdrop) {
            selectedDeleteForm = null;
            deleteModalBackdrop.classList.remove('show');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            selectedDeleteForm = null;
            deleteModalBackdrop.classList.remove('show');
        }
    });
</script>
@endsection