<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminProfilController extends Controller
{
    private const IMAGE_DIRECTORY = 'image/profil';

    private const SECTIONS = [
        'menu' => [
            'label' => 'Menu Profil',
            'sheet' => 'profil_menu',
            'key' => 'slug',
            'locked' => true,
            'columns' => [
                'slug',
                'title',
                'description',
                'icon',
                'route_name',
                'sort_order',
                'status',
            ],
            'required' => [
                'title',
                'description',
                'route_name',
            ],
        ],

        'pages' => [
            'label' => 'Halaman Profil',
            'sheet' => 'profil_pages',
            'key' => 'slug',
            'locked' => true,
            'image_column' => 'image',
            'columns' => [
                'slug',
                'title',
                'hero_badge',
                'hero_icon',
                'subtitle',
                'section_label',
                'section_title',
                'section_body_1',
                'section_body_2',
                'image',
                'quote_text',
                'quote_author',
                'status',
            ],
            'required' => [
                'title',
            ],
        ],

        'milestones' => [
            'label' => 'Milestones Sejarah',
            'sheet' => 'profil_milestones',
            'key' => 'id_milestone',
            'columns' => [
                'id_milestone',
                'page_slug',
                'year',
                'title',
                'description',
                'sort_order',
                'status',
            ],
            'required' => [
                'page_slug',
                'year',
                'title',
                'description',
            ],
        ],

        'missions' => [
            'label' => 'Misi',
            'sheet' => 'profil_missions',
            'key' => 'id_mission',
            'columns' => [
                'id_mission',
                'page_slug',
                'title',
                'description',
                'icon',
                'sort_order',
                'status',
            ],
            'required' => [
                'page_slug',
                'title',
                'description',
            ],
        ],

        'values' => [
            'label' => 'Nilai-Nilai',
            'sheet' => 'profil_values',
            'key' => 'id_value',
            'columns' => [
                'id_value',
                'page_slug',
                'title',
                'description',
                'icon',
                'sort_order',
                'status',
            ],
            'required' => [
                'page_slug',
                'title',
                'description',
            ],
        ],

        'structure' => [
            'label' => 'Struktur Organisasi',
            'sheet' => 'profil_structure',
            'key' => 'id_structure',
            'columns' => [
                'id_structure',
                'role',
                'description',
                'icon',
                'level',
                'sort_order',
                'status',
            ],
            'required' => [
                'role',
                'description',
                'level',
            ],
        ],

        'pengurus' => [
            'label' => 'Kepengurusan',
            'sheet' => 'profil_pengurus',
            'key' => 'id_pengurus',
            'image_column' => 'image',
            'columns' => [
                'id_pengurus',
                'name',
                'role',
                'division',
                'type',
                'image',
                'sort_order',
                'status',
            ],
            'required' => [
                'name',
                'role',
                'type',
            ],
        ],

        'divisions' => [
            'label' => 'Divisi',
            'sheet' => 'profil_divisions',
            'key' => 'slug',
            'columns' => [
                'slug',
                'title',
                'icon',
                'sort_order',
                'status',
            ],
            'required' => [
                'title',
            ],
        ],
    ];

    private string $spreadsheetId;

    public function __construct(
        private GoogleSheetService $sheetService
    ) {
        $this->spreadsheetId = config('google.spreadsheet_id');

        if (! $this->spreadsheetId) {
            throw new \Exception('Spreadsheet ID belum diatur.');
        }
    }

    public function index()
    {
        $sections = collect(self::SECTIONS)
            ->map(function ($config, $key) {
                return [
                    'key' => $key,
                    'label' => $config['label'],
                    'sheet' => $config['sheet'],
                    'columns' => count($config['columns']),
                    'total' => $this->getSheetCollection($config)->count(),
                ];
            })
            ->values();

        return view('admin.profil.index', compact('sections'));
    }

    public function section(string $section)
    {
        $config = $this->getSectionConfig($section);
        $items = $this->getSheetCollection($config);

        return view('admin.profil.section.index', compact(
            'section',
            'config',
            'items'
        ));
    }

    public function create(string $section)
    {
        $config = $this->getSectionConfig($section);

        if (!empty($config['locked'])) {
            return redirect()
                ->route('admin.profil.section.index', $section)
                ->withErrors('Section ini hanya dapat diedit, tidak dapat ditambah data baru.');
        }

        $item = [];

        return view('admin.profil.section.form', compact(
            'section',
            'config',
            'item'
        ));
    }

    public function store(Request $request, string $section)
    {
        $config = $this->getSectionConfig($section);
        $items = $this->getSheetCollection($config);

        $data = $this->buildDataFromRequest($request, $config, $items);

        $this->ensureUniqueKey($data, $items, $config);

        $payload = $this->buildPayload($data, $config);

        $this->sheetService->appendRow(
            $this->spreadsheetId,
            $config['sheet'],
            $payload
        );

        return redirect()
            ->route('admin.profil.section.index', $section)
            ->with('success', $config['label'] . ' berhasil ditambahkan.');
    }

    public function edit(string $section, string $id)
    {
        $config = $this->getSectionConfig($section);
        $item = $this->findItemOrFail($config, $id);

        return view('admin.profil.section.form', compact(
            'section',
            'config',
            'item'
        ));
    }

    public function update(Request $request, string $section, string $id)
    {
        $config = $this->getSectionConfig($section);
        $items = $this->getSheetCollection($config);

        $item = $items->firstWhere($config['key'], $id);

        if (! $item) {
            abort(404);
        }

        $data = $this->buildDataFromRequest($request, $config, $items, $item);

        $this->ensureUniqueKey($data, $items, $config, $item[$config['key']] ?? null);

        $payload = $this->buildPayload($data, $config);

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            $config['sheet'],
            (int) $item['_row_number'],
            $payload
        );

        return redirect()
            ->route('admin.profil.section.index', $section)
            ->with('success', $config['label'] . ' berhasil diperbarui.');
    }

    public function destroy(string $section, string $id)
    {
        $config = $this->getSectionConfig($section);

        if (!empty($config['locked'])) {
            return redirect()
                ->route('admin.profil.section.index', $section)
                ->withErrors('Section ini tidak dapat dihapus.');
        }

        $item = $this->findItemOrFail($config, $id);

        $this->sheetService->deleteRow(
            $this->spreadsheetId,
            $config['sheet'],
            (int) $item['_row_number']
        );

        return redirect()
            ->route('admin.profil.section.index', $section)
            ->with('success', $config['label'] . ' berhasil dihapus.');
    }

    private function getSectionConfig(string $section): array
    {
        if (! array_key_exists($section, self::SECTIONS)) {
            abort(404);
        }

        $config = self::SECTIONS[$section];
        $config['section'] = $section;

        return $config;
    }

    private function findItemOrFail(array $config, string $id): array
    {
        $item = $this->getSheetCollection($config)
            ->firstWhere($config['key'], $id);

        if (! $item) {
            abort(404);
        }

        return $item;
    }

    private function getSheetCollection(array $config): Collection
    {
        $rows = collect(
            $this->sheetService->getSheet($this->spreadsheetId, $config['sheet'])
        );

        if ($rows->isEmpty()) {
            return collect();
        }

        // Remove header row.
        $rows->shift();

        return $rows
            ->map(function ($row, $index) use ($config) {
                $row = collect($row)
                    ->pad(count($config['columns']), '')
                    ->take(count($config['columns']))
                    ->values();

                $data = collect($config['columns'])
                    ->combine($row)
                    ->toArray();

                foreach ($data as $key => $value) {
                    $data[$key] = trim((string) $value);
                }

                $data['_row_number'] = $index + 2;

                return $data;
            })
            ->filter(function ($row) {
                return collect($row)
                    ->except('_row_number')
                    ->filter(fn ($value) => trim((string) $value) !== '')
                    ->isNotEmpty();
            })
            ->sortBy(fn ($row) => (int) ($row['sort_order'] ?? 999))
            ->values();
    }

    private function buildDataFromRequest(
        Request $request,
        array $config,
        Collection $items,
        array $oldData = []
    ): array {
        $validated = $this->validateData($request, $config);

        $data = [];

        foreach ($config['columns'] as $column) {
            $data[$column] = trim((string) ($validated[$column] ?? $oldData[$column] ?? ''));
        }

        $keyColumn = $config['key'];

        if ($this->isAutoIdColumn($keyColumn)) {
            $data[$keyColumn] = $oldData[$keyColumn] ?? $this->getNextId($items, $keyColumn);
        }

        if ($keyColumn === 'slug') {
            $data['slug'] = $this->resolveSlug($data, $oldData);
        }

        if (in_array('status', $config['columns'], true) && empty($data['status'])) {
            $data['status'] = $oldData['status'] ?? 'active';
        }

        if (in_array('sort_order', $config['columns'], true) && empty($data['sort_order'])) {
            $data['sort_order'] = $oldData['sort_order'] ?? $this->getNextSortOrder($items);
        }

        if (! empty($config['image_column'])) {
            $imageColumn = $config['image_column'];

            if ($request->hasFile('image_upload')) {
                $data[$imageColumn] = $this->storeImage($request, $data, $config);
            } elseif (empty($data[$imageColumn]) && ! empty($oldData[$imageColumn])) {
                $data[$imageColumn] = $oldData[$imageColumn];
            }
        }

        return $data;
    }

    private function validateData(Request $request, array $config): array
    {
        $rules = [];

        foreach ($config['columns'] as $column) {
            $baseRule = in_array($column, $config['required'] ?? [], true)
                ? ['required']
                : ['nullable'];

            if ($column === 'sort_order') {
                $rules[$column] = array_merge($baseRule, ['integer', 'min:1']);
                continue;
            }

            if ($column === 'status') {
                $rules[$column] = array_merge($baseRule, ['in:active,inactive']);
                continue;
            }

            if ($column === 'level') {
                $rules[$column] = array_merge($baseRule, ['in:main,secondary,field']);
                continue;
            }

            if ($column === 'type') {
                $rules[$column] = array_merge($baseRule, ['in:daily,division']);
                continue;
            }

            if (in_array($column, [
                'description',
                'section_body_1',
                'section_body_2',
                'quote_text',
                'subtitle',
            ], true)) {
                $rules[$column] = array_merge($baseRule, ['string']);
                continue;
            }

            $rules[$column] = array_merge($baseRule, ['string', 'max:255']);
        }

        if (! empty($config['image_column'])) {
            $rules['image_upload'] = [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ];
        }

        return $request->validate($rules);
    }

    private function buildPayload(array $data, array $config): array
    {
        return collect($config['columns'])
            ->map(fn ($column) => $data[$column] ?? '')
            ->values()
            ->toArray();
    }

    private function ensureUniqueKey(
        array $data,
        Collection $items,
        array $config,
        ?string $currentKey = null
    ): void {
        $key = $config['key'];
        $value = trim((string) ($data[$key] ?? ''));

        if ($value === '') {
            throw ValidationException::withMessages([
                $key => 'Key tidak boleh kosong.',
            ]);
        }

        $exists = $items
            ->reject(fn ($item) => (string) ($item[$key] ?? '') === (string) $currentKey)
            ->contains(fn ($item) => (string) ($item[$key] ?? '') === $value);

        if ($exists) {
            throw ValidationException::withMessages([
                $key => 'Data dengan key tersebut sudah digunakan.',
            ]);
        }
    }

    private function resolveSlug(array $data, array $oldData = []): string
    {
        if (! empty($data['slug'])) {
            return Str::slug($data['slug']);
        }

        if (! empty($oldData['slug'])) {
            return Str::slug($oldData['slug']);
        }

        foreach (['title', 'name', 'role'] as $sourceColumn) {
            if (! empty($data[$sourceColumn])) {
                return Str::slug($data[$sourceColumn]);
            }
        }

        return Str::slug(uniqid('profil-', true));
    }

    private function isAutoIdColumn(string $column): bool
    {
        return substr($column, 0, 3) === 'id_';
    }

    private function getNextId(Collection $items, string $column): int
    {
        $max = $items
            ->pluck($column)
            ->map(fn ($value) => (int) $value)
            ->max();

        return ((int) $max) + 1;
    }

    private function getNextSortOrder(Collection $items): int
    {
        $max = $items
            ->pluck('sort_order')
            ->map(fn ($value) => (int) $value)
            ->max();

        return ((int) $max) + 1;
    }

    private function storeImage(Request $request, array $data, array $config): string
    {
        if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
            throw ValidationException::withMessages([
                'image_upload' => 'Server tidak mendukung proses gambar WebP.',
            ]);
        }

        $file = $request->file('image_upload');

        if (! $file || ! $file->isValid()) {
            throw ValidationException::withMessages([
                'image_upload' => 'File gambar tidak valid.',
            ]);
        }

        $folder = public_path(self::IMAGE_DIRECTORY);

        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $baseName = $data['slug']
            ?? $data['name']
            ?? $data['title']
            ?? $data[$config['key']]
            ?? uniqid('profil-', true);

        $fileName = Str::slug($baseName) . '-' . time() . '.webp';

        $contents = file_get_contents($file->getRealPath());

        if ($contents === false) {
            throw ValidationException::withMessages([
                'image_upload' => 'Gagal membaca file gambar.',
            ]);
        }

        $image = imagecreatefromstring($contents);

        if (! $image) {
            throw ValidationException::withMessages([
                'image_upload' => 'Gagal memproses file gambar.',
            ]);
        }

        $saved = imagewebp($image, $folder . DIRECTORY_SEPARATOR . $fileName, 85);

        imagedestroy($image);

        if (! $saved) {
            throw ValidationException::withMessages([
                'image_upload' => 'Gagal menyimpan gambar.',
            ]);
        }

        return $fileName;
    }
}