@extends('admin.layout.app')

@section('title', 'Kategori Kegiatan')
@section('page_title', 'Kategori Kegiatan')
@section('page_subtitle', 'Kelola kategori kegiatan DKM AL HIKMAH')

@section('css')
<style>
    .kategori-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .kategori-table {
        width: 100%;
    }

    .kategori-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .kategori-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #eef2f7;
    }

    .kategori-table tr:last-child td {
        border-bottom: none;
    }

    .kategori-number {
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

    .kategori-slug {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
    }

    .kategori-action {
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

    .kategori-action i {
        font-size: 15px;
        line-height: 1;
    }

    .kategori-action-edit {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.12);
    }

    .kategori-action-edit:hover {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .kategori-action-danger {
        color: #dc2626;
        background: #fef2f2;
        border-color: rgba(220, 38, 38, 0.12);
    }

    .kategori-action-danger:hover {
        color: #ffffff;
        background: #dc2626;
        border-color: #dc2626;
    }

    .kategori-empty {
        padding: 56px 24px;
        text-align: center;
    }

    .kategori-empty-icon {
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

    @media (max-width: 768px) {
        .kategori-toolbar {
            align-items: stretch;
            flex-direction: column;
        }

        .kategori-toolbar .admin-btn-blue {
            width: 100%;
        }
    }

    .kategori-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 24px;
        border-radius: 24px;
        background: linear-gradient(180deg, #ffffff 0%, #eff6ff 100%);
        border: 1px solid rgba(37, 99, 235, 0.12);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
    }

    .kategori-eyebrow {
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

    .kategori-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .kategori-subtitle {
        max-width: 620px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    @media (max-width: 768px) {
        .kategori-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .kategori-page-header .admin-btn-blue {
            width: 100%;
        }
    }

    .kategori-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
    }

    .kategori-action-group form {
        display: inline-flex;
        margin: 0;
    }

    .kategori-pagination {
        padding: 18px 20px;
        border-top: 1px solid #eef2f7;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .kategori-pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
    }

    .kategori-pagination-links {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .kategori-page-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .kategori-page-btn:hover {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
    }

    .kategori-page-btn.active {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .kategori-page-btn.disabled {
        color: #cbd5e1;
        background: #f8fafc;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .kategori-pagination {
            flex-direction: column;
            align-items: stretch;
        }

        .kategori-pagination-links {
            justify-content: center;
            flex-wrap: wrap;
        }

        .kategori-pagination-info {
            text-align: center;
        }
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

<div class="kategori-page-header mb-4">
    <div>
        <span class="kategori-eyebrow">
            Manajemen Data
        </span>

        <h3 class="kategori-title">
            Daftar Kategori Kegiatan
        </h3>

        <p class="kategori-subtitle">
            Kelola kategori yang digunakan untuk mengelompokkan seluruh kegiatan DKM AL HIKMAH.
        </p>
    </div>

    <a href="{{ route('admin.kategori.create') }}" class="admin-btn-blue">
        <i class="bi bi-plus-lg"></i>
        Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 mb-4">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

<div class="admin-card overflow-hidden">
    @if(($categories ?? collect())->count())

        <div class="table-responsive">
            <table class="table kategori-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Deskripsi</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <span class="kategori-number">
                                    {{ method_exists($categories, 'firstItem') ? $categories->firstItem() + $loop->index : $loop->iteration }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-bold text-dark">
                                    {{ $category['name'] ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <span class="kategori-slug">
                                    {{ $category['slug'] ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="text-muted small">
                                    {{ $category['desc'] ?? '-' }}
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="kategori-action-group">
                                    <a href="{{ route('admin.kategori.edit', $category['slug']) }}"
                                       class="kategori-action kategori-action-edit"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.kategori.destroy', $category['slug']) }}"
                                        method="POST"
                                        class="m-0 delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                                class="kategori-action kategori-action-danger delete-trigger"
                                                title="Hapus"
                                                data-name="{{ $category['name'] ?? 'kategori ini' }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($categories, 'hasPages') && $categories->hasPages())
            <div class="kategori-pagination">
                <div class="kategori-pagination-info">
                    Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }}
                    dari {{ $categories->total() }} kategori
                </div>

                <div class="kategori-pagination-links">
                    @if($categories->onFirstPage())
                        <span class="kategori-page-btn disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" class="kategori-page-btn">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                        @if($page == $categories->currentPage())
                            <span class="kategori-page-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="kategori-page-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="kategori-page-btn">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="kategori-page-btn disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    @else

        <div class="kategori-empty">
            <div class="kategori-empty-icon">
                <i class="bi bi-folder2-open"></i>
            </div>

            <h5 class="fw-bold mb-2">
                Belum ada kategori
            </h5>

            <p class="text-muted mb-4">
                Tambahkan kategori pertama untuk mengelompokkan kegiatan DKM.
            </p>

            <a href="{{ route('admin.kategori.create') }}" class="admin-btn-blue">
                <i class="bi bi-plus-lg"></i>
                Tambah Kategori
            </a>
        </div>

    @endif
</div>

<div class="delete-modal-backdrop" id="deleteModalBackdrop">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="bi bi-exclamation-triangle"></i>
        </div>

        <h4 class="delete-modal-title">
            Hapus Kategori?
        </h4>

        <p class="delete-modal-text">
            Kategori <strong id="deleteCategoryName">ini</strong> akan dihapus dari Google Sheet.
            Tindakan ini tidak dapat dibatalkan.
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
    const deleteCategoryName = document.getElementById('deleteCategoryName');
    const deleteCancelBtn = document.getElementById('deleteCancelBtn');
    const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');

    document.querySelectorAll('.delete-trigger').forEach((button) => {
        button.addEventListener('click', function () {
            selectedDeleteForm = this.closest('form');

            deleteCategoryName.textContent = this.dataset.name || 'kategori ini';
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