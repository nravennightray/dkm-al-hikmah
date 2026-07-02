<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminHomeInfoController extends Controller
{
    private const SHEET_NAME = 'home_infos';

    private const IMAGE_DIRECTORY = 'image/home-info';

    private const COLUMNS = [
        'id_info',
        'type',
        'title',
        'subtitle',
        'description',
        'image',
        'published_at',
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
        $items = $this->getItems();

        return view('admin.home-info.index', compact('items'));
    }

    public function create()
    {
        $item = null;

        return view('admin.home-info.form', compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $validated['id_info'] = $this->generateNextId();
        $validated['image'] = '';

        if ($request->hasFile('image_upload')) {
            $validated['image'] = $this->storeImage($request, $validated);
        }

        $payload = $this->buildPayload($validated);

        $this->sheetService->appendRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            $payload
        );

        return redirect()
            ->route('admin.home-info.index')
            ->with('success', 'Info beranda berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $item = $this->findItemOrFail($id);

        return view('admin.home-info.form', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = $this->findItemOrFail($id);

        $validated = $this->validateRequest($request, $id);

        $validated['id_info'] = $item['id_info'];
        $validated['image'] = $item['image'] ?? '';

        if ($request->hasFile('image_upload')) {
            $newImage = $this->storeImage($request, $validated);

            if (! empty($validated['image'])) {
                $this->deleteImage($validated['image']);
            }

            $validated['image'] = $newImage;
        }

        $payload = $this->buildPayload($validated);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            (int) $item['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.home-info.index')
            ->with('success', 'Info beranda berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $item = $this->findItemOrFail($id);

        if (! empty($item['image'])) {
            $this->deleteImage($item['image']);
        }

        $this->sheetService->deleteRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            (int) $item['_row_number']
        );

        return redirect()
            ->route('admin.home-info.index')
            ->with('success', 'Info beranda berhasil dihapus.');
    }

    public function toggleStatus(string $id)
    {
        $item = $this->findItemOrFail($id);

        $currentStatus = strtolower($item['status'] ?? 'inactive');

        $item['status'] = $currentStatus === 'active'
            ? 'inactive'
            : 'active';

        $payload = $this->buildPayload($item);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            (int) $item['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.home-info.index')
            ->with('success', 'Status info beranda berhasil diperbarui.');
    }

    private function validateRequest(Request $request, ?string $id = null): array
    {
        return $request->validate(
            [
                'type' => 'required|in:info,berita,iklan',
                'title' => 'required|string|max:150',
                'subtitle' => 'nullable|string|max:150',
                'description' => 'required|string|max:500',
                'published_at' => 'nullable|date',
                'sort_order' => 'nullable|integer|min:0',
                'status' => 'required|in:active,inactive',
                'image_upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'type.required' => 'Tipe info wajib dipilih.',
                'type.in' => 'Tipe info tidak valid.',
                'title.required' => 'Judul wajib diisi.',
                'description.required' => 'Deskripsi wajib diisi.',
                'status.required' => 'Status wajib dipilih.',
                'status.in' => 'Status tidak valid.',
                'image_upload.image' => 'File harus berupa gambar.',
                'image_upload.mimes' => 'Gambar harus berformat JPG, JPEG, PNG, atau WEBP.',
                'image_upload.max' => 'Ukuran gambar maksimal 2MB.',
            ]
        );
    }

    private function getItems(): Collection
    {
        return $this->getSheetCollection()
            ->sortBy(fn ($item) => (int) ($item['sort_order'] ?? 999))
            ->values();
    }

    private function getSheetCollection(): Collection
    {
        $rows = collect(
            $this->sheetService->getSheet($this->spreadsheetId, self::SHEET_NAME)
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

                // Actual Google Sheet row number.
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

    private function findItemOrFail(string $id): array
    {
        $item = $this->getSheetCollection()
            ->firstWhere('id_info', $id);

        if (! $item) {
            abort(404);
        }

        return $item;
    }

    private function generateNextId(): string
    {
        $maxId = $this->getSheetCollection()
            ->pluck('id_info')
            ->map(fn ($id) => (int) $id)
            ->max();

        return (string) (($maxId ?? 0) + 1);
    }

    private function buildPayload(array $data): array
    {
        return collect(self::COLUMNS)
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

    private function storeImage(Request $request, array $data): string
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            throw ValidationException::withMessages([
                'image_upload' => 'Server tidak mendukung proses gambar WebP.',
            ]);
        }

        $file = $request->file('image_upload');

        if (! $file || ! $file->isValid()) {
            throw ValidationException::withMessages([
                'image_upload' => 'File gambar tidak valid.',
            ]);
        }

        $folder = public_path(self::IMAGE_DIRECTORY);

        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $baseName = $data['title'] ?? $data['subtitle'] ?? uniqid('home-info-', true);

        $fileName = Str::slug($baseName) . '-' . time() . '.webp';

        $contents = file_get_contents($file->getRealPath());

        if ($contents === false) {
            throw ValidationException::withMessages([
                'image_upload' => 'Gagal membaca file gambar.',
            ]);
        }

        $image = imagecreatefromstring($contents);

        if (! $image) {
            throw ValidationException::withMessages([
                'image_upload' => 'Gagal memproses file gambar.',
            ]);
        }

        $saved = imagewebp($image, $folder . DIRECTORY_SEPARATOR . $fileName, 85);

        imagedestroy($image);

        if (! $saved) {
            throw ValidationException::withMessages([
                'image_upload' => 'Gagal menyimpan gambar.',
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