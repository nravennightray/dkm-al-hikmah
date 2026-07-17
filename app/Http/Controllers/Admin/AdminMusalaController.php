<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class AdminMusalaController extends Controller
{
    private const SHEET_NAME = 'musala';

    private const IMAGE_DIRECTORY = 'image/musala';

    private const EXPECTED_COLUMNS = [
        'slug',
        'title',
        'location',
        'capacity',
        'facilities',
        'desc',
        'image',
    ];

    protected GoogleSheetService $sheetService;

    protected string $spreadsheetId;

    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;

        $spreadsheetId = config('google.spreadsheet_id');

        if (! $spreadsheetId) {
            throw new \Exception('Spreadsheet ID belum diatur. Cek config/google.php dan .env.');
        }

        $this->spreadsheetId = $spreadsheetId;
    }

    public function index()
    {
        $musala = $this->getMusalaCollection();

        return view('admin.musala.index', compact('musala'));
    }

    public function create()
    {
        return view('admin.musala.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateMusala($request);

        $baseSlug = $this->makeSlug($validated['title']);
        $slug = $this->makeUniqueSlug($baseSlug);

        $imageName = '';

        if ($request->hasFile('image')) {
            $imageName = $this->storeImage($request, $slug);
        }

        $payload = $this->buildCreateSheetPayload($slug, $validated, $imageName);

        $this->sheetService->appendRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            $payload
        );

        return redirect()
            ->route('admin.musala.index')
            ->with('success', 'Musala berhasil ditambahkan.');
    }

    public function edit(string $slug)
    {
        $musala = $this->findMusalaOrFail($slug);

        return view('admin.musala.edit', compact('musala'));
    }

    public function update(Request $request, string $slug)
    {
        $musala = $this->findMusalaOrFail($slug);

        $validated = $this->validateMusala($request);

        $imageName = $this->cleanImageName($musala['image'] ?? '');

        if ($request->hasFile('image')) {
            $imageName = $this->storeImage($request, $musala['slug']);
        }

        $payload = $this->buildUpdateSheetPayload($musala, $validated, $imageName);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            (int) $musala['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.musala.index')
            ->with('success', 'Musala berhasil diperbarui.');
    }

    public function destroy(string $slug)
    {
        $musala = $this->findMusalaOrFail($slug);

        $this->deleteImageIfExists($musala['image'] ?? '');

        $this->sheetService->deleteRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            (int) $musala['_row_number']
        );

        return redirect()
            ->route('admin.musala.index')
            ->with('success', 'Musala berhasil dihapus.');
    }

    private function validateMusala(Request $request): array
    {
        $validated = $request->validate([
            'title' => 'required|string|max:180',
            'location' => 'required|string|max:255',
            'capacity' => 'required|string|max:100',
            'facilities' => 'required|string',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $facilities = $this->normalizeFacilities($validated['facilities'] ?? '');

        if ($facilities === '') {
            throw ValidationException::withMessages([
                'facilities' => 'Fasilitas tidak boleh kosong.',
            ]);
        }

        return [
            'title' => trim($validated['title']),
            'location' => trim($validated['location']),
            'capacity' => trim($validated['capacity']),
            'facilities' => $facilities,
            'desc' => trim($validated['desc'] ?? ''),
        ];
    }

    private function buildCreateSheetPayload(string $slug, array $validated, ?string $imageName): array
    {
        $payload = [
            $slug,
            $validated['title'] ?? '',
            $validated['location'] ?? '',
            $validated['capacity'] ?? '',
            $validated['facilities'] ?? '',
            $validated['desc'] ?? '',
            $imageName ?? '',
        ];

        return $this->normalizePayload($payload);
    }

    private function buildUpdateSheetPayload(array $musala, array $validated, ?string $imageName): array
    {
        $payload = [
            $musala['slug'] ?? '',
            $validated['title'] ?? '',
            $validated['location'] ?? '',
            $validated['capacity'] ?? '',
            $validated['facilities'] ?? '',
            $validated['desc'] ?? '',
            $imageName ?? '',
        ];

        return $this->normalizePayload($payload);
    }

    private function normalizePayload(array $payload): array
    {
        return array_values(
            array_slice(
                array_pad($payload, count(self::EXPECTED_COLUMNS), ''),
                0,
                count(self::EXPECTED_COLUMNS)
            )
        );
    }

    private function findMusalaOrFail(string $slug): array
    {
        $musala = $this->getMusalaCollection()
            ->firstWhere('slug', $slug);

        abort_if(! $musala, 404);

        return $musala;
    }

    private function getMusalaCollection(): Collection
    {
        return $this->getSheetCollection(self::SHEET_NAME);
    }

    private function getSheetCollection(string $sheetName): Collection
    {
        $rows = collect(
            $this->sheetService->getSheet($this->spreadsheetId, $sheetName)
        );

        if ($rows->isEmpty()) {
            return collect();
        }

        $rows->shift();

        return $rows
            ->map(function ($row, $index) {
                $row = collect($row)
                    ->pad(count(self::EXPECTED_COLUMNS), '')
                    ->take(count(self::EXPECTED_COLUMNS))
                    ->values();

                $data = collect(self::EXPECTED_COLUMNS)
                    ->combine($row)
                    ->toArray();

                $data['_row_number'] = $index + 2;

                $data['slug'] = trim((string) ($data['slug'] ?? ''));
                $data['title'] = trim((string) ($data['title'] ?? ''));
                $data['location'] = trim((string) ($data['location'] ?? ''));
                $data['capacity'] = trim((string) ($data['capacity'] ?? ''));
                $data['facilities'] = trim((string) ($data['facilities'] ?? ''));
                $data['desc'] = trim((string) ($data['desc'] ?? ''));
                $data['image'] = $this->cleanImageName($data['image'] ?? '');

                return $data;
            })
            ->filter(fn ($row) => ! empty($row['slug']))
            ->values();
    }

    private function normalizeFacilities(string $facilities): string
    {
        return collect(explode(';', $facilities))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->implode(';');
    }

    private function cleanImageName(?string $imageName): string
    {
        $imageName = trim((string) $imageName);

        if ($imageName === '') {
            return '';
        }

        $isValidImageName = preg_match(
            '/^[a-zA-Z0-9._-]+\.(webp|jpg|jpeg|png)$/',
            $imageName
        );

        return $isValidImageName ? $imageName : '';
    }

    private function makeSlug(string $value): string
    {
        $slug = strtolower(trim($value));

        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        if ($slug === '') {
            $slug = 'musala-' . time();
        }

        return $slug;
    }

    private function makeUniqueSlug(string $baseSlug): string
    {
        $existingSlugs = $this->getMusalaCollection()
            ->pluck('slug')
            ->map(fn ($slug) => strtolower((string) $slug))
            ->values()
            ->all();

        $slug = $baseSlug;
        $counter = 2;

        while (in_array(strtolower($slug), $existingSlugs, true)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function storeImage(Request $request, string $slug): string
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            throw ValidationException::withMessages([
                'image' => 'Server tidak mendukung proses gambar WebP.',
            ]);
        }

        $folder = public_path(self::IMAGE_DIRECTORY);

        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $file = $request->file('image');

        if (! $file || ! $file->isValid()) {
            throw ValidationException::withMessages([
                'image' => 'File gambar tidak valid.',
            ]);
        }

        $contents = file_get_contents($file->getRealPath());

        if ($contents === false) {
            throw ValidationException::withMessages([
                'image' => 'Gagal membaca file gambar.',
            ]);
        }

        $image = imagecreatefromstring($contents);

        if (! $image) {
            throw ValidationException::withMessages([
                'image' => 'Gagal memproses file gambar.',
            ]);
        }

        $fileName = $this->makeImageName($slug);
        $path = $folder . DIRECTORY_SEPARATOR . $fileName;

        if (is_file($path)) {
            @unlink($path);
            clearstatcache(true, $path);
        }

        $saved = imagewebp($image, $path, 85);

        imagedestroy($image);

        clearstatcache(true, $path);

        if (! $saved) {
            throw ValidationException::withMessages([
                'image' => 'Gagal menyimpan gambar.',
            ]);
        }

        return $fileName;
    }

    private function makeImageName(string $slug): string
    {
        $slug = strtolower(trim($slug));

        $slug = preg_replace('/[^a-z0-9_-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        if ($slug === '') {
            $slug = 'musala-' . time();
        }

        return $slug . '.webp';
    }

    private function deleteImageIfExists(?string $imageName): void
    {
        $imageName = $this->cleanImageName($imageName);

        if ($imageName === '') {
            return;
        }

        $path = public_path(self::IMAGE_DIRECTORY . '/' . $imageName);

        if (is_file($path)) {
            @unlink($path);
        }
    }
}