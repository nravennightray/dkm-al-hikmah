<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class InfaqController extends Controller
{
    private const SETTINGS_SHEET = 'infaq_settings';

    private const ACCOUNTS_SHEET = 'infaq_bank_accounts';

    private const SETTINGS_COLUMNS = [
        'key',
        'hero_badge',
        'hero_title',
        'hero_quote',
        'qris_badge',
        'qris_title',
        'qris_description',
        'qris_image',
        'qris_note',
        'bank_title',
        'bank_description',
        'transfer_note',
        'status',
    ];

    private const ACCOUNT_COLUMNS = [
        'id_account',
        'bank',
        'number',
        'holder',
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
        $settings = $this->getSettings();

        if (strtolower($settings['status'] ?? 'active') !== 'active') {
            abort(404);
        }

        $accounts = $this->getAccounts();

        return view('public.infaq.index', compact(
            'settings',
            'accounts'
        ));
    }

    private function getSettings(): array
    {
        $settings = $this->getSheetCollection(
            self::SETTINGS_SHEET,
            self::SETTINGS_COLUMNS
        )
            ->firstWhere('key', 'main');

        if ($settings) {
            return $settings;
        }

        return [
            'key' => 'main',
            'hero_badge' => 'Dukung Kebaikan',
            'hero_title' => 'Infaq & Sedekah',
            'hero_quote' => '"Harta tidak akan berkurang karena sedekah." (HR. Muslim)',
            'qris_badge' => 'QRIS Infaq',
            'qris_title' => 'Scan QRIS Infaq',
            'qris_description' => 'Salurkan infaq dengan mudah melalui QRIS resmi DKM Al Hikmah.',
            'qris_image' => '',
            'qris_note' => 'Mendukung semua e-wallet seperti GoPay, OVO, DANA, LinkAja, dan mobile banking.',
            'bank_title' => 'Transfer Bank',
            'bank_description' => 'Anda dapat menyalurkan donasi melalui transfer ke rekening resmi DKM Al Hikmah di bawah ini:',
            'transfer_note' => 'Mohon sertakan kode unik atau melakukan konfirmasi ke Bendahara DKM setelah melakukan transfer untuk mempermudah pencatatan laporan keuangan.',
            'status' => 'active',
        ];
    }

    private function getAccounts(): Collection
    {
        return $this->getSheetCollection(
            self::ACCOUNTS_SHEET,
            self::ACCOUNT_COLUMNS
        )
            ->filter(fn ($item) => strtolower($item['status'] ?? 'inactive') === 'active')
            ->sortBy(fn ($item) => (int) ($item['sort_order'] ?? 999))
            ->take(3)
            ->values();
    }

    private function getSheetCollection(string $sheetName, array $columns): Collection
    {
        if (! $this->spreadsheetId) {
            return collect();
        }

        try {
            $rows = collect(
                $this->sheetService->getSheet($this->spreadsheetId, $sheetName)
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
            ->filter(function ($row) use ($columns) {
                return collect($columns)
                    ->some(fn ($column) => trim((string) ($row[$column] ?? '')) !== '');
            })
            ->values();
    }
}