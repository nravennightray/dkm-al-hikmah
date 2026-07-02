<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    private const SHEET_NAME = 'home_infos';

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

    protected ?string $spreadsheetId;

    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;
        $this->spreadsheetId = config('google.spreadsheet_id');
    }

    public function index()
    {
        $homeInfos = $this->getHomeInfos();

        return view('public.dashboard.index', compact('homeInfos'));
    }

    private function getHomeInfos(): Collection
    {
        return $this->getSheetCollection()
            ->filter(fn ($item) => strtolower($item['status'] ?? 'inactive') === 'active')
            ->sortBy(fn ($item) => (int) ($item['sort_order'] ?? 999))
            ->take(3)
            ->values();
    }

    private function getSheetCollection(): Collection
    {
        if (! $this->spreadsheetId) {
            return collect();
        }

        try {
            $rows = collect(
                $this->sheetService->getSheet($this->spreadsheetId, self::SHEET_NAME)
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
            ->map(function ($row) {
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

                return $data;
            })
            ->filter(function ($row) {
                return collect(self::COLUMNS)
                    ->some(fn ($column) => trim((string) ($row[$column] ?? '')) !== '');
            })
            ->values();
    }
}