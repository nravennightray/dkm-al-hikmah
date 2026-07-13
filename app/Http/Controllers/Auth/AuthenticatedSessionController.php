<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\GoogleSheetService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $sheetService = app(GoogleSheetService::class);

        $rows = collect(
            $sheetService->getSheet(
                config('google.spreadsheet_id'),
                'users'
            )
        );

        if ($rows->isEmpty()) {
            throw ValidationException::withMessages([
                'email' => 'Data user tidak tersedia.',
            ]);
        }

        $header = collect($rows->shift())
            ->map(fn ($column) => trim($column))
            ->filter()
            ->values();

        $users = $rows
            ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
            ->map(function ($row) use ($header) {
                $row = collect($row);

                if ($row->count() < $header->count()) {
                    $row = $row->pad($header->count(), null);
                }

                if ($row->count() > $header->count()) {
                    $row = $row->take($header->count());
                }

                return $header
                    ->combine($row)
                    ->toArray();
            })
            ->values();

        $credential = trim((string) $request->email);

        $sheetUser = $users->first(function ($user) use ($credential) {
            $email = strtolower(trim((string) ($user['email'] ?? '')));
            $nrp = strtolower(trim((string) ($user['nrp'] ?? '')));

            return $email === strtolower($credential) || $nrp === strtolower($credential);
        });

        if (! $sheetUser) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password tidak sesuai.',
            ]);
        }

        if (strtolower(trim($sheetUser['status'] ?? '')) !== 'active') {
            throw ValidationException::withMessages([
                'email' => 'Akun ini tidak aktif.',
            ]);
        }

        $hashedPassword = trim($sheetUser['password'] ?? '');

        if (
            empty($hashedPassword) ||
            ! preg_match('/^\$2y\$|\$2a\$|\$2b\$/', $hashedPassword)
        ) {
            throw ValidationException::withMessages([
                'email' => 'Password user di Google Sheet belum menggunakan format bcrypt.',
            ]);
        }

        if (! Hash::check($request->password, $hashedPassword)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password tidak sesuai.',
            ]);
        }

        $authEmail = $sheetUser['email'] ?: $sheetUser['nrp'] ?: ('user-' . ($sheetUser['id_user'] ?? 'unknown'));

        $user = User::firstOrCreate(
            [
                'email' => $authEmail,
            ],
            [
                'name' => $sheetUser['name'] ?? 'Admin DKM',
                'password' => str()->random(32),
            ]
        );

        $user->forceFill([
            'name' => $sheetUser['name'] ?? 'Admin DKM',
        ])->save();

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        $request->session()->put('sheet_user', [
            'id_user' => $sheetUser['id_user'] ?? null,
            'name' => $sheetUser['name'] ?? 'Admin DKM',
            'email' => $sheetUser['email'] ?: $sheetUser['nrp'] ?: '',
            'role' => $sheetUser['role'] ?? 'admin',
            'status' => $sheetUser['status'] ?? 'active',
        ]);

        return redirect()->intended(route('admin.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
