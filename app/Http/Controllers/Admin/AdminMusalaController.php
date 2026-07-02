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
        $this->spreadsheetId = config('google.spreadsheet_id');
    }

    public function index()
    {
        $musala = $this->getMusalaCollection();

        return view('admin.musala.index', compact('musala'));
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

        $payload = $this->buildSheetPayload($musala, $validated, $imageName);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            self::SHEET_NAME,
            (int) $musala['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.musala.index')
            ->with('success', 'Musala updated successfully.');
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
                'facilities' => 'Facilities cannot be empty.',
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

    private function buildSheetPayload(array $musala, array $validated, ?string $imageName): array
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

        abort_if(!$musala, 404);

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

        // Remove header row.
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
            ->filter(fn ($row) => !empty($row['slug']))
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

    private function storeImage(Request $request, string $slug): string
    {
        if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
            throw ValidationException::withMessages([
                'image' => 'Server does not support GD WebP image processing.',
            ]);
        }

        $folder = public_path(self::IMAGE_DIRECTORY);

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $file = $request->file('image');

        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages([
                'image' => 'Uploaded image is invalid.',
            ]);
        }

        $contents = file_get_contents($file->getRealPath());

        if ($contents === false) {
            throw ValidationException::withMessages([
                'image' => 'Failed to read uploaded image.',
            ]);
        }

        $image = imagecreatefromstring($contents);

        if (!$image) {
            throw ValidationException::withMessages([
                'image' => 'Failed to process uploaded image.',
            ]);
        }

        $fileName = $this->makeImageName($slug);
        $path = $folder . DIRECTORY_SEPARATOR . $fileName;

        $saved = imagewebp($image, $path, 85);

        imagedestroy($image);

        if (!$saved) {
            throw ValidationException::withMessages([
                'image' => 'Failed to save uploaded image.',
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

        return $slug . '.webp';
    }
}