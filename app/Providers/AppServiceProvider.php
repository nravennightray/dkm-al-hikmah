<?php

namespace App\Providers;

use App\Services\GoogleSheetService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('master.layout.header', function ($view) {
            $categories = Cache::remember('header_kegiatan_categories', now()->addMinutes(10), function () {
                $sheetService = app(GoogleSheetService::class);

                $rows = collect(
                    $sheetService->getSheet(
                        config('google.spreadsheet_id'),
                        'kategori'
                    )
                );

                if ($rows->isEmpty()) {
                    return collect();
                }

                $header = collect($rows->shift())
                    ->map(fn ($column) => trim($column))
                    ->filter()
                    ->values();

                return $rows
                    ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
                    ->map(function ($row) use ($header) {
                        $row = collect($row);

                        if ($row->count() < $header->count()) {
                            $row = $row->pad($header->count(), null);
                        }

                        if ($row->count() > $header->count()) {
                            $row = $row->take($header->count());
                        }

                        return $header
                            ->combine($row)
                            ->toArray();
                    })
                    ->filter(fn ($category) => is_array($category)
                        && !empty($category['slug'])
                        && !empty($category['name'])
                    )
                    ->values();
            });

            $view->with('headerKegiatanCategories', $categories);
        });
    }
}
