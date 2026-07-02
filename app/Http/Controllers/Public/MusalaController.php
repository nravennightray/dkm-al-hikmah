<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class MusalaController extends Controller
{
    private const SHEET_NAME = 'musala';

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

        if (! $this->spreadsheetId) {
            throw new \Exception('Spreadsheet ID belum diatur.');
        }
    }

    public function index()
    {
        $locations = $this->getMusalaCollection();

        return view('public.musala.index', compact('locations'));
    }

    public function show(string $slug)
    {
        $musala = $this->getMusalaCollection()
            ->firstWhere('slug', $slug);

        if (! $musala) {
            abort(404);
        }

        return view('public.musala.show', compact('musala'));
    }

    private function getMusalaCollection(): Collection
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
            ->map(function ($row) {
                $row = collect($row)
                    ->pad(count(self::EXPECTED_COLUMNS), '')
                    ->take(count(self::EXPECTED_COLUMNS))
                    ->values();

                $data = collect(self::EXPECTED_COLUMNS)
                    ->combine($row)
                    ->toArray();

                return $this->normalizeMusalaData($data);
            })
            ->filter(fn ($item) => !empty($item['slug']))
            ->values();
    }

    private function normalizeMusalaData(array $data): array
    {
        $title = trim((string) ($data['title'] ?? ''));
        $desc = trim((string) ($data['desc'] ?? ''));

        return [
            'slug' => trim((string) ($data['slug'] ?? '')),
            'title' => $title,
            'name' => $title,
            'location' => trim((string) ($data['location'] ?? '')),
            'capacity' => trim((string) ($data['capacity'] ?? '')),
            'facilities' => $this->normalizeFacilities($data['facilities'] ?? ''),
            'desc' => $desc,
            'short_desc' => $desc,

            'image' => $this->cleanImageName($data['image'] ?? ''),
        ];
    }

    private function normalizeFacilities(?string $facilities): array
    {
        return collect(explode(';', (string) $facilities))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
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
}