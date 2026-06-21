<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class AdminDashboardController extends Controller
{
    public function __construct(
        private GoogleSheetService $sheetService
    ) {}

    private function getSheetCollection(string $sheetName): Collection
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

    public function index()
    {
        $categories = $this->getSheetCollection('kategori');
        $kegiatans = $this->getSheetCollection('kegiatan');
        $users = $this->getSheetCollection('users');

        $stats = [
            'total_categories' => $categories->count(),
            'total_kegiatans' => $kegiatans->count(),
            'total_users' => $users->count(),
            'active_users' => $users
                ->filter(fn ($user) => strtolower(trim($user['status'] ?? '')) === 'active')
                ->count(),
        ];

        $latestKegiatans = $kegiatans
            ->reverse()
            ->take(5)
            ->values();

        return view('admin.dashboard.index', [
            'stats' => $stats,
            'latestKegiatans' => $latestKegiatans,
        ]);
    }
}