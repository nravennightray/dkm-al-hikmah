<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminInfaqController extends Controller
{
    private const SETTINGS_SHEET = 'infaq_settings';

    private const ACCOUNTS_SHEET = 'infaq_bank_accounts';

    private const IMAGE_DIRECTORY = 'image/infaq';

    private const MAX_ACCOUNTS = 3;

    private const SETTINGS_COLUMNS = [
        'key',
        'hero_badge',
        'hero_title',
        'hero_quote',
        'qris_badge',
        'qris_title',
        'qris_description',
        'qris_image',
        'qris_note',
        'bank_title',
        'bank_description',
        'transfer_note',
        'status',
    ];

    private const ACCOUNT_COLUMNS = [
        'id_account',
        'bank',
        'number',
        'holder',
        'sort_order',
        'status',
    ];

    protected GoogleSheetService $sheetService;

    protected string $spreadsheetId;

    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;
        $this->spreadsheetId = config('google.spreadsheet_id');

        if (! $this->spreadsheetId) {
            throw new \Exception('Spreadsheet ID belum diatur.');
        }
    }

    public function index()
    {
        $settings = $this->getSettings();
        $accounts = $this->getAccounts();

        return view('admin.infaq.index', compact(
            'settings',
            'accounts'
        ));
    }

    public function updateSettings(Request $request)
    {
        $settings = $this->getSettings();

        $validated = $request->validate(
            [
                'hero_badge' => 'required|string|max:150',
                'hero_title' => 'required|string|max:150',
                'hero_quote' => 'nullable|string|max:255',

                'qris_badge' => 'required|string|max:150',
                'qris_title' => 'required|string|max:150',
                'qris_description' => 'required|string|max:500',
                'qris_note' => 'nullable|string|max:500',
                'qris_image_upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

                'bank_title' => 'required|string|max:150',
                'bank_description' => 'required|string|max:500',
                'transfer_note' => 'nullable|string|max:500',

                'status' => 'required|in:active,inactive',
            ],
            [
                'hero_badge.required' => 'Badge hero wajib diisi.',
                'hero_title.required' => 'Judul hero wajib diisi.',
                'qris_badge.required' => 'Badge QRIS wajib diisi.',
                'qris_title.required' => 'Judul QRIS wajib diisi.',
                'qris_description.required' => 'Deskripsi QRIS wajib diisi.',
                'bank_title.required' => 'Judul bank wajib diisi.',
                'bank_description.required' => 'Deskripsi bank wajib diisi.',
                'status.required' => 'Status wajib dipilih.',
                'status.in' => 'Status tidak valid.',
                'qris_image_upload.image' => 'File QRIS harus berupa gambar.',
                'qris_image_upload.mimes' => 'Gambar QRIS harus berformat JPG, JPEG, PNG, atau WEBP.',
                'qris_image_upload.max' => 'Ukuran gambar QRIS maksimal 2MB.',
            ]
        );

        $validated['key'] = 'main';
        $validated['qris_image'] = $settings['qris_image'] ?? '';

        if ($request->hasFile('qris_image_upload')) {
            $newImage = $this->storeImage(
                $request,
                'qris_image_upload',
                $validated['qris_title'] ?? 'qris-infaq'
            );

            if (! empty($validated['qris_image'])) {
                $this->deleteImage($validated['qris_image']);
            }

            $validated['qris_image'] = $newImage;
        }

        $payload = $this->buildPayload(self::SETTINGS_COLUMNS, $validated);

        if (! empty($settings['_row_number'])) {
            $this->sheetService->updateRow(
                $this->spreadsheetId,
                self::SETTINGS_SHEET,
                (int) $settings['_row_number'],
                $payload
            );
        } else {
            $this->sheetService->appendRow(
                $this->spreadsheetId,
                self::SETTINGS_SHEET,
                $payload
            );
        }

        return redirect()
            ->route('admin.infaq.index')
            ->with('success', 'Pengaturan infaq berhasil diperbarui.');
    }

    public function createAccount()
    {
        if ($this->getAccounts()->count() >= self::MAX_ACCOUNTS) {
            return redirect()
                ->route('admin.infaq.index')
                ->with('error', 'Maksimal hanya 3 rekening bank.');
        }

        $account = null;

        return view('admin.infaq.account-form', compact('account'));
    }

    public function storeAccount(Request $request)
    {
        if ($this->getAccounts()->count() >= self::MAX_ACCOUNTS) {
            return redirect()
                ->route('admin.infaq.index')
                ->with('error', 'Maksimal hanya 3 rekening bank.');
        }

        $validated = $this->validateAccountRequest($request);

        $validated['id_account'] = $this->generateNextAccountId();

        $payload = $this->buildPayload(self::ACCOUNT_COLUMNS, $validated);

        $this->sheetService->appendRow(
            $this->spreadsheetId,
            self::ACCOUNTS_SHEET,
            $payload
        );

        return redirect()
            ->route('admin.infaq.index')
            ->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function editAccount(string $id)
    {
        $account = $this->findAccountOrFail($id);

        return view('admin.infaq.account-form', compact('account'));
    }

    public function updateAccount(Request $request, string $id)
    {
        $account = $this->findAccountOrFail($id);

        $validated = $this->validateAccountRequest($request);

        $validated['id_account'] = $account['id_account'];

        $payload = $this->buildPayload(self::ACCOUNT_COLUMNS, $validated);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            self::ACCOUNTS_SHEET,
            (int) $account['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.infaq.index')
            ->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroyAccount(string $id)
    {
        $account = $this->findAccountOrFail($id);

        $this->sheetService->deleteRow(
            $this->spreadsheetId,
            self::ACCOUNTS_SHEET,
            (int) $account['_row_number']
        );

        return redirect()
            ->route('admin.infaq.index')
            ->with('success', 'Rekening bank berhasil dihapus.');
    }

    public function toggleAccountStatus(string $id)
    {
        $account = $this->findAccountOrFail($id);

        $currentStatus = strtolower($account['status'] ?? 'inactive');

        $account['status'] = $currentStatus === 'active'
            ? 'inactive'
            : 'active';

        $payload = $this->buildPayload(self::ACCOUNT_COLUMNS, $account);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            self::ACCOUNTS_SHEET,
            (int) $account['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.infaq.index')
            ->with('success', 'Status rekening berhasil diperbarui.');
    }

    private function validateAccountRequest(Request $request): array
    {
        return $request->validate(
            [
                'bank' => 'required|string|max:150',
                'number' => 'required|string|max:100',
                'holder' => 'required|string|max:150',
                'sort_order' => 'nullable|integer|min:0',
                'status' => 'required|in:active,inactive',
            ],
            [
                'bank.required' => 'Nama bank wajib diisi.',
                'number.required' => 'Nomor rekening wajib diisi.',
                'holder.required' => 'Nama pemilik rekening wajib diisi.',
                'status.required' => 'Status wajib dipilih.',
                'status.in' => 'Status tidak valid.',
            ]
        );
    }

    private function getSettings(): array
    {
        $settings = $this->getSheetCollection(
            self::SETTINGS_SHEET,
            self::SETTINGS_COLUMNS
        )
            ->firstWhere('key', 'main');

        if ($settings) {
            return $settings;
        }

        return [
            'key' => 'main',
            'hero_badge' => 'Dukung Kebaikan',
            'hero_title' => 'Infaq & Sedekah',
            'hero_quote' => '"Harta tidak akan berkurang karena sedekah." (HR. Muslim)',
            'qris_badge' => 'QRIS Infaq',
            'qris_title' => 'Scan QRIS Infaq',
            'qris_description' => 'Salurkan infaq dengan mudah melalui QRIS resmi DKM Al Hikmah.',
            'qris_image' => '',
            'qris_note' => 'Mendukung semua e-wallet seperti GoPay, OVO, DANA, LinkAja, dan mobile banking.',
            'bank_title' => 'Transfer Bank',
            'bank_description' => 'Anda dapat menyalurkan donasi melalui transfer ke rekening resmi DKM Al Hikmah di bawah ini:',
            'transfer_note' => 'Mohon sertakan kode unik atau melakukan konfirmasi ke Bendahara DKM setelah melakukan transfer untuk mempermudah pencatatan laporan keuangan.',
            'status' => 'active',
        ];
    }

    private function getAccounts(): Collection
    {
        return $this->getSheetCollection(
            self::ACCOUNTS_SHEET,
            self::ACCOUNT_COLUMNS
        )
            ->sortBy(fn ($item) => (int) ($item['sort_order'] ?? 999))
            ->values();
    }

    private function findAccountOrFail(string $id): array
    {
        $account = $this->getAccounts()
            ->firstWhere('id_account', $id);

        if (! $account) {
            abort(404);
        }

        return $account;
    }

    private function generateNextAccountId(): string
    {
        $maxId = $this->getAccounts()
            ->pluck('id_account')
            ->map(fn ($id) => (int) $id)
            ->max();

        return (string) (($maxId ?? 0) + 1);
    }

    private function getSheetCollection(string $sheetName, array $columns): Collection
    {
        try {
            $rows = collect(
                $this->sheetService->getSheet($this->spreadsheetId, $sheetName)
            );
        } catch (\Throwable $e) {
            return collect();
        }

        if ($rows->isEmpty()) {
            return collect();
        }

        // Remove header row.
        $rows->shift();

        return $rows
            ->map(function ($row, $index) use ($columns) {
                $row = collect($row)
                    ->pad(count($columns), '')
                    ->take(count($columns))
                    ->values();

                $data = collect($columns)
                    ->combine($row)
                    ->toArray();

                foreach ($data as $key => $value) {
                    $data[$key] = trim((string) $value);
                }

                // Header is row 1, data starts from row 2.
                $data['_row_number'] = $index + 2;

                return $data;
            })
            ->filter(function ($row) use ($columns) {
                return collect($columns)
                    ->some(fn ($column) => trim((string) ($row[$column] ?? '')) !== '');
            })
            ->values();
    }

    private function buildPayload(array $columns, array $data): array
    {
        return collect($columns)
            ->map(function ($column) use ($data) {
                if ($column === 'sort_order') {
                    return (string) ($data[$column] ?? 0);
                }

                if ($column === 'status') {
                    return $data[$column] ?? 'inactive';
                }

                return $data[$column] ?? '';
            })
            ->toArray();
    }

    private function storeImage(Request $request, string $fieldName, string $baseName): string
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            throw ValidationException::withMessages([
                $fieldName => 'Server tidak mendukung proses gambar WebP.',
            ]);
        }

        $file = $request->file($fieldName);

        if (! $file || ! $file->isValid()) {
            throw ValidationException::withMessages([
                $fieldName => 'File gambar tidak valid.',
            ]);
        }

        $folder = public_path(self::IMAGE_DIRECTORY);

        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $fileName = Str::slug($baseName) . '-' . time() . '.webp';

        $contents = file_get_contents($file->getRealPath());

        if ($contents === false) {
            throw ValidationException::withMessages([
                $fieldName => 'Gagal membaca file gambar.',
            ]);
        }

        $image = imagecreatefromstring($contents);

        if (! $image) {
            throw ValidationException::withMessages([
                $fieldName => 'Gagal memproses file gambar.',
            ]);
        }

        $saved = imagewebp($image, $folder . DIRECTORY_SEPARATOR . $fileName, 85);

        imagedestroy($image);

        if (! $saved) {
            throw ValidationException::withMessages([
                $fieldName => 'Gagal menyimpan gambar.',
            ]);
        }

        return $fileName;
    }

    private function deleteImage(?string $fileName): void
    {
        if (empty($fileName)) {
            return;
        }

        $path = public_path(self::IMAGE_DIRECTORY . DIRECTORY_SEPARATOR . $fileName);

        if (is_file($path)) {
            @unlink($path);
        }
    }
}