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
        $currentRole = strtolower(trim((string) session('sheet_user.role', 'karyawan')));
        $currentUserId = (string) (session('sheet_user.id_user') ?? '');
        $isAdmin = in_array($currentRole, ['superadmin', 'admin'], true);

        $kegiatans = $this->getSheetCollection('kegiatan');
        $categories = $this->getSheetCollection('kategori');
        $users = $this->getSheetCollection('users');
        $userBalances = $this->getSheetCollection('users_tabungan');
        $kasRows = $this->getSheetCollection('kas_tabungan');

        $transactions = $this->getSheetCollection('trx_tabungan')
            ->sortByDesc(fn ($trx) => (int) ($trx['id_transaction'] ?? 0))
            ->values();

        $kasBalance = (float) ($kasRows->first()['balance'] ?? 0);

        $dashboardTransactions = $isAdmin
            ? $transactions
            : $transactions
                ->filter(fn ($trx) => $this->transactionBelongsToCurrentUser($trx, $currentUserId))
                ->values();

        $pendingApprovals = $isAdmin
            ? $transactions
                ->filter(fn ($trx) => strtolower(trim((string) ($trx['status'] ?? ''))) === 'pending')
                ->values()
            : collect();

        $totalQurban = $isAdmin
            ? $userBalances->sum(fn ($row) => (float) ($row['qurban_balance'] ?? 0))
            : (float) ($userBalances->firstWhere('id_user', $currentUserId)['qurban_balance'] ?? 0);

        $totalUmrah = $isAdmin
            ? $userBalances->sum(fn ($row) => (float) ($row['umrah_balance'] ?? 0))
            : (float) ($userBalances->firstWhere('id_user', $currentUserId)['umrah_balance'] ?? 0);

        $financeTabs = [
            'all' => $dashboardTransactions,
            'qurban' => $this->filterByFundType($dashboardTransactions, 'qurban'),
            'umrah' => $this->filterByFundType($dashboardTransactions, 'umrah'),
            'infaq' => $this->filterByFundType($dashboardTransactions, 'infaq'),
            'kas' => $isAdmin
                ? $this->filterByFundType($dashboardTransactions, 'kas')
                : collect(),
        ];

        $financeStats = [
            'qurban' => $totalQurban,
            'umrah' => $totalUmrah,
            'kas' => $kasBalance,
            'infaq' => $this->sumApprovedIncoming($financeTabs['infaq']),
            'pending_count' => $pendingApprovals->count(),
        ];

        $stats = [
            'total_kegiatans' => $kegiatans->count(),
            'total_categories' => $categories->count(),
            'active_users' => $users
                ->filter(fn ($user) => strtolower(trim((string) ($user['status'] ?? ''))) === 'active')
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

    private function transactionBelongsToCurrentUser(array $transaction, string $currentUserId): bool
    {
        if ($currentUserId === '') {
            return false;
        }

        return (string) ($transaction['target_user_id'] ?? '') === $currentUserId
            || (string) ($transaction['requested_by_id'] ?? '') === $currentUserId;
    }

    private function filterByFundType(Collection $transactions, string $fundType): Collection
    {
        $fundType = strtolower(trim($fundType));

        return $transactions
            ->filter(function ($trx) use ($fundType) {
                return strtolower(trim((string) ($trx['fund_type'] ?? ''))) === $fundType;
            })
            ->values();
    }

    private function sumApprovedIncoming(Collection $transactions): float
    {
        return $transactions
            ->filter(function ($trx) {
                $status = strtolower(trim((string) ($trx['status'] ?? '')));
                $actionType = strtolower(trim((string) ($trx['action_type'] ?? '')));

                return $status === 'approved'
                    && ! in_array($actionType, ['withdraw', 'expense'], true);
            })
            ->sum(fn ($trx) => (float) ($trx['amount'] ?? 0));
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