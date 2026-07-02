<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminKegiatanController extends Controller
{
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

    public function index(Request $request)
    {
        $allKegiatan = $this->getSheetCollection('kegiatan')
            ->sortByDesc('date')
            ->values();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $items = $allKegiatan
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $kegiatan = new LengthAwarePaginator(
            $items,
            $allKegiatan->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        $categories = $this->getSheetCollection('kategori')->values();

        return view('admin.kegiatan.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'category_slug' => ['required', 'string', 'max:180'],
            'date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'quote' => ['nullable', 'string'],
        ]);

        $posts = $this->getSheetCollection('kegiatan');

        $idKegiatan = $this->getNextKegiatanId($posts);

        $slug = filled($validated['slug'] ?? null)
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $slug = $this->makeUniqueSlug($slug, $posts);

        $imageName = '';

        if ($request->hasFile('image')) {
            $imageName = $this->storeImage($request, $slug);
        }

        $this->sheetService->appendRow($this->spreadsheetId, 'kegiatan', [
            $idKegiatan,
            $validated['title'],
            $slug,
            $validated['category_slug'],
            $validated['date'] ?? '',
            $imageName,
            $validated['excerpt'] ?? '',
            $validated['content'] ?? '',
            $validated['quote'] ?? '',
        ]);

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(string $kegiatan)
    {
        $post = $this->getSheetCollection('kegiatan')
            ->firstWhere('slug', $kegiatan);

        if (! $post) {
            abort(404);
        }

        $categories = $this->getSheetCollection('kategori')->values();

        return view('admin.kegiatan.edit', compact('post', 'categories'));
    }

    public function update(Request $request, string $kegiatan)
    {
        $posts = $this->getSheetCollection('kegiatan');

        $post = $posts->firstWhere('slug', $kegiatan);

        if (! $post) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'category_slug' => ['required', 'string', 'max:180'],
            'date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'quote' => ['nullable', 'string'],
        ]);

        $oldSlug = $post['slug'] ?? $kegiatan;

        $newSlug = filled($validated['slug'] ?? null)
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $newSlug = $this->makeUniqueSlug(
            $newSlug,
            $posts,
            $oldSlug
        );

        $idKegiatan = $post['id_kegiatan'] ?? '';

        if (! $idKegiatan) {
            $idKegiatan = $this->getNextKegiatanId($posts);
        }

        $imageName = $post['image'] ?? '';

        if ($oldSlug !== $newSlug) {
            $imageName = $this->renameImageFolder($oldSlug, $newSlug, $imageName);
        }

        if ($request->hasFile('image')) {
            $imageName = $this->storeImage($request, $newSlug);
        }

        $payload = [
            $idKegiatan,
            trim($validated['title']),
            $newSlug,
            trim($validated['category_slug']),
            $validated['date'] ?? '',
            $imageName,
            trim($validated['excerpt'] ?? ''),
            trim($validated['content'] ?? ''),
            trim($validated['quote'] ?? ''),
        ];

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'kegiatan',
            (int) $post['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(string $kegiatan)
    {
        $post = $this->getSheetCollection('kegiatan')
            ->firstWhere('slug', $kegiatan);

        if (! $post) {
            abort(404);
        }

        $slug = $post['slug'] ?? $kegiatan;
        $folder = public_path('image/kegiatan/' . $slug);

        if (File::exists($folder)) {
            File::deleteDirectory($folder);
        }

        $this->sheetService->deleteRow(
            $this->spreadsheetId,
            'kegiatan',
            $post['_row_number']
        );

        return redirect()
            ->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    private function storeImage(Request $request, string $slug): string
    {
        if (! extension_loaded('gd') || ! function_exists('imagewebp')) {
            throw new \Exception('PHP GD/WebP belum aktif. Aktifkan extension GD terlebih dahulu.');
        }

        $folder = public_path('image/kegiatan/' . $slug);

        if (! File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        foreach (File::glob($folder . '/*') as $oldImage) {
            File::delete($oldImage);
        }

        $uploadedImage = $request->file('image');
        $sourcePath = $uploadedImage->getRealPath();
        $mimeType = $uploadedImage->getMimeType();

        $sourceImage = match ($mimeType) {
            'image/jpeg' => imagecreatefromjpeg($sourcePath),
            'image/png' => imagecreatefrompng($sourcePath),
            'image/webp' => imagecreatefromwebp($sourcePath),
            default => null,
        };

        if (! $sourceImage) {
            throw new \Exception('Format gambar tidak didukung.');
        }

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        $targetWidth = 1200;
        $targetHeight = 800;

        $sourceRatio = $sourceWidth / $sourceHeight;
        $targetRatio = $targetWidth / $targetHeight;

        if ($sourceRatio > $targetRatio) {
            $cropHeight = $sourceHeight;
            $cropWidth = (int) ($sourceHeight * $targetRatio);
            $cropX = (int) (($sourceWidth - $cropWidth) / 2);
            $cropY = 0;
        } else {
            $cropWidth = $sourceWidth;
            $cropHeight = (int) ($sourceWidth / $targetRatio);
            $cropX = 0;
            $cropY = (int) (($sourceHeight - $cropHeight) / 2);
        }

        $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);

        imagecopyresampled(
            $targetImage,
            $sourceImage,
            0,
            0,
            $cropX,
            $cropY,
            $targetWidth,
            $targetHeight,
            $cropWidth,
            $cropHeight
        );

        $imageName = $slug . '.webp';
        $targetPath = $folder . '/' . $imageName;

        imagewebp($targetImage, $targetPath, 85);

        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        return $imageName;
    }

    private function renameImageFolder(string $oldSlug, string $newSlug, ?string $oldImageName): string
    {
        $oldFolder = public_path('image/kegiatan/' . $oldSlug);
        $newFolder = public_path('image/kegiatan/' . $newSlug);

        if (! File::exists($oldFolder)) {
            return $oldImageName ?: '';
        }

        if (File::exists($newFolder)) {
            File::deleteDirectory($newFolder);
        }

        File::moveDirectory($oldFolder, $newFolder);

        if (! $oldImageName) {
            return '';
        }

        $oldImagePath = $newFolder . '/' . $oldImageName;
        $newImageName = $newSlug . '.webp';
        $newImagePath = $newFolder . '/' . $newImageName;

        if (File::exists($oldImagePath)) {
            File::move($oldImagePath, $newImagePath);
        }

        return $newImageName;
    }

    private function getNextKegiatanId(Collection $posts): int
    {
        $maxId = $posts
            ->pluck('id_kegiatan')
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->max();

        return $maxId ? $maxId + 1 : 1;
    }

    private function makeUniqueSlug(string $slug, Collection $posts, ?string $ignoreSlug = null): string
    {
        $baseSlug = $slug ?: 'kegiatan';
        $finalSlug = $baseSlug;
        $counter = 2;

        $existingSlugs = $posts
            ->pluck('slug')
            ->filter()
            ->when($ignoreSlug, fn ($collection) => $collection->reject(fn ($item) => $item === $ignoreSlug))
            ->values();

        while ($existingSlugs->contains($finalSlug)) {
            $finalSlug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $finalSlug;
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
}