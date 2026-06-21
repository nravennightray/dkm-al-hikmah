@extends('admin.layout.app')

@section('title', 'Kegiatan')
@section('page_title', 'Kegiatan')
@section('page_subtitle', 'Kelola data kegiatan DKM AL HIKMAH')

@section('css')
<style>
    .kegiatan-page-header {
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

    .kegiatan-eyebrow {
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

    .kegiatan-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .kegiatan-subtitle {
        max-width: 620px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .kegiatan-table {
        width: 100%;
    }

    .kegiatan-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .kegiatan-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #eef2f7;
    }

    .kegiatan-table tr:last-child td {
        border-bottom: none;
    }

    .kegiatan-number {
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

    .kegiatan-post {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 320px;
    }

    .kegiatan-thumb {
        width: 82px;
        height: 58px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .kegiatan-thumb-placeholder {
        width: 82px;
        height: 58px;
        border-radius: 14px;
        flex-shrink: 0;
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .kegiatan-post-title {
        margin-bottom: 5px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        line-height: 1.35;
    }

    .kegiatan-post-excerpt {
        max-width: 460px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .kegiatan-slug {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .kegiatan-date {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #475569;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .kegiatan-date i {
        color: #2563eb;
    }

    .kegiatan-action {
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

    .kegiatan-action i {
        font-size: 15px;
        line-height: 1;
    }

    .kegiatan-action-edit {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.12);
    }

    .kegiatan-action-edit:hover {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .kegiatan-action-danger {
        color: #dc2626;
        background: #fef2f2;
        border-color: rgba(220, 38, 38, 0.12);
    }

    .kegiatan-action-danger:hover {
        color: #ffffff;
        background: #dc2626;
        border-color: #dc2626;
    }

    .kegiatan-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
    }

    .kegiatan-action-group form {
        display: inline-flex;
        margin: 0;
    }

    .kegiatan-empty {
        padding: 56px 24px;
        text-align: center;
    }

    .kegiatan-empty-icon {
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

    .kegiatan-pagination {
        padding: 18px 20px;
        border-top: 1px solid #eef2f7;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .kegiatan-pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
    }

    .kegiatan-pagination-links {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .kegiatan-page-btn {
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

    .kegiatan-page-btn:hover {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
    }

    .kegiatan-page-btn.active {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .kegiatan-page-btn.disabled {
        color: #cbd5e1;
        background: #f8fafc;
        cursor: not-allowed;
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
        .kegiatan-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .kegiatan-page-header .admin-btn-blue {
            width: 100%;
        }

        .kegiatan-pagination {
            flex-direction: column;
            align-items: stretch;
        }

        .kegiatan-pagination-links {
            justify-content: center;
            flex-wrap: wrap;
        }

        .kegiatan-pagination-info {
            text-align: center;
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

<div class="kegiatan-page-header">
    <div>
        <span class="kegiatan-eyebrow">
            Manajemen Data
        </span>

        <h3 class="kegiatan-title">
            Daftar Kegiatan
        </h3>

        <p class="kegiatan-subtitle">
            Kelola kegiatan DKM AL HIKMAH, mulai dari judul, kategori, tanggal, gambar, hingga isi artikel.
        </p>
    </div>

    <a href="{{ route('admin.kegiatan.create') }}" class="admin-btn-blue">
        <i class="bi bi-plus-lg"></i>
        Tambah Kegiatan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 mb-4">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

<div class="admin-card overflow-hidden">
    @if(($kegiatan ?? collect())->count())

        <div class="table-responsive">
            <table class="table kegiatan-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Kegiatan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($kegiatan as $post)
                        @php
                            $title = $post['title'] ?? '-';
                            $excerpt = $post['excerpt'] ?? '';
                            $categorySlug = $post['category_slug'] ?? '-';
                            $date = $post['date'] ?? '-';
                            $image = $post['image'] ?? null;
                            $idKegiatan = $post['id_kegiatan'] ?? null;
                            $slug = $post['slug'] ?? null;
                        @endphp

                        <tr>
                            <td>
                                <span class="kegiatan-number">
                                    {{ method_exists($kegiatan, 'firstItem') ? $kegiatan->firstItem() + $loop->index : $loop->iteration }}
                                </span>
                            </td>

                            <td>
                                <div class="kegiatan-post">
                                    @if(! empty($image) && ! empty($idKegiatan))
                                        <img src="{{ asset('image/kegiatan/' . $slug . '/' . $image) }}"
                                            class="kegiatan-thumb"
                                            alt="{{ $title }}">
                                    @else
                                        @if(! empty($image) && ! empty($slug))
                                            <img src="{{ asset('image/kegiatan/' . $slug . '/' . $image) }}"
                                                class="kegiatan-thumb"
                                                alt="{{ $title }}">
                                        @else
                                            <div class="kegiatan-thumb-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    @endif

                                    <div>
                                        <div class="kegiatan-post-title">
                                            {{ $title }}
                                        </div>

                                        <div class="kegiatan-post-excerpt">
                                            {{ $excerpt ?: 'Belum ada excerpt untuk kegiatan ini.' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="kegiatan-slug">
                                    {{ $categorySlug }}
                                </span>
                            </td>

                            <td>
                                <span class="kegiatan-date">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $date }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="kegiatan-action-group">
                                    @if($slug)
                                        <a href="{{ route('admin.kegiatan.edit', $slug) }}"
                                           class="kegiatan-action kegiatan-action-edit"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.kegiatan.destroy', $slug) }}"
                                              method="POST"
                                              class="m-0 delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                    class="kegiatan-action kegiatan-action-danger delete-trigger"
                                                    title="Hapus"
                                                    data-name="{{ $title }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Slug kosong</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($kegiatan, 'hasPages') && $kegiatan->hasPages())
            <div class="kegiatan-pagination">
                <div class="kegiatan-pagination-info">
                    Menampilkan {{ $kegiatan->firstItem() }} - {{ $kegiatan->lastItem() }}
                    dari {{ $kegiatan->total() }} kegiatan
                </div>

                <div class="kegiatan-pagination-links">
                    @if($kegiatan->onFirstPage())
                        <span class="kegiatan-page-btn disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $kegiatan->previousPageUrl() }}" class="kegiatan-page-btn">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @foreach($kegiatan->getUrlRange(1, $kegiatan->lastPage()) as $page => $url)
                        @if($page == $kegiatan->currentPage())
                            <span class="kegiatan-page-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="kegiatan-page-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($kegiatan->hasMorePages())
                        <a href="{{ $kegiatan->nextPageUrl() }}" class="kegiatan-page-btn">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="kegiatan-page-btn disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    @else

        <div class="kegiatan-empty">
            <div class="kegiatan-empty-icon">
                <i class="bi bi-journal-text"></i>
            </div>

            <h5 class="fw-bold mb-2">
                Belum ada kegiatan
            </h5>

            <p class="text-muted mb-4">
                Tambahkan kegiatan pertama untuk ditampilkan di halaman publik DKM.
            </p>

            <a href="{{ route('admin.kegiatan.create') }}" class="admin-btn-blue">
                <i class="bi bi-plus-lg"></i>
                Tambah Kegiatan
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
            Hapus Kegiatan?
        </h4>

        <p class="delete-modal-text">
            Kegiatan <strong id="deleteKegiatanName">ini</strong> akan dihapus dari Google Sheet.
            Gambar kegiatan juga akan ikut dihapus jika tersedia.
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
    const deleteKegiatanName = document.getElementById('deleteKegiatanName');
    const deleteCancelBtn = document.getElementById('deleteCancelBtn');
    const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');

    document.querySelectorAll('.delete-trigger').forEach((button) => {
        button.addEventListener('click', function () {
            selectedDeleteForm = this.closest('form');

            deleteKegiatanName.textContent = this.dataset.name || 'kegiatan ini';
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