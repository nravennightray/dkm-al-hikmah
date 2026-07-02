<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class ProfilController extends Controller
{
    private const PROFIL_MENU_COLUMNS = [
        'slug',
        'title',
        'description',
        'icon',
        'route_name',
        'sort_order',
        'status',
    ];

    private const PROFIL_PAGE_COLUMNS = [
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
    ];

    private const MILESTONE_COLUMNS = [
        'id_milestone',
        'page_slug',
        'year',
        'title',
        'description',
        'sort_order',
        'status',
    ];

    private const MISSION_COLUMNS = [
        'id_mission',
        'page_slug',
        'title',
        'description',
        'icon',
        'sort_order',
        'status',
    ];

    private const VALUE_COLUMNS = [
        'id_value',
        'page_slug',
        'title',
        'description',
        'icon',
        'sort_order',
        'status',
    ];

    private const STRUCTURE_COLUMNS = [
        'id_structure',
        'role',
        'description',
        'icon',
        'level',
        'sort_order',
        'status',
    ];

    private const PENGURUS_COLUMNS = [
        'id_pengurus',
        'name',
        'role',
        'division',
        'type',
        'image',
        'sort_order',
        'status',
    ];

    private const DIVISION_COLUMNS = [
        'slug',
        'title',
        'icon',
        'sort_order',
        'status',
    ];

    protected string $spreadsheetId;

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
        $menus = $this->activeRows(
            $this->getSheetCollection('profil_menu', self::PROFIL_MENU_COLUMNS)
        );

        return view('public.profil.index', compact('menus'));
    }

    public function sejarah()
    {
        $page = $this->getPageOrFail('sejarah');

        $milestones = $this->activeRows(
            $this->getSheetCollection('profil_milestones', self::MILESTONE_COLUMNS)
        )
            ->where('page_slug', 'sejarah')
            ->values();

        return view('public.profil.sejarah', compact(
            'page',
            'milestones'
        ));
    }

    public function visiMisi()
    {
        $page = $this->getPageOrFail('visi-misi');

        $missions = $this->activeRows(
            $this->getSheetCollection('profil_missions', self::MISSION_COLUMNS)
        )
            ->where('page_slug', 'visi-misi')
            ->values();

        $values = $this->activeRows(
            $this->getSheetCollection('profil_values', self::VALUE_COLUMNS)
        )
            ->where('page_slug', 'visi-misi')
            ->values();

        return view('public.profil.visi-misi', compact(
            'page',
            'missions',
            'values'
        ));
    }

    public function struktur()
    {
        $page = $this->getPageOrFail('struktur');

        $structures = $this->activeRows(
            $this->getSheetCollection('profil_structure', self::STRUCTURE_COLUMNS)
        );

        $mainStructure = $structures
            ->where('level', 'main')
            ->first();

        $secondaryStructures = $structures
            ->where('level', 'secondary')
            ->values();

        $fieldStructures = $structures
            ->where('level', 'field')
            ->values();

        return view('public.profil.struktur', compact(
            'page',
            'mainStructure',
            'secondaryStructures',
            'fieldStructures'
        ));
    }

    public function kepengurusan()
    {
        $page = $this->getPageOrFail('kepengurusan');

        $pengurus = $this->activeRows(
            $this->getSheetCollection('profil_pengurus', self::PENGURUS_COLUMNS)
        );

        $dailyPengurus = $pengurus
            ->where('type', 'daily')
            ->values();

        $divisionPengurus = $pengurus
            ->where('type', 'division')
            ->groupBy('division');

        $divisions = $this->activeRows(
            $this->getSheetCollection('profil_divisions', self::DIVISION_COLUMNS)
        );

        return view('public.profil.kepengurusan', compact(
            'page',
            'dailyPengurus',
            'divisionPengurus',
            'divisions'
        ));
    }

    private function getPageOrFail(string $slug): array
    {
        $page = $this->activeRows(
            $this->getSheetCollection('profil_pages', self::PROFIL_PAGE_COLUMNS)
        )
            ->firstWhere('slug', $slug);

        if (! $page) {
            abort(404);
        }

        return $page;
    }

    private function getSheetCollection(string $sheetName, array $columns): Collection
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
            ->map(function ($row) use ($columns) {
                $row = collect($row)
                    ->pad(count($columns), '')
                    ->take(count($columns))
                    ->values();

                $data = collect($columns)
                    ->combine($row)
                    ->toArray();

                foreach ($data as $key => $value) {
                    $data[$key] = trim((string) $value);
                }

                return $data;
            })
            ->filter(function ($row) {
                return collect($row)
                    ->filter(fn ($value) => trim((string) $value) !== '')
                    ->isNotEmpty();
            })
            ->values();
    }

    private function activeRows(Collection $rows): Collection
    {
        return $rows
            ->filter(fn ($row) => strtolower($row['status'] ?? 'active') === 'active')
            ->sortBy(fn ($row) => (int) ($row['sort_order'] ?? 999))
            ->values();
    }
}