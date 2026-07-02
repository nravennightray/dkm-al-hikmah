<?php

namespace App\Providers;

use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('master.layout.header', function ($view) {
            $categories = collect(
                Cache::remember(
                    'header_kegiatan_categories',
                    now()->addMinutes(10),
                    fn () => $this->getHeaderKegiatanCategories()
                )
            );

            $musalaNavbar = collect(
                Cache::remember(
                    'header_musala_navbar',
                    now()->addMinutes(10),
                    fn () => $this->getHeaderMusalaNavbar()
                )
            );

            $profilNavbar = collect(
                Cache::remember(
                    'header_profil_navbar',
                    now()->addMinutes(10),
                    fn () => $this->getHeaderProfilNavbar()
                )
            );

            $view->with([
                'headerKegiatanCategories' => $categories,
                'musalaNavbar' => $musalaNavbar,
                'profilNavbar' => $profilNavbar,
            ]);
        });
    }

    private function getHeaderKegiatanCategories(): array
    {
        try {
            $rows = $this->getSheetRows('kategori');

            $columns = [
                'name',
                'slug',
                'icon',
                'desc',
            ];

            return $this->mapSheetRows($rows, $columns)
                ->filter(fn ($category) =>
                    !empty($category['slug']) &&
                    !empty($category['name'])
                )
                ->values()
                ->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    private function getHeaderMusalaNavbar(): array
    {
        try {
            $rows = $this->getSheetRows('musala');

            $columns = [
                'slug',
                'title',
                'location',
                'capacity',
                'facilities',
                'desc',
                'image',
            ];

            return $this->mapSheetRows($rows, $columns)
                ->map(function ($musala) {
                    return [
                        'slug' => trim((string) ($musala['slug'] ?? '')),
                        'title' => trim((string) ($musala['title'] ?? '')),
                    ];
                })
                ->filter(fn ($musala) =>
                    !empty($musala['slug']) &&
                    !empty($musala['title'])
                )
                ->values()
                ->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    private function getSheetRows(string $sheetName): Collection
    {
        $spreadsheetId = config('google.spreadsheet_id');

        if (!$spreadsheetId) {
            return collect();
        }

        $sheetService = app(GoogleSheetService::class);

        $rows = collect(
            $sheetService->getSheet($spreadsheetId, $sheetName)
        );

        if ($rows->isEmpty()) {
            return collect();
        }

        // Remove header row.
        $rows->shift();

        return $rows;
    }

    private function mapSheetRows(Collection $rows, array $columns): Collection
    {
        return $rows
            ->map(function ($row) use ($columns) {
                $row = collect($row)
                    ->pad(count($columns), '')
                    ->take(count($columns))
                    ->values();

                return collect($columns)
                    ->combine($row)
                    ->toArray();
            })
            ->filter(fn ($row) =>
                collect($row)
                    ->filter(fn ($value) => trim((string) $value) !== '')
                    ->isNotEmpty()
            )
            ->values();
    }

    private function getHeaderProfilNavbar(): array
    {
        try {
            $rows = $this->getSheetRows('profil_menu');

            $columns = [
                'slug',
                'title',
                'description',
                'icon',
                'route_name',
                'sort_order',
                'status',
            ];

            return $this->mapSheetRows($rows, $columns)
                ->filter(fn ($item) =>
                    !empty($item['title']) &&
                    !empty($item['route_name']) &&
                    strtolower($item['status'] ?? 'active') === 'active'
                )
                ->sortBy(fn ($item) => (int) ($item['sort_order'] ?? 999))
                ->map(function ($item) {
                    return [
                        'title' => trim((string) ($item['title'] ?? '')),
                        'route_name' => trim((string) ($item['route_name'] ?? '')),
                    ];
                })
                ->values()
                ->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }
}