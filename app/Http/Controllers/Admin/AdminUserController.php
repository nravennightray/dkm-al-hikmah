<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    protected GoogleSheetService $sheetService;

    protected string $spreadsheetId;

    private array $roles = [
        'superadmin',
        'admin',
        'karyawan',
    ];

    private array $statuses = [
        'active',
        'inactive',
    ];

    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;

        $spreadsheetId = config('google.spreadsheet_id');

        if (! $spreadsheetId) {
            throw new \Exception('Spreadsheet ID belum diatur. Cek config/google.php dan .env.');
        }

        $this->spreadsheetId = $spreadsheetId;
    }

    public function index(Request $request)
    {
        $allUsers = $this->getSheetCollection('users')
            ->sortBy(fn ($user) => (int) ($user['id_user'] ?? 0))
            ->values();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $items = $allUsers
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $users = new LengthAwarePaginator(
            $items,
            $allUsers->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roles;
        $statuses = $this->statuses;

        return view('admin.users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $users = $this->getSheetCollection('users');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:180',
                function ($attribute, $value, $fail) use ($users) {
                    $emailExists = $users
                        ->pluck('email')
                        ->map(fn ($email) => strtolower(trim($email)))
                        ->contains(strtolower(trim($value)));

                    if ($emailExists) {
                        $fail('Email sudah digunakan.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($this->roles)],
            'status' => ['required', Rule::in($this->statuses)],
        ]);

        $idUser = $this->getNextUserId($users);

        $this->sheetService->appendRow($this->spreadsheetId, 'users', [
            $idUser,
            $validated['name'],
            strtolower(trim($validated['email'])),
            Hash::make($validated['password']),
            $validated['role'],
            $validated['status'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(string $user)
    {
        $data = $this->getSheetCollection('users')
            ->firstWhere('id_user', $user);

        if (! $data) {
            abort(404);
        }

        $roles = $this->roles;
        $statuses = $this->statuses;

        return view('admin.users.edit', compact('data', 'roles', 'statuses'));
    }

    public function update(Request $request, string $user)
    {
        $users = $this->getSheetCollection('users');

        $data = $users->firstWhere('id_user', $user);

        if (! $data) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:180',
                function ($attribute, $value, $fail) use ($users, $data) {
                    $emailExists = $users
                        ->reject(fn ($item) => ($item['id_user'] ?? null) == ($data['id_user'] ?? null))
                        ->pluck('email')
                        ->map(fn ($email) => strtolower(trim($email)))
                        ->contains(strtolower(trim($value)));

                    if ($emailExists) {
                        $fail('Email sudah digunakan.');
                    }
                },
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($this->roles)],
            'status' => ['required', Rule::in($this->statuses)],
        ]);

        $password = $data['password'] ?? '';

        if (filled($validated['password'] ?? null)) {
            $password = Hash::make($validated['password']);
        }

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'users',
            $data['_row_number'],
            [
                $data['id_user'],
                $validated['name'],
                strtolower(trim($validated['email'])),
                $password,
                $validated['role'],
                $validated['status'],
            ],
            'F'
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $user)
    {
        $data = $this->getSheetCollection('users')
            ->firstWhere('id_user', $user);

        if (! $data) {
            abort(404);
        }

        $currentSheetUserId = session('sheet_user.id_user');

        if ((string) $currentSheetUserId === (string) ($data['id_user'] ?? '')) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Kamu tidak bisa menghapus akun yang sedang digunakan untuk login.');
        }

        $this->sheetService->deleteRow(
            $this->spreadsheetId,
            'users',
            $data['_row_number']
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    private function getNextUserId(Collection $users): int
    {
        $maxId = $users
            ->pluck('id_user')
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->max();

        return $maxId ? $maxId + 1 : 1;
    }

    private function getSheetCollection(string $sheetName): Collection
    {
        $rows = collect($this->sheetService->getSheet($this->spreadsheetId, $sheetName));

        if ($rows->isEmpty()) {
            return collect();
        }

        $header = collect($rows->shift())
            ->map(fn ($column) => trim($column))
            ->filter()
            ->values();

        return $rows
            ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
            ->values()
            ->map(function ($row, $index) use ($header) {
                $row = collect($row);

                if ($row->count() < $header->count()) {
                    $row = $row->pad($header->count(), null);
                }

                if ($row->count() > $header->count()) {
                    $row = $row->take($header->count());
                }

                $data = $header->combine($row)->toArray();

                $data['_row_number'] = $index + 2;

                return $data;
            });
    }
}