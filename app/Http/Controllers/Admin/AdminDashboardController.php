<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;

class AdminDashboardController extends Controller
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

    public function index()
    {
        $currentRole = strtolower(session('sheet_user.role') ?? 'karyawan');
        $isAdmin = in_array($currentRole, ['superadmin', 'admin'], true);

        $kegiatans = $this->getSheetCollection('kegiatan');
        $categories = $this->getSheetCollection('kategori');
        $users = $this->getSheetCollection('users');
        $userBalances = $this->getSheetCollection('users_tabungan');
        $kasRows = $this->getSheetCollection('kas_tabungan');
        $transactions = $this->getSheetCollection('trx_tabungan')
            ->sortByDesc(fn ($trx) => (int) ($trx['id_transaction'] ?? 0))
            ->values();

        $currentUserId = (string) (session('sheet_user.id_user') ?? '');

        $kasBalance = (float) ($kasRows->first()['balance'] ?? 0);

        $totalQurban = $isAdmin
            ? $userBalances->sum(fn ($row) => (float) ($row['qurban_balance'] ?? 0))
            : (float) ($userBalances->firstWhere('id_user', $currentUserId)['qurban_balance'] ?? 0);

        $totalUmrah = $isAdmin
            ? $userBalances->sum(fn ($row) => (float) ($row['umrah_balance'] ?? 0))
            : (float) ($userBalances->firstWhere('id_user', $currentUserId)['umrah_balance'] ?? 0);

        $dashboardTransactions = $isAdmin
            ? $transactions
            : $transactions
                ->filter(fn ($trx) => (string) ($trx['target_user_id'] ?? '') === $currentUserId
                    || (string) ($trx['requested_by_id'] ?? '') === $currentUserId)
                ->values();

        $pendingApprovals = $transactions
            ->filter(fn ($trx) => strtolower($trx['status'] ?? '') === 'pending')
            ->values();

        $financeTabs = [
            'all' => $dashboardTransactions,
            'qurban' => $dashboardTransactions
                ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'qurban')
                ->values(),
            'umrah' => $dashboardTransactions
                ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'umrah')
                ->values(),
            'infaq' => $dashboardTransactions
                ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'infaq')
                ->values(),
            'kas' => $dashboardTransactions ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'kas')
                ->values(),
        ];

        $financeStats = [
            'qurban' => $totalQurban,
            'umrah' => $totalUmrah,
            'kas' => $kasBalance,
            'infaq' => $dashboardTransactions ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'infaq' )
                ->sum(fn ($trx) => (float) ($trx['amount'] ?? 0)),
            'pending_count' => $pendingApprovals->count(),
        ];

        $stats = [
            'total_kegiatans' => $kegiatans->count(),
            'total_categories' => $categories->count(),
            'active_users' => $users
                ->filter(fn ($user) => strtolower($user['status'] ?? '') === 'active')
                ->count(),
        ];

        $latestKegiatans = $kegiatans
            ->sortByDesc('date')
            ->take(5)
            ->values();

        return view('admin.dashboard.index', compact(
            'currentRole',
            'isAdmin',
            'stats',
            'latestKegiatans',
            'categories',
            'financeStats',
            'financeTabs',
            'pendingApprovals'
        ));
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