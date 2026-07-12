@extends('admin.layout.app')

@section('title', 'Users')
@section('page_title', 'Users')
@section('page_subtitle', 'Kelola akun pengguna admin DKM AL HIKMAH')

@section('css')
<style>
    .users-page-header {
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

    .users-eyebrow {
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

    .users-title {
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 850;
        color: #0f172a;
    }

    .users-subtitle {
        max-width: 620px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.7;
    }

    .users-table {
        width: 100%;
    }

    .users-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 16px;
        white-space: nowrap;
    }

    .users-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #eef2f7;
    }

    .users-table tr:last-child td {
        border-bottom: none;
    }

    .users-number {
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

    .user-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 240px;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 900;
        flex-shrink: 0;
    }

    .user-name {
        margin-bottom: 4px;
        color: #0f172a;
        font-size: 14px;
        font-weight: 850;
        line-height: 1.3;
    }

    .user-email {
        color: #64748b;
        font-size: 12px;
        line-height: 1.3;
    }

    .user-role-badge,
    .user-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .user-role-superadmin {
        background: #fef3c7;
        color: #92400e;
    }

    .user-role-admin {
        background: #eff6ff;
        color: #2563eb;
    }

    .user-role-karyawan {
        background: #f0fdf4;
        color: #15803d;
    }

    .user-status-active {
        background: #ecfdf5;
        color: #047857;
    }

    .user-status-inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    .users-action {
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

    .users-action i {
        font-size: 15px;
        line-height: 1;
    }

    .users-action-edit {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.12);
    }

    .users-action-edit:hover {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .users-action-danger {
        color: #dc2626;
        background: #fef2f2;
        border-color: rgba(220, 38, 38, 0.12);
    }

    .users-action-danger:hover {
        color: #ffffff;
        background: #dc2626;
        border-color: #dc2626;
    }

    .users-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
    }

    .users-action-group form {
        display: inline-flex;
        margin: 0;
    }

    .users-empty {
        padding: 56px 24px;
        text-align: center;
    }

    .users-empty-icon {
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

    .users-pagination {
        padding: 18px 20px;
        border-top: 1px solid #eef2f7;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .users-pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
    }

    .users-pagination-links {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .users-page-btn {
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

    .users-page-btn:hover {
        color: #2563eb;
        background: #eff6ff;
        border-color: rgba(37, 99, 235, 0.22);
    }

    .users-page-btn.active {
        color: #ffffff;
        background: #2563eb;
        border-color: #2563eb;
    }

    .users-page-btn.disabled {
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
        .users-page-header {
            align-items: stretch;
            flex-direction: column;
        }

        .users-page-header .admin-btn-blue {
            width: 100%;
        }

        .users-pagination {
            flex-direction: column;
            align-items: stretch;
        }

        .users-pagination-links {
            justify-content: center;
            flex-wrap: wrap;
        }

        .users-pagination-info {
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

    .users-table th,
    .users-table td {
        vertical-align: middle;
    }

    .users-table th.text-center,
    .users-table td.text-center {
        text-align: center;
    }

    .user-role-badge,
    .user-status-badge {
        justify-content: center;
    }

    .user-nrp-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e5e7eb;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .user-nrp-badge i {
        color: #2563eb;
    }
</style>
@endsection

@section('content')

<div class="users-page-header">
    <div>
        <span class="users-eyebrow">
            Manajemen Akses
        </span>

        <h3 class="users-title">
            Daftar Users
        </h3>

        <p class="users-subtitle">
            Kelola akun pengguna, NRP, role akses, dan status login untuk admin portal DKM AL HIKMAH.
        </p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="admin-btn-blue">
        <i class="bi bi-plus-lg"></i>
        Tambah User
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-4 mb-4">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-0 rounded-4 mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ session('error') }}
    </div>
@endif

<div class="admin-card overflow-hidden">
    @if(($users ?? collect())->count())

        <div class="table-responsive">
            <table class="table users-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 70px;">No</th>
                        <th>User</th>
                        <th class="text-center" style="width: 150px;">NRP</th>
                        <th class="text-center" style="width: 150px;">Role</th>
                        <th class="text-center" style="width: 140px;">Status</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        @php
                            $idUser = $user['id_user'] ?? null;
                            $nrp = $user['nrp'] ?? '-';
                            $name = $user['name'] ?? '-';
                            $email = $user['email'] ?? '-';
                            $role = strtolower($user['role'] ?? 'admin');
                            $status = strtolower($user['status'] ?? 'inactive');
                            $initial = strtoupper(substr($name !== '-' ? $name : 'A', 0, 1));

                            $rowNumber = method_exists($users, 'firstItem')
                                ? $users->firstItem() + $loop->index
                                : $loop->iteration;
                        @endphp

                        <tr>
                            <td class="text-center">
                                <span class="users-number">
                                    {{ $rowNumber }}
                                </span>
                            </td>

                            <td>
                                <div class="user-profile">
                                    <div class="user-avatar">
                                        {{ $initial }}
                                    </div>

                                    <div>
                                        <div class="user-name">
                                            {{ $name }}
                                        </div>

                                        <div class="user-email">
                                            {{ $email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="user-nrp-badge">
                                    <i class="bi bi-person-vcard"></i>
                                    {{ $nrp ?: '-' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="user-role-badge user-role-{{ $role }}">
                                    <i class="bi bi-person-badge"></i>
                                    {{ $role }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="user-status-badge user-status-{{ $status }}">
                                    @if($status === 'active')
                                        <i class="bi bi-check-circle"></i>
                                    @else
                                        <i class="bi bi-x-circle"></i>
                                    @endif

                                    {{ $status }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="users-action-group">
                                    @if($idUser)
                                        <a href="{{ route('admin.users.edit', $idUser) }}"
                                           class="users-action users-action-edit"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $idUser) }}"
                                              method="POST"
                                              class="m-0 delete-form">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                    class="users-action users-action-danger delete-trigger"
                                                    title="Hapus"
                                                    data-name="{{ $name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">ID kosong</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(method_exists($users, 'hasPages') && $users->hasPages())
            <div class="users-pagination">
                <div class="users-pagination-info">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }}
                    dari {{ $users->total() }} user
                </div>

                <div class="users-pagination-links">
                    @if($users->onFirstPage())
                        <span class="users-page-btn disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="users-page-btn">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="users-page-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="users-page-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="users-page-btn">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="users-page-btn disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    @else

        <div class="users-empty">
            <div class="users-empty-icon">
                <i class="bi bi-people"></i>
            </div>

            <h5 class="fw-bold mb-2">
                Belum ada user
            </h5>

            <p class="text-muted mb-4">
                Tambahkan user pertama untuk mengelola akses admin portal.
            </p>

            <a href="{{ route('admin.users.create') }}" class="admin-btn-blue">
                <i class="bi bi-plus-lg"></i>
                Tambah User
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
            Hapus User?
        </h4>

        <p class="delete-modal-text">
            User <strong id="deleteUserName">ini</strong> akan dihapus dari Google Sheet.
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
    const deleteUserName = document.getElementById('deleteUserName');
    const deleteCancelBtn = document.getElementById('deleteCancelBtn');
    const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');

    document.querySelectorAll('.delete-trigger').forEach((button) => {
        button.addEventListener('click', function () {
            selectedDeleteForm = this.closest('form');

            deleteUserName.textContent = this.dataset.name || 'user ini';
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