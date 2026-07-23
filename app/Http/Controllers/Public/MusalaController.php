<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class MusalaController extends Controller
{
    private const SHEET_NAME = 'musala';

    private const TYPE_OPTIONS = [
        'plant' => 'Musala Plant',
        'kantor' => 'Musala Kantor',
    ];

    private const EXPECTED_COLUMNS = [
        'slug',
        'type',
        'title',
        'location',
        'capacity',
        'facilities',
        'desc',
        'image',
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
        $locations = $this->getActiveMusalaCollection();

        $groupedLocations = $locations->groupBy('type');

        $typeOptions = self::TYPE_OPTIONS;

        return view('public.musala.index', compact(
            'locations',
            'groupedLocations',
            'typeOptions'
        ));
    }

    public function category(string $type)
    {
        $type = $this->normalizeType($type);

        if ($type === '') {
            abort(404);
        }

        $locations = $this->getActiveMusalaCollection()
            ->where('type', $type)
            ->values();

        $typeOptions = self::TYPE_OPTIONS;
        $typeLabel = $this->getTypeLabel($type);

        return view('public.musala.category', compact(
            'locations',
            'type',
            'typeLabel',
            'typeOptions'
        ));
    }

    public function show(string $slug)
    {
        $musala = $this->getActiveMusalaCollection()
            ->firstWhere('slug', $slug);

        if (! $musala) {
            abort(404);
        }

        return view('public.musala.show', compact('musala'));
    }

    private function getActiveMusalaCollection(): Collection
    {
        return $this->getMusalaCollection()
            ->where('status', 'active')
            ->values();
    }

    private function getMusalaCollection(): Collection
    {
        $rows = collect(
            $this->sheetService->getSheet($this->spreadsheetId, self::SHEET_NAME)
        );

        if ($rows->isEmpty()) {
            return collect();
        }

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
            ->filter(fn ($item) => ! empty($item['slug']))
            ->sortBy(function ($item) {
                return sprintf(
                    '%s-%05d-%s',
                    $item['type'] ?? '',
                    (int) ($item['sort_order'] ?? 999),
                    $item['title'] ?? ''
                );
            })
            ->values();
    }

    private function normalizeMusalaData(array $data): array
    {
        $title = trim((string) ($data['title'] ?? ''));
        $desc = trim((string) ($data['desc'] ?? ''));
        $type = $this->normalizeType($data['type'] ?? '');
        $status = trim((string) ($data['status'] ?? 'active')) ?: 'active';

        return [
            'slug' => trim((string) ($data['slug'] ?? '')),
            'type' => $type,
            'type_label' => $this->getTypeLabel($type),
            'title' => $title,
            'name' => $title,
            'location' => trim((string) ($data['location'] ?? '')),
            'capacity' => trim((string) ($data['capacity'] ?? '')),
            'facilities' => $this->normalizeFacilities($data['facilities'] ?? ''),
            'desc' => $desc,
            'short_desc' => $desc,
            'image' => $this->cleanImageName($data['image'] ?? ''),
            'sort_order' => trim((string) ($data['sort_order'] ?? '')),
            'status' => $status,
        ];
    }

    private function normalizeFacilities(?string $facilities): array
    {
        return collect(preg_split('/[;,]/', (string) $facilities))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->toArray();
    }

    private function normalizeType(?string $type): string
    {
        $type = strtolower(trim((string) $type));

        return array_key_exists($type, self::TYPE_OPTIONS) ? $type : '';
    }

    private function getTypeLabel(?string $type): string
    {
        $type = $this->normalizeType($type);

        return self::TYPE_OPTIONS[$type] ?? 'Belum Dikategorikan';
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