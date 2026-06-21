@extends('admin.layout.app')

@section('title', 'Edit User')
@section('page_title', 'Edit User')
@section('page_subtitle', 'Perbarui akun pengguna admin DKM AL HIKMAH')

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

    .user-summary-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        margin-bottom: 24px;
    }

    .user-summary-avatar {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: #eff6ff;
        color: #2563eb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 900;
        flex-shrink: 0;
    }

    .user-summary-name {
        color: #0f172a;
        font-size: 16px;
        font-weight: 850;
        line-height: 1.3;
    }

    .user-summary-email {
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
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

    .password-field {
        position: relative;
    }

    .password-field .admin-form-control {
        padding-right: 48px;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 10px;
        background: transparent;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .password-toggle:hover {
        background: #eff6ff;
        color: #2563eb;
    }
</style>
@endsection

@section('content')

@php
    $userName = $data['name'] ?? 'User';
    $userEmail = $data['email'] ?? '-';
    $initial = strtoupper(substr($userName ?: 'U', 0, 1));
@endphp

<div class="form-page-header">
    <div>
        <span class="form-eyebrow">
            Form User
        </span>

        <h3 class="form-title">
            Edit User
        </h3>

        <p class="form-subtitle">
            Perbarui data akun <strong>{{ $userName }}</strong>, role akses, status login, atau password baru bila diperlukan.
        </p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="admin-btn-light">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="admin-card admin-form-card p-4">
    <div class="user-summary-card">
        <div class="user-summary-avatar">
            {{ $initial }}
        </div>

        <div>
            <div class="user-summary-name">
                {{ $userName }}
            </div>

            <div class="user-summary-email">
                {{ $userEmail }}
            </div>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $data['id_user']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="admin-form-grid">
            <div>
                <label for="name" class="admin-form-label">
                    Nama User
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $data['name'] ?? '') }}"
                       class="admin-form-control"
                       placeholder="Contoh: Admin DKM"
                       required>

                @error('name')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="email" class="admin-form-label">
                    Email
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $data['email'] ?? '') }}"
                       class="admin-form-control"
                       placeholder="Contoh: admin@dkmalhikmah.com"
                       required>

                @error('email')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="role" class="admin-form-label">
                    Role
                </label>

                <select id="role"
                        name="role"
                        class="admin-form-control"
                        required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}"
                            @selected(old('role', $data['role'] ?? '') === $role)>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>

                @error('role')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="status" class="admin-form-label">
                    Status
                </label>

                <select id="status"
                        name="status"
                        class="admin-form-control"
                        required>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}"
                            @selected(old('status', $data['status'] ?? '') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                @error('status')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password" class="admin-form-label">
                    Password Baru
                </label>

                <div class="password-field">
                    <input type="password"
                        id="password"
                        name="password"
                        class="admin-form-control"
                        placeholder="Kosongkan jika tidak ingin mengganti">

                    <button type="button"
                            class="password-toggle"
                            data-target="password"
                            aria-label="Tampilkan password baru">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <div class="admin-form-help">
                    Kosongkan jika password tidak ingin diubah. Minimal 8 karakter jika diisi.
                </div>

                @error('password')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="admin-form-label">
                    Konfirmasi Password Baru
                </label>

                <div class="password-field">
                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="admin-form-control"
                        placeholder="Ulangi password baru">

                    <button type="button"
                            class="password-toggle"
                            data-target="password_confirmation"
                            aria-label="Tampilkan konfirmasi password baru">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                @error('password_confirmation')
                    <div class="admin-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.users.index') }}" class="admin-btn-light">
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
    document.querySelectorAll('.password-toggle').forEach((button) => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (!input) {
                return;
            }

            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('bi-eye', !isPassword);
            icon.classList.toggle('bi-eye-slash', isPassword);
        });
    });
</script>
@endsection