<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;

class KegiatanController extends Controller
{
    public function __construct(
        private GoogleSheetService $sheetService
    ) {}

    private function getSheetCollection(string $sheetName)
    {
        $rows = collect(
            $this->sheetService->getSheet(
                env('POSTS_SPREADSHEET_ID'),
                $sheetName
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
            ->values();
    }

    private function getAllCategories()
    {
        return $this->getSheetCollection('kategori');
    }

    public function index()
    {
        $categories = $this->getAllCategories();

        return view(
            'public.kegiatan.index',
            compact('categories')
        );
    }

    public function showCategory(string $categorySlug)
    {
        $categories = $this->getAllCategories();

        $currentCategory = $categories->firstWhere(
            'slug',
            $categorySlug
        );

        if (! $currentCategory) {
            abort(404);
        }

        $kegiatans = $this->getSheetCollection('kegiatan')
            ->where('category_slug', $categorySlug)
            ->values();

        return view(
            'public.kegiatan.category',
            [
                'kegiatans' => $kegiatans,
                'currentCategory' => $currentCategory,
            ]
        );
    }

    public function showDetail(string $category, string $slug)
    {
        $categories = $this->getAllCategories();

        $currentCategory = $categories->firstWhere('slug', $category);

        if (! $currentCategory) {
            abort(404);
        }

        $post = $this->getSheetCollection('kegiatan')
            ->where('category_slug', $category)
            ->where('slug', $slug)
            ->first();

        if (! $post) {
            abort(404);
        }

        return view('public.kegiatan.post', [
            'category' => $category,
            'slug' => $slug,
            'post' => $post,
            'currentCategory' => $currentCategory,
        ]);
    }
}