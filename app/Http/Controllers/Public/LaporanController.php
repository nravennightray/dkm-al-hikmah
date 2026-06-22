<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class LaporanController extends Controller
{
    public function index(GoogleSheetService $sheetService)
    {
        $spreadsheetId = config('google.spreadsheet_id');

        $kasRows = $this->getSheetCollection($sheetService, $spreadsheetId, 'kas_tabungan');

        $transactions = $this->getSheetCollection($sheetService, $spreadsheetId, 'trx_tabungan')
            ->filter(function ($trx) {
                return strtolower($trx['fund_type'] ?? '') === 'kas'
                    && strtolower($trx['action_type'] ?? '') === 'expense'
                    && strtolower($trx['status'] ?? '') === 'approved';
            })
            ->sortByDesc('approved_at')
            ->values();

        $kasBalance = (float) ($kasRows->first()['balance'] ?? 0);

        $totalKeluar = $transactions->sum(fn ($trx) => (float) ($trx['amount'] ?? 0));

        $lastUpdate = $kasRows->first()['updated_at']
            ?? $transactions->first()['approved_at']
            ?? '-';

        return view('public.laporan.index', compact(
            'kasBalance',
            'totalKeluar',
            'lastUpdate',
            'transactions'
        ));
    }

    private function getSheetCollection(GoogleSheetService $sheetService, string $spreadsheetId, string $sheetName): Collection
    {
        $rows = collect($sheetService->getSheet($spreadsheetId, $sheetName));

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
