@extends('admin.layout.app')

@section('title', 'Info Beranda')

@section('css')
<style>
    .home-info-page {
        padding: 24px;
    }

    .home-info-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .home-info-title h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
    }

    .home-info-title p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .home-info-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .admin-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        border: none;
        background: #2563eb;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .admin-btn-primary:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .admin-alert {
        padding: 14px 16px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: 600;
    }

    .admin-alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .admin-alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .home-info-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .summary-card {
        padding: 18px;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .summary-card span {
        display: block;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .summary-card strong {
        display: block;
        font-size: 26px;
        line-height: 1;
        color: #0f172a;
    }

    .home-info-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.06);
        border: 1px solid rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .home-info-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .home-info-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1100px;
    }

    .home-info-table thead {
        background: #f8fafc;
    }

    .home-info-table th {
        padding: 16px;
        color: #475569;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .home-info-table td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
    }

    .home-info-table tbody tr:hover {
        background: #f8fafc;
    }

    .home-info-image {
        width: 82px;
        height: 58px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    .home-info-image-placeholder {
        width: 82px;
        height: 58px;
        border-radius: 12px;
        background: #f1f5f9;
        color: #94a3b8;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .home-info-main-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .home-info-subtitle {
        color: #64748b;
        font-size: 13px;
        max-width: 320px;
    }

    .home-info-description {
        max-width: 360px;
        color: #64748b;
        line-height: 1.5;
    }

    .type-badge,
    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }

    .type-info {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .type-berita {
        background: #dcfce7;
        color: #15803d;
    }

    .type-iklan {
        background: #fef3c7;
        color: #b45309;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .table-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .action-btn:hover {
        transform: translateY(-1px);
    }

    .action-edit {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .action-edit:hover {
        background: #bfdbfe;
        color: #1d4ed8;
    }

    .action-toggle-active {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-toggle-active:hover {
        background: #fecaca;
        color: #991b1b;
    }

    .action-toggle-inactive {
        background: #dcfce7;
        color: #166534;
    }

    .action-toggle-inactive:hover {
        background: #bbf7d0;
        color: #166534;
    }

    .action-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-delete:hover {
        background: #fecaca;
        color: #991b1b;
    }

    .empty-state {
        padding: 54px 20px;
        text-align: center;
    }

    .empty-state-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 16px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .empty-state h4 {
        margin-bottom: 8px;
        font-weight: 800;
        color: #0f172a;
    }

    .empty-state p {
        margin-bottom: 20px;
        color: #64748b;
    }

    .delete-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 1050;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, 0.55);
    }

    .delete-modal-backdrop.show {
        display: flex;
    }

    .delete-modal {
        width: 100%;
        max-width: 430px;
        padding: 24px;
        border-radius: 22px;
        background: #ffffff;
        box-shadow: 0 28px 70px rgba(15, 23, 42, 0.28);
    }

    .delete-modal-icon {
        width: 62px;
        height: 62px;
        border-radius: 20px;
        background: #fee2e2;
        color: #991b1b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
    }

    .delete-modal h4 {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .delete-modal p {
        color: #64748b;
        margin-bottom: 22px;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-btn-cancel,
    .modal-btn-delete {
        border: none;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .modal-btn-cancel {
        background: #f1f5f9;
        color: #334155;
    }

    .modal-btn-delete {
        background: #dc2626;
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .home-info-page {
            padding: 18px;
        }

        .home-info-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .home-info-actions,
        .admin-btn-primary {
            width: 100%;
        }

        .admin-btn-primary {
            justify-content: center;
        }

        .home-info-summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

@php
    $items = $items ?? collect();

    $totalItems = $items->count();
    $activeItems = $items->filter(fn ($item) => strtolower($item['status'] ?? '') === 'active')->count();
    $inactiveItems = $items->filter(fn ($item) => strtolower($item['status'] ?? '') === 'inactive')->count();
@endphp

<div class="home-info-page">

    <div class="home-info-header">
        <div class="home-info-title">
            <h1>Info Beranda</h1>
            <p>Kelola info, berita, atau iklan yang tampil di halaman utama website.</p>
        </div>

        <div class="home-info-actions">
            <a href="{{ route('admin.home-info.create') }}" class="admin-btn-primary">
                <i class="bi bi-plus-circle"></i>
                Tambah Info
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="home-info-summary">
        <div class="summary-card">
            <span>Total Info</span>
            <strong>{{ $totalItems }}</strong>
        </div>

        <div class="summary-card">
            <span>Aktif</span>
            <strong>{{ $activeItems }}</strong>
        </div>

        <div class="summary-card">
            <span>Nonaktif</span>
            <strong>{{ $inactiveItems }}</strong>
        </div>
    </div>

    <div class="home-info-card">
        @if($items->count())
            <div class="home-info-table-wrapper">
                <table class="home-info-table">
                    <thead>
                        <tr>
                            <th width="90">Gambar</th>
                            <th>Judul</th>
                            <th width="120">Tipe</th>
                            <th>Deskripsi</th>
                            <th width="130">Tanggal</th>
                            <th width="90">Urutan</th>
                            <th width="110">Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $item)
                            @php
                                $id = $item['id_info'] ?? '';
                                $type = strtolower($item['type'] ?? 'info');
                                $status = strtolower($item['status'] ?? 'inactive');

                                $title = $item['title'] ?? '-';
                                $subtitle = $item['subtitle'] ?? '';
                                $description = $item['description'] ?? '';
                                $image = $item['image'] ?? '';
                                $publishedAt = $item['published_at'] ?? '-';
                                $sortOrder = $item['sort_order'] ?? '0';

                                $imageUrl = !empty($image)
                                    ? asset('image/home-info/' . $image)
                                    : null;

                                $typeClass = in_array($type, ['info', 'berita', 'iklan'])
                                    ? 'type-' . $type
                                    : 'type-info';

                                $statusClass = $status === 'active'
                                    ? 'status-active'
                                    : 'status-inactive';

                                $toggleClass = $status === 'active'
                                    ? 'action-toggle-active'
                                    : 'action-toggle-inactive';

                                $toggleIcon = $status === 'active'
                                    ? 'bi-eye-slash'
                                    : 'bi-eye';

                                $toggleTitle = $status === 'active'
                                    ? 'Nonaktifkan'
                                    : 'Aktifkan';
                            @endphp

                            <tr>
                                <td>
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}"
                                             alt="{{ $title }}"
                                             class="home-info-image">
                                    @else
                                        <div class="home-info-image-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <div class="home-info-main-title">
                                        {{ $title }}
                                    </div>

                                    @if(!empty($subtitle))
                                        <div class="home-info-subtitle">
                                            {{ $subtitle }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <span class="type-badge {{ $typeClass }}">
                                        {{ $type }}
                                    </span>
                                </td>

                                <td>
                                    <div class="home-info-description">
                                        {{ \Illuminate\Support\Str::limit($description, 120) }}
                                    </div>
                                </td>

                                <td>
                                    {{ $publishedAt ?: '-' }}
                                </td>

                                <td>
                                    {{ $sortOrder }}
                                </td>

                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ $status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.home-info.edit', $id) }}"
                                           class="action-btn action-edit"
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.home-info.toggle-status', $id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="action-btn {{ $toggleClass }}"
                                                    title="{{ $toggleTitle }}">
                                                <i class="bi {{ $toggleIcon }}"></i>
                                            </button>
                                        </form>

                                        <button type="button"
                                                class="action-btn action-delete delete-trigger"
                                                title="Hapus"
                                                data-action="{{ route('admin.home-info.destroy', $id) }}"
                                                data-title="{{ $title }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-megaphone"></i>
                </div>

                <h4>Belum Ada Info Beranda</h4>

                <p>
                    Tambahkan info, berita, atau iklan untuk ditampilkan pada halaman utama.
                </p>

                <a href="{{ route('admin.home-info.create') }}" class="admin-btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Info
                </a>
            </div>
        @endif
    </div>
</div>

<div class="delete-modal-backdrop" id="deleteModal">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="bi bi-trash"></i>
        </div>

        <h4>Hapus Info Beranda?</h4>

        <p id="deleteModalText">
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="delete-modal-actions">
                <button type="button" class="modal-btn-cancel" id="deleteCancel">
                    Batal
                </button>

                <button type="submit" class="modal-btn-delete">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteModalText = document.getElementById('deleteModalText');
        const deleteCancel = document.getElementById('deleteCancel');

        document.querySelectorAll('.delete-trigger').forEach(function (button) {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-action');
                const title = this.getAttribute('data-title');

                deleteForm.setAttribute('action', action);
                deleteModalText.textContent = 'Info "' + title + '" akan dihapus permanen.';

                modal.classList.add('show');
            });
        });

        deleteCancel.addEventListener('click', function () {
            modal.classList.remove('show');
            deleteForm.removeAttribute('action');
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.remove('show');
                deleteForm.removeAttribute('action');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                modal.classList.remove('show');
                deleteForm.removeAttribute('action');
            }
        });
    });
</script>
@endsection