<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AdminKategoriController extends Controller
{
    private string $spreadsheetId;

    public function __construct(
        private GoogleSheetService $sheetService
    ) {
        $this->spreadsheetId = env('POSTS_SPREADSHEET_ID');
    }

    private function getSheetCollection(string $sheetName): Collection
    {
        $rows = collect($this->sheetService->getSheet($this->spreadsheetId, $sheetName));

        if ($rows->isEmpty()) {
            return collect();
        }

        $header = collect($rows->shift())
            ->map(fn ($column) => trim($column))
            ->filter()
            ->values();

        return $rows
            ->filter(fn ($row) => collect($row)->filter()->isNotEmpty())
            ->values()
            ->map(function ($row, $index) use ($header) {
                $row = collect($row);

                if ($row->count() < $header->count()) {
                    $row = $row->pad($header->count(), null);
                }

                if ($row->count() > $header->count()) {
                    $row = $row->take($header->count());
                }

                $data = $header->combine($row)->toArray();

                $data['_row_number'] = $index + 2;

                return $data;
            });
    }

    public function index(Request $request)
    {
        $allCategories = $this->getSheetCollection('kategori')->values();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $items = $allCategories
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $categories = new LengthAwarePaginator(
            $items,
            $allCategories->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150'],
            'icon' => ['nullable', 'string', 'max:100'],
            'desc' => ['nullable', 'string'],
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['name']);

        $this->sheetService->appendRow($this->spreadsheetId, 'kategori', [
            $validated['name'],
            $slug,
            $validated['icon'] ?? 'fa-folder',
            $validated['desc'] ?? '',
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(string $kategori)
    {
        $category = $this->getSheetCollection('kategori')
            ->firstWhere('slug', $kategori);

        if (! $category) {
            abort(404);
        }

        return view('admin.kategori.edit', compact('category'));
    }

    public function update(Request $request, string $kategori)
    {
        $category = $this->getSheetCollection('kategori')
            ->firstWhere('slug', $kategori);

        if (! $category) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150'],
            'icon' => ['nullable', 'string', 'max:100'],
            'desc' => ['nullable', 'string'],
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['name']);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'kategori',
            $category['_row_number'],
            [
                $validated['name'],
                $slug,
                $validated['icon'] ?? 'fa-folder',
                $validated['desc'] ?? '',
            ],
            'D'
        );

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $kategori)
    {
        $category = $this->getSheetCollection('kategori')
            ->firstWhere('slug', $kategori);

        if (! $category) {
            abort(404);
        }

        $this->sheetService->deleteRow(
            $this->spreadsheetId,
            'kategori',
            $category['_row_number']
        );

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
