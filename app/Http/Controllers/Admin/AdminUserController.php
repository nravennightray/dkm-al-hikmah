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
    private const SHEET_NAME = 'users';

    private const COLUMNS = [
        'id_user',
        'nrp',
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

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
        $allUsers = $this->getSheetCollection(self::SHEET_NAME)
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
        $users = $this->getSheetCollection(self::SHEET_NAME);

        $validated = $this->validateUser($request, $users);

        $idUser = $this->getNextUserId($users);

        $this->sheetService->appendRow($this->spreadsheetId, self::SHEET_NAME, [
            $idUser,
            $validated['nrp'],
            $validated['name'],
            $validated['email'],
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
        $data = $this->getSheetCollection(self::SHEET_NAME)
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
        $users = $this->getSheetCollection(self::SHEET_NAME);

        $data = $users->firstWhere('id_user', $user);

        if (! $data) {
            abort(404);
        }

        $validated = $this->validateUser($request, $users, $data, false);

        $password = $data['password'] ?? '';

        if (filled($validated['password'] ?? null)) {
            $password = Hash::make($validated['password']);
        }

        $payload = [
            $data['id_user'],
            $validated['nrp'],
            $validated['name'],
            $validated['email'],
            $password,
            $validated['role'],
            $validated['status'],
        ];

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            (int) $data['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $user)
    {
        $data = $this->getSheetCollection(self::SHEET_NAME)
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
            self::SHEET_NAME,
            (int) $data['_row_number']
        );

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    private function validateUser(
        Request $request,
        Collection $users,
        ?array $currentUser = null,
        bool $isCreate = true
    ): array {
        $validated = $request->validate([
            'nrp' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($users, $currentUser) {
                    $filteredUsers = $currentUser
                        ? $users->reject(fn ($item) => (string) ($item['id_user'] ?? '') === (string) ($currentUser['id_user'] ?? ''))
                        : $users;

                    $nrpExists = $filteredUsers
                        ->pluck('nrp')
                        ->map(fn ($nrp) => strtolower(trim((string) $nrp)))
                        ->contains(strtolower(trim((string) $value)));

                    if ($nrpExists) {
                        $fail('NRP sudah digunakan.');
                    }
                },
            ],

            'name' => ['required', 'string', 'max:150'],

            'email' => [
                'required',
                'email',
                'max:180',
                function ($attribute, $value, $fail) use ($users, $currentUser) {
                    $filteredUsers = $currentUser
                        ? $users->reject(fn ($item) => (string) ($item['id_user'] ?? '') === (string) ($currentUser['id_user'] ?? ''))
                        : $users;

                    $emailExists = $filteredUsers
                        ->pluck('email')
                        ->map(fn ($email) => strtolower(trim((string) $email)))
                        ->contains(strtolower(trim((string) $value)));

                    if ($emailExists) {
                        $fail('Email sudah digunakan.');
                    }
                },
            ],

            'password' => $isCreate
                ? ['required', 'string', 'min:8', 'confirmed']
                : ['nullable', 'string', 'min:8', 'confirmed'],

            'role' => ['required', Rule::in($this->roles)],
            'status' => ['required', Rule::in($this->statuses)],
        ]);

        return [
            'nrp' => trim((string) $validated['nrp']),
            'name' => trim((string) $validated['name']),
            'email' => strtolower(trim((string) $validated['email'])),
            'password' => $validated['password'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];
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
        $rows = collect(
            $this->sheetService->getSheet($this->spreadsheetId, $sheetName)
        );

        if ($rows->isEmpty()) {
            return collect();
        }

        // Remove header row.
        $rows->shift();

        return $rows
            ->map(function ($row, $index) {
                $row = collect($row)
                    ->pad(count(self::COLUMNS), '')
                    ->take(count(self::COLUMNS))
                    ->values();

                $data = collect(self::COLUMNS)
                    ->combine($row)
                    ->toArray();

                foreach ($data as $key => $value) {
                    $data[$key] = trim((string) $value);
                }

                // Header is row 1, data starts at row 2.
                $data['_row_number'] = $index + 2;

                return $data;
            })
            ->filter(function ($row) {
                return collect(self::COLUMNS)
                    ->some(fn ($column) => trim((string) ($row[$column] ?? '')) !== '');
            })
            ->values();
    }
}