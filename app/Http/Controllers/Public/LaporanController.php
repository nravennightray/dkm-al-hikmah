<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class LaporanController extends Controller
{
    protected GoogleSheetService $sheetService;

    protected string $spreadsheetId;

    public function __construct(GoogleSheetService $sheetService)
    {
        $this->sheetService = $sheetService;

        $spreadsheetId = config('google.spreadsheet_id');

        if (! $spreadsheetId) {
            throw new \Exception('Spreadsheet ID belum diatur.');
        }

        $this->spreadsheetId = $spreadsheetId;
    }

    public function index()
    {
        $currentRole = strtolower((string) session('sheet_user.role', ''));
        $currentUserId = (string) session('sheet_user.id_user', '');

        $isLoggedIn = $currentUserId !== '';
        $isAdmin = in_array($currentRole, ['superadmin', 'admin'], true);

        $userBalances = $this->getSheetCollection('users_tabungan');
        $kasRows = $this->getSheetCollection('kas_tabungan');

        $allTransactions = $this->getSheetCollection('trx_tabungan')
            ->sortByDesc(fn ($trx) => (int) ($trx['id_transaction'] ?? 0))
            ->values();

        $kasBalance = (float) ($kasRows->first()['balance'] ?? 0);

        $viewMode = 'public';
        $pageTitle = 'Laporan Keuangan';
        $pageSubtitle = 'Transparansi penggunaan kas DKM AL HIKMAH secara terbuka.';
        $tableTitle = 'Riwayat Penggunaan Kas';
        $tableSubtitle = 'Hanya menampilkan transaksi kas yang sudah disetujui.';

        $transactions = $this->getPublicKasTransactions($allTransactions);

        $summaryCards = $this->buildPublicSummaryCards(
            $kasBalance,
            $transactions
        );

        if ($isLoggedIn && $isAdmin) {
            $viewMode = 'admin';
            $pageSubtitle = 'Ringkasan seluruh dana dan transaksi DKM AL HIKMAH.';
            $tableTitle = 'Riwayat Semua Transaksi';
            $tableSubtitle = 'Menampilkan seluruh transaksi keuangan yang tercatat di sistem.';

            $transactions = $allTransactions;

            $totalQurban = $userBalances->sum(fn ($row) => (float) ($row['qurban_balance'] ?? 0));
            $totalUmrah = $userBalances->sum(fn ($row) => (float) ($row['umrah_balance'] ?? 0));

            $totalInfaq = $transactions
                ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'infaq')
                ->sum(fn ($trx) => (float) ($trx['amount'] ?? 0));

            $summaryCards = $this->buildAdminSummaryCards(
                $totalQurban,
                $totalUmrah,
                $totalInfaq,
                $kasBalance
            );
        }

        if ($isLoggedIn && ! $isAdmin) {
            $viewMode = 'karyawan';
            $pageSubtitle = 'Ringkasan tabungan dan infaq Anda di DKM AL HIKMAH.';
            $tableTitle = 'Riwayat Transaksi Saya';
            $tableSubtitle = 'Menampilkan transaksi Qurban, Umrah, dan Infaq milik Anda.';

            $transactions = $allTransactions
                ->filter(function ($trx) use ($currentUserId) {
                    return (string) ($trx['target_user_id'] ?? '') === $currentUserId
                        || (string) ($trx['requested_by_id'] ?? '') === $currentUserId;
                })
                ->values();

            $userBalance = $userBalances->firstWhere('id_user', $currentUserId);

            $qurbanBalance = (float) ($userBalance['qurban_balance'] ?? 0);
            $umrahBalance = (float) ($userBalance['umrah_balance'] ?? 0);

            $totalInfaq = $transactions
                ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'infaq')
                ->sum(fn ($trx) => (float) ($trx['amount'] ?? 0));

            $summaryCards = $this->buildKaryawanSummaryCards(
                $qurbanBalance,
                $umrahBalance,
                $totalInfaq,
                $transactions
            );
        }

        $lastUpdate = $transactions->first()['requested_at']
            ?? $transactions->first()['created_at']
            ?? $transactions->first()['approved_at']
            ?? $kasRows->first()['updated_at']
            ?? '-';

        return view('public.laporan.index', compact(
            'viewMode',
            'pageTitle',
            'pageSubtitle',
            'tableTitle',
            'tableSubtitle',
            'summaryCards',
            'transactions',
            'lastUpdate'
        ));
    }

    private function getPublicKasTransactions(Collection $transactions): Collection
    {
        return $transactions
            ->filter(function ($trx) {
                return strtolower($trx['fund_type'] ?? '') === 'kas';
            })
            ->values();
    }

    private function buildPublicSummaryCards(float $kasBalance, Collection $transactions): array
    {
        $totalKasKeluar = $transactions
            ->filter(function ($trx) {
                $actionType = strtolower($trx['action_type'] ?? '');

                return in_array($actionType, ['expense', 'withdraw'], true);
            })
            ->sum(fn ($trx) => (float) ($trx['amount'] ?? 0));

        return [
            [
                'label' => 'Saldo Kas Saat Ini',
                'value' => $this->formatRupiah($kasBalance),
                'icon' => 'fas fa-wallet',
                'class' => '',
            ],
            [
                'label' => 'Total Kas Terpakai',
                'value' => $this->formatRupiah($totalKasKeluar),
                'icon' => 'fas fa-arrow-up-right-from-square',
                'class' => 'danger',
            ],
            [
                'label' => 'Transaksi Kas Tercatat',
                'value' => $transactions->count(),
                'icon' => 'fas fa-circle-check',
                'class' => 'solid',
            ],
        ];
    }

    private function buildAdminSummaryCards(
        float $totalQurban,
        float $totalUmrah,
        float $totalInfaq,
        float $kasBalance
    ): array {
        return [
            [
                'label' => 'Total Tabungan Qurban',
                'value' => $this->formatRupiah($totalQurban),
                'icon' => 'fas fa-cow',
                'class' => '',
            ],
            [
                'label' => 'Total Tabungan Umrah',
                'value' => $this->formatRupiah($totalUmrah),
                'icon' => 'fas fa-kaaba',
                'class' => '',
            ],
            [
                'label' => 'Total Infaq',
                'value' => $this->formatRupiah($totalInfaq),
                'icon' => 'fas fa-hand-holding-heart',
                'class' => '',
            ],
            [
                'label' => 'Saldo Kas',
                'value' => $this->formatRupiah($kasBalance),
                'icon' => 'fas fa-wallet',
                'class' => 'solid',
            ],
        ];
    }

    private function buildKaryawanSummaryCards(
        float $qurbanBalance,
        float $umrahBalance,
        float $totalInfaq,
        Collection $transactions
    ): array {
        return [
            [
                'label' => 'Tabungan Qurban Saya',
                'value' => $this->formatRupiah($qurbanBalance),
                'icon' => 'fas fa-cow',
                'class' => '',
            ],
            [
                'label' => 'Tabungan Umrah Saya',
                'value' => $this->formatRupiah($umrahBalance),
                'icon' => 'fas fa-kaaba',
                'class' => '',
            ],
            [
                'label' => 'Total Infaq Saya',
                'value' => $this->formatRupiah($totalInfaq),
                'icon' => 'fas fa-hand-holding-heart',
                'class' => '',
            ],
            [
                'label' => 'Transaksi Saya',
                'value' => $transactions->count(),
                'icon' => 'fas fa-circle-check',
                'class' => 'solid',
            ],
        ];
    }

    private function getSheetCollection(string $sheetName): Collection
    {
        $rows = collect(
            $this->sheetService->getSheet($this->spreadsheetId, $sheetName)
        );

        if ($rows->isEmpty()) {
            return collect();
        }

        $header = collect($rows->shift())
            ->map(fn ($column) => trim((string) $column))
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

    private function formatRupiah(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}