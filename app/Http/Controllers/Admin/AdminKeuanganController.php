<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminKeuanganController extends Controller
{
    protected GoogleSheetService $sheetService;
    protected string $spreadsheetId;

    private array $fundTypes = [
        'qurban',
        'umrah',
        'kas',
        'infaq',
    ];

    private array $personalFundTypes = [
        'qurban',
        'umrah',
    ];

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
        $currentRole = $this->currentUserRole();
        $canApprove = in_array($currentRole, ['superadmin', 'admin'], true);

        $transactions = $this->getSheetCollection('trx_tabungan');
        $users = $this->getSheetCollection('users');
        $userLookup = $users
            ->mapWithKeys(fn ($user) => [(string) ($user['id_user'] ?? '') => $user])
            ->all();

        $selectedUserId = (string) $request->input('user_id', '');
        $dateFilter = (string) $request->input('date_filter', 'all');
        $startDateInput = (string) $request->input('start_date', '');
        $endDateInput = (string) $request->input('end_date', '');
        $selectedMonth = (string) $request->input('month', '');
        $selectedYear = (string) $request->input('year', '');

        if (! $canApprove) {
            $currentUserId = $this->currentUserId();

            $transactions = $transactions
                ->filter(fn ($transaction) =>
                    (string) ($transaction['target_user_id'] ?? '') === (string) $currentUserId ||
                    (string) ($transaction['requested_by_id'] ?? '') === (string) $currentUserId
                )
                ->values();
        }

        $transactions = $this->filterTransactions(
            $transactions,
            $canApprove,
            $selectedUserId,
            $dateFilter,
            $startDateInput,
            $endDateInput,
            $selectedMonth,
            $selectedYear
        );

        $transactions = $transactions
            ->sortByDesc(fn ($transaction) => (int) ($transaction['id_transaction'] ?? 0))
            ->values();

        $exportUsers = $canApprove
            ? $this->getActiveUsers()->sortBy('name')->values()
            : collect();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $items = $transactions
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $transactions = new LengthAwarePaginator(
            $items,
            $transactions->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.keuangan.index', compact(
            'transactions',
            'exportUsers',
            'currentRole',
            'userLookup',
            'selectedUserId',
            'dateFilter',
            'startDateInput',
            'endDateInput',
            'selectedMonth',
            'selectedYear'
        ));
    }

    public function createDeposit()
    {
        $currentRole = $this->currentUserRole();

        $users = in_array($currentRole, ['superadmin', 'admin'], true)
            ? $this->getActiveUsers()
            : collect([$this->currentSheetUser()]);

        $fundTypes = $this->fundTypes;

        return view('admin.keuangan.deposit-create', compact('users', 'fundTypes', 'currentRole'));
    }

    public function storeDeposit(Request $request)
    {
        $currentRole = $this->currentUserRole();
        $isAdmin = $this->isFinanceAdmin($currentRole);

        $rules = [
            'fund_type' => ['required', Rule::in($this->fundTypes)],
            'amount' => ['required', 'numeric', 'min:1000'],
            'note' => ['nullable', 'string', 'max:500'],
        ];

        if ($isAdmin) {
            $rules['target_user_id'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        $targetUserId = $isAdmin
            ? $validated['target_user_id']
            : $this->currentUserId();

        $targetUser = $this->findUserById($targetUserId);

        if (! $targetUser) {
            return back()
                ->withInput()
                ->with('error', 'User tujuan tidak ditemukan.');
        }

        $payload = [
            'target_user_id' => $targetUser['id_user'],
            'target_user_name' => $targetUser['name'],
            'fund_type' => $validated['fund_type'],
            'action_type' => 'deposit',
            'amount' => $validated['amount'],
            'status' => 'pending',
            'note' => $validated['note'] ?? '',
        ];

        $payload = $this->markPayloadApprovedByAdmin(
            $payload,
            'Setoran dicatat dan disetujui otomatis oleh admin.'
        );

        $this->appendTransaction($payload);

        $this->applyApprovedBalanceEffect($payload, $targetUser);

        $message = $isAdmin
            ? 'Setoran berhasil dicatat dan otomatis disetujui.'
            : 'Pengajuan setor tabungan berhasil dikirim dan menunggu persetujuan admin.';

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', $message);
    }

    public function createWithdraw()
    {
        $currentRole = $this->currentUserRole();

        $users = in_array($currentRole, ['superadmin', 'admin'], true)
            ? $this->getActiveUsers()
            : collect([$this->currentSheetUser()]);

        $fundTypes = $this->personalFundTypes;

        $balanceSummary = $this->buildWithdrawBalanceSummary($users, $fundTypes);

        return view('admin.keuangan.withdraw-create', compact(
            'users',
            'fundTypes',
            'currentRole',
            'balanceSummary'
        ));
    }

    public function storeWithdraw(Request $request)
    {
        $currentRole = $this->currentUserRole();
        $isAdmin = $this->isFinanceAdmin($currentRole);

        $rules = [
            'fund_type' => ['required', Rule::in($this->personalFundTypes)],
            'amount' => ['required', 'numeric', 'min:1000'],
            'note' => ['nullable', 'string', 'max:500'],
        ];

        if ($isAdmin) {
            $rules['target_user_id'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        $targetUserId = $isAdmin
            ? $validated['target_user_id']
            : $this->currentUserId();

        $targetUser = $this->findUserById($targetUserId);

        if (! $targetUser) {
            return back()
                ->withInput()
                ->with('error', 'User tujuan tidak ditemukan.');
        }

        $currentBalance = $this->getUserBalance(
            $targetUser['id_user'],
            $validated['fund_type']
        );

        $pendingWithdrawAmount = $this->getPendingWithdrawAmount(
            $targetUser['id_user'],
            $validated['fund_type']
        );

        $availableBalance = $currentBalance - $pendingWithdrawAmount;
        $requestedAmount = (float) $validated['amount'];

        if ($availableBalance < $requestedAmount) {
            $message = $pendingWithdrawAmount > 0
                ? 'Saldo tidak mencukupi. Masih ada pengajuan penarikan yang menunggu persetujuan.'
                : 'Saldo tidak mencukupi untuk pengajuan penarikan.';

            return back()
                ->withInput()
                ->with('error', $message);
        }

        $payload = [
            'target_user_id' => $targetUser['id_user'],
            'target_user_name' => $targetUser['name'],
            'fund_type' => $validated['fund_type'],
            'action_type' => 'withdraw',
            'amount' => $validated['amount'],
            'status' => 'pending',
            'note' => $validated['note'] ?? '',
        ];

        $payload = $this->markPayloadApprovedByAdmin(
            $payload,
            'Penarikan dicatat dan disetujui otomatis oleh admin.'
        );

        $this->appendTransaction($payload);

        $this->applyApprovedBalanceEffect($payload, $targetUser);

        $message = $isAdmin
            ? 'Penarikan berhasil dicatat dan otomatis disetujui.'
            : 'Pengajuan ambil tabungan berhasil dikirim dan menunggu persetujuan admin.';

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', $message);
    }

    public function createKasExpense()
    {
        return view('admin.keuangan.kas-expense-create');
    }

    public function storeKasExpense(Request $request)
    {
        $this->authorizeAdminAction();

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1000'],
            'note' => ['required', 'string', 'max:500'],
        ]);

        $kasBalance = $this->getKasBalance();

        if ($kasBalance < (float) $validated['amount']) {
            return back()
                ->withInput()
                ->with('error', 'Saldo kas tidak mencukupi.');
        }

        $transaction = $this->appendTransaction([
            'target_user_id' => '',
            'target_user_name' => '',
            'fund_type' => 'kas',
            'action_type' => 'expense',
            'amount' => $validated['amount'],
            'status' => 'approved',
            'note' => $validated['note'],
            'admin_note' => 'Pengeluaran kas dicatat oleh admin.',
            'approved_by_id' => $this->currentUserId(),
            'approved_by_name' => $this->currentUserName(),
            'approved_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->updateKasBalance($kasBalance - (float) $validated['amount']);

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Pengeluaran kas berhasil dicatat.');
    }

    public function createInfaq()
    {
        $currentUser = $this->currentSheetUser();

        if (! $currentUser) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Data user tidak ditemukan.');
        }

        $infaqAmounts = [100000, 250000, 300000, 350000, 400000, 500000];
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        return view('admin.keuangan.infaq-create', compact('currentUser', 'infaqAmounts', 'months'));
    }

    public function storeInfaq(Request $request)
    {
        $validated = $request->validate([
            'infaq_amount' => ['required', 'numeric', 'min:100000'],
            'period_month' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])$/'],
            'period_year' => ['required', 'string', 'regex:/^\d{4}$/'],
            'phone_number' => ['required', 'string', 'max:20'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $currentUser = $this->currentSheetUser();

        if (! $currentUser) {
            return back()
                ->withInput()
                ->with('error', 'Data user tidak ditemukan.');
        }

        $payload = [
            'target_user_id' => $currentUser['id_user'],
            'target_user_name' => $currentUser['name'],
            'fund_type' => 'infaq',
            'action_type' => 'salary_deduction',
            'amount' => $validated['infaq_amount'],
            'status' => 'pending',
            'note' => 'Pemotongan Gaji Infaq - '
                . $validated['period_month']
                . '/'
                . $validated['period_year']
                . ' - '
                . $validated['phone_number']
                . (! empty($validated['note']) ? ' - ' . $validated['note'] : ''),
        ];

        $payload = $this->markPayloadApprovedByAdmin(
            $payload,
            'Infaq dicatat dan disetujui otomatis oleh admin.'
        );

        $this->appendTransaction($payload);

        $message = $this->isFinanceAdmin()
            ? 'Infaq berhasil dicatat dan otomatis disetujui.'
            : 'Pengajuan pemotongan gaji infaq berhasil dikirim dan menunggu persetujuan admin.';

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', $message);
    }

    public function approve(Request $request, string $transaction)
    {
        $this->authorizeAdminAction();

        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
            'approval_evidence' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
        ]);

        $transactions = $this->getSheetCollection('trx_tabungan');

        $data = $transactions->firstWhere('id_transaction', $transaction);

        if (! $data) {
            abort(404);
        }

        if (($data['status'] ?? '') !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $fundType = $data['fund_type'] ?? '';
        $actionType = $data['action_type'] ?? '';
        $amount = (float) ($data['amount'] ?? 0);

        if ($amount <= 0) {
            return back()->with('error', 'Nominal transaksi tidak valid.');
        }

        if ($actionType === 'deposit') {
            if ($fundType === 'kas') {
                $this->updateKasBalance($this->getKasBalance() + $amount);
            } else {
                $this->increaseUserBalance(
                    $data['target_user_id'],
                    $data['target_user_name'],
                    $fundType,
                    $amount
                );
            }
        }

        if ($actionType === 'withdraw') {
            if (! in_array($fundType, $this->personalFundTypes, true)) {
                return back()->with('error', 'Jenis tabungan tidak valid untuk penarikan.');
            }

            $currentBalance = $this->getUserBalance($data['target_user_id'], $fundType);

            if ($currentBalance < $amount) {
                return back()->with('error', 'Saldo tidak mencukupi. Transaksi tidak dapat disetujui.');
            }

            $this->decreaseUserBalance(
                $data['target_user_id'],
                $data['target_user_name'],
                $fundType,
                $amount
            );
        }

        if ($actionType === 'expense') {
            return back()->with('error', 'Pengeluaran kas tidak diproses melalui approval ini.');
        }

        $evidencePath = $this->storeApprovalEvidence($request, $data);

        $this->updateTransactionStatus(
            $data,
            'approved',
            $validated['admin_note'] ?? 'Disetujui oleh admin.',
            $evidencePath
        );

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil disetujui.');
    }

    public function reject(Request $request, string $transaction)
    {
        $this->authorizeAdminAction();

        $transactions = $this->getSheetCollection('trx_tabungan');

        $data = $transactions->firstWhere('id_transaction', $transaction);

        if (! $data) {
            abort(404);
        }

        if (($data['status'] ?? '') !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        $this->updateTransactionStatus(
            $data,
            'rejected',
            $validated['admin_note'] ?? 'Ditolak oleh admin.'
        );

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil ditolak.');
    }

    public function export(Request $request)
    {
        $currentRole = $this->currentUserRole();
        $isAdmin = in_array($currentRole, ['superadmin', 'admin'], true);

        $rules = [
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'fund_type' => ['nullable', Rule::in($this->fundTypes)],
            'status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
        ];

        if ($isAdmin) {
            $rules['target_user_id'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        $startDate = ! empty($validated['start_date'])
            ? Carbon::parse($validated['start_date'])->startOfDay()
            : null;

        $endDate = ! empty($validated['end_date'])
            ? Carbon::parse($validated['end_date'])->endOfDay()
            : null;

        $targetUserId = $isAdmin
            ? ($validated['target_user_id'] ?? 'all')
            : $this->currentUserId();

        $transactions = $this->getSheetCollection('trx_tabungan')
            ->filter(function ($transaction) use ($isAdmin, $targetUserId, $validated, $startDate, $endDate) {
                if (! $isAdmin) {
                    $currentUserId = $this->currentUserId();

                    $isOwnTransaction =
                        (string) ($transaction['target_user_id'] ?? '') === (string) $currentUserId ||
                        (string) ($transaction['requested_by_id'] ?? '') === (string) $currentUserId;

                    if (! $isOwnTransaction) {
                        return false;
                    }
                }

                if ($isAdmin && ! empty($targetUserId) && $targetUserId !== 'all') {
                    $matchesTarget = (string) ($transaction['target_user_id'] ?? '') === (string) $targetUserId;
                    $matchesRequester = (string) ($transaction['requested_by_id'] ?? '') === (string) $targetUserId;

                    if (! $matchesTarget && ! $matchesRequester) {
                        return false;
                    }
                }

                if (! empty($validated['fund_type']) && ($transaction['fund_type'] ?? '') !== $validated['fund_type']) {
                    return false;
                }

                if (! empty($validated['status']) && ($transaction['status'] ?? '') !== $validated['status']) {
                    return false;
                }

                if ($startDate || $endDate) {
                    $requestedAt = $this->parseTransactionDate($transaction['requested_at'] ?? null);

                    if (! $requestedAt) {
                        return false;
                    }

                    if ($startDate && $requestedAt->lt($startDate)) {
                        return false;
                    }

                    if ($endDate && $requestedAt->gt($endDate)) {
                        return false;
                    }
                }

                return true;
            })
            ->sortBy(function ($transaction) {
                $date = $this->parseTransactionDate($transaction['requested_at'] ?? null);

                return $date
                    ? $date->timestamp
                    : (int) ($transaction['id_transaction'] ?? 0);
            })
            ->values();

        $owner = $this->resolveExportOwner((string) $targetUserId, $isAdmin);

        return $this->downloadTransactionsExcel(
            $transactions,
            $startDate,
            $endDate,
            (string) $targetUserId,
            $owner
        );
    }


    // PRIVATE METHODS //



    private function isFinanceAdmin(?string $role = null): bool
    {
        $role = $role !== null
            ? strtolower((string) $role)
            : $this->currentUserRole();

        return in_array($role, ['superadmin', 'admin'], true);
    }

    private function markPayloadApprovedByAdmin(array $payload, string $adminNote): array
    {
        if (! $this->isFinanceAdmin()) {
            return $payload;
        }

        $payload['status'] = 'approved';
        $payload['admin_note'] = $payload['admin_note'] ?? $adminNote;
        $payload['approved_by_id'] = $payload['approved_by_id'] ?? $this->currentUserId();
        $payload['approved_by_name'] = $payload['approved_by_name'] ?? $this->currentUserName();
        $payload['approved_at'] = $payload['approved_at'] ?? now()->format('Y-m-d H:i:s');

        return $payload;
    }

    private function applyApprovedBalanceEffect(array $payload, array $targetUser): void
    {
        if (($payload['status'] ?? '') !== 'approved') {
            return;
        }

        $fundType = $payload['fund_type'] ?? '';
        $actionType = $payload['action_type'] ?? '';
        $amount = (float) ($payload['amount'] ?? 0);

        if ($amount <= 0) {
            return;
        }

        if ($actionType === 'deposit') {
            if ($fundType === 'kas') {
                $this->updateKasBalance($this->getKasBalance() + $amount);
                return;
            }

            if (in_array($fundType, $this->personalFundTypes, true)) {
                $this->increaseUserBalance(
                    $targetUser['id_user'],
                    $targetUser['name'],
                    $fundType,
                    $amount
                );
            }

            return;
        }

        if ($actionType === 'withdraw') {
            if (in_array($fundType, $this->personalFundTypes, true)) {
                $this->decreaseUserBalance(
                    $targetUser['id_user'],
                    $targetUser['name'],
                    $fundType,
                    $amount
                );
            }
        }
    }

    private function appendTransaction(array $payload): array
    {
        $transactions = $this->getSheetCollection('trx_tabungan');

        $idTransaction = $this->getNextId($transactions, 'id_transaction');
        $transactionCode = $this->generateTransactionCode($idTransaction);

        $requestedById = $this->currentUserId();
        $requestedByName = $this->currentUserName();

        $requestedAt = now()->format('Y-m-d H:i:s');

        $row = [
            $idTransaction,
            $transactionCode,
            $requestedById,
            $requestedByName,
            $payload['target_user_id'] ?? '',
            $payload['target_user_name'] ?? '',
            $payload['fund_type'],
            $payload['action_type'],
            $payload['amount'],
            $payload['status'] ?? 'pending',
            $payload['note'] ?? '',
            $payload['admin_note'] ?? '',
            $payload['approved_by_id'] ?? '',
            $payload['approved_by_name'] ?? '',
            $requestedAt,
            $payload['approved_at'] ?? '',
            $payload['approval_evidence'] ?? '',
        ];

        $this->sheetService->appendRow($this->spreadsheetId, 'trx_tabungan', $row);

        return [
            'id_transaction' => $idTransaction,
            'transaction_code' => $transactionCode,
        ];
    }

    private function updateTransactionStatus(
        array $transaction,
        string $status,
        string $adminNote,
        string $approvalEvidence = ''
    ): void {
        $payload = [
            $transaction['id_transaction'],
            $transaction['transaction_code'],
            $transaction['requested_by_id'],
            $transaction['requested_by_name'],
            $transaction['target_user_id'],
            $transaction['target_user_name'],
            $transaction['fund_type'],
            $transaction['action_type'],
            $transaction['amount'],
            $status,
            $transaction['note'] ?? '',
            $adminNote,
            $this->currentUserId(),
            $this->currentUserName(),
            $transaction['requested_at'],
            now()->format('Y-m-d H:i:s'),
            $approvalEvidence ?: ($transaction['approval_evidence'] ?? ''),
        ];

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'trx_tabungan',
            (int) $transaction['_row_number'],
            $payload
        );
    }

    private function increaseUserBalance(string $userId, string $name, string $fundType, float $amount): void
    {
        $this->updateUserBalance($userId, $name, $fundType, $amount, 'increase');
    }

    private function decreaseUserBalance(string $userId, string $name, string $fundType, float $amount): void
    {
        $this->updateUserBalance($userId, $name, $fundType, $amount, 'decrease');
    }

    private function updateUserBalance(string $userId, string $name, string $fundType, float $amount, string $mode): void
    {
        $balances = $this->getSheetCollection('users_tabungan');

        $balance = $balances->firstWhere('id_user', $userId);

        $column = $fundType . '_balance';

        if (! in_array($fundType, $this->personalFundTypes, true)) {
            throw new \Exception('Jenis tabungan jamaah tidak valid.');
        }

        if (! $balance) {
            $nextId = $this->getNextId($balances, 'id_tabungan');

            $newQurbanBalance = $fundType === 'qurban' ? $amount : 0;
            $newUmrahBalance = $fundType === 'umrah' ? $amount : 0;

            if ($mode === 'decrease') {
                throw new \Exception('Saldo user belum tersedia.');
            }

            $this->sheetService->appendRow($this->spreadsheetId, 'users_tabungan', [
                $nextId,
                $userId,
                $name,
                $newQurbanBalance,
                $newUmrahBalance,
                now()->format('Y-m-d H:i:s'),
            ]);

            return;
        }

        $currentBalance = (float) ($balance[$column] ?? 0);

        $newBalance = $mode === 'increase'
            ? $currentBalance + $amount
            : $currentBalance - $amount;

        if ($newBalance < 0) {
            throw new \Exception('Saldo tidak mencukupi.');
        }

        $payload = [
            $balance['id_tabungan'],
            $userId,
            $name,
            $fundType === 'qurban' ? $newBalance : ($balance['qurban_balance'] ?? 0),
            $fundType === 'umrah' ? $newBalance : ($balance['umrah_balance'] ?? 0),
            now()->format('Y-m-d H:i:s'),
        ];

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'users_tabungan',
            (int) $balance['_row_number'],
            $payload
        );
    }

    private function getUserBalance(string $userId, string $fundType): float
    {
        $balances = $this->getSheetCollection('users_tabungan');

        $balance = $balances->firstWhere('id_user', $userId);

        if (! $balance) {
            return 0;
        }

        return (float) ($balance[$fundType . '_balance'] ?? 0);
    }

    private function getKasBalance(): float
    {
        $rows = $this->getSheetCollection('kas_tabungan');

        $kas = $rows->first();

        if (! $kas) {
            $this->sheetService->appendRow($this->spreadsheetId, 'kas_tabungan', [
                1,
                0,
                now()->format('Y-m-d H:i:s'),
            ]);

            return 0;
        }

        return (float) ($kas['balance'] ?? 0);
    }

    private function updateKasBalance(float $newBalance): void
    {
        $rows = $this->getSheetCollection('kas_tabungan');

        $kas = $rows->first();

        if (! $kas) {
            $this->sheetService->appendRow($this->spreadsheetId, 'kas_tabungan', [
                1,
                $newBalance,
                now()->format('Y-m-d H:i:s'),
            ]);

            return;
        }

        $payload = [
            $kas['id_kas'] ?? 1,
            $newBalance,
            now()->format('Y-m-d H:i:s'),
        ];

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'kas_tabungan',
            (int) $kas['_row_number'],
            $payload
        );
    }

    private function getActiveUsers(): Collection
    {
        return $this->getSheetCollection('users')
            ->filter(fn ($user) => strtolower($user['status'] ?? '') === 'active')
            ->values();
    }

    private function findUserById(string $userId): ?array
    {
        return $this->getSheetCollection('users')
            ->firstWhere('id_user', $userId);
    }

    private function getNextId(Collection $rows, string $column): int
    {
        $maxId = $rows
            ->pluck($column)
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->max();

        return $maxId ? $maxId + 1 : 1;
    }

    private function generateTransactionCode(int $idTransaction): string
    {
        return 'TRX-' . now()->format('Ymd') . '-' . str_pad((string) $idTransaction, 4, '0', STR_PAD_LEFT);
    }

    private function currentUserId(): string
    {
        return (string) (session('sheet_user.id_user') ?? auth()->id() ?? '');
    }

    private function currentUserName(): string
    {
        return (string) (session('sheet_user.name') ?? auth()->user()->name ?? 'Admin DKM');
    }

    private function currentUserRole(): string
    {
        return strtolower((string) (session('sheet_user.role') ?? 'karyawan'));
    }

    private function authorizeAdminAction(): void
    {
        if (! in_array($this->currentUserRole(), ['superadmin', 'admin'], true)) {
            abort(403, 'Kamu tidak memiliki akses untuk melakukan aksi ini.');
        }
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

    private function currentSheetUser(): array
    {
        return [
            'id_user' => $this->currentUserId(),
            'name' => $this->currentUserName(),
            'email' => session('sheet_user.email') ?? auth()->user()->email ?? '',
            'role' => $this->currentUserRole(),
            'status' => session('sheet_user.status') ?? 'active',
        ];
    }

    private function storeApprovalEvidence(Request $request, array $transaction): string
    {
        if (! $request->hasFile('approval_evidence')) {
            return '';
        }

        $file = $request->file('approval_evidence');

        $transactionCode = $transaction['transaction_code'] ?? 'transaction-' . ($transaction['id_transaction'] ?? time());
        $safeTransactionCode = preg_replace('/[^A-Za-z0-9\-]/', '-', $transactionCode);

        $folder = public_path('image/keuangan/evidence/' . $safeTransactionCode);

        if (! File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        foreach (File::glob($folder . '/*') as $oldFile) {
            File::delete($oldFile);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = 'approval-evidence.' . $extension;

        $file->move($folder, $filename);

        return 'image/keuangan/evidence/' . $safeTransactionCode . '/' . $filename;
    }

    private function getPendingWithdrawAmount(string $userId, string $fundType): float
    {
        return $this->getSheetCollection('trx_tabungan')
            ->filter(fn ($trx) =>
                (string) ($trx['target_user_id'] ?? '') === (string) $userId &&
                ($trx['fund_type'] ?? '') === $fundType &&
                ($trx['action_type'] ?? '') === 'withdraw' &&
                ($trx['status'] ?? '') === 'pending'
            )
            ->sum(fn ($trx) => (float) ($trx['amount'] ?? 0));
    }

    private function buildWithdrawBalanceSummary(Collection $users, array $fundTypes): array
    {
        $balances = $this->getSheetCollection('users_tabungan');
        $transactions = $this->getSheetCollection('trx_tabungan');

        $summary = [];

        foreach ($users as $user) {
            $userId = (string) ($user['id_user'] ?? '');

            if ($userId === '') {
                continue;
            }

            $balance = $balances->firstWhere('id_user', $userId);

            foreach ($fundTypes as $fundType) {
                $currentBalance = $balance
                    ? (float) ($balance[$fundType . '_balance'] ?? 0)
                    : 0;

                $pendingWithdrawAmount = $transactions
                    ->filter(fn ($trx) =>
                        (string) ($trx['target_user_id'] ?? '') === $userId &&
                        ($trx['fund_type'] ?? '') === $fundType &&
                        ($trx['action_type'] ?? '') === 'withdraw' &&
                        ($trx['status'] ?? '') === 'pending'
                    )
                    ->sum(fn ($trx) => (float) ($trx['amount'] ?? 0));

                $availableBalance = max($currentBalance - $pendingWithdrawAmount, 0);

                $summary[$userId][$fundType] = [
                    'known' => true,
                    'current_balance' => $currentBalance,
                    'pending_withdraw' => $pendingWithdrawAmount,
                    'available_balance' => $availableBalance,
                ];
            }
        }

        return $summary;
    }

    protected function filterTransactions(
        Collection $transactions,
        bool $canApprove,
        string $selectedUserId,
        string $dateFilter,
        string $startDateInput,
        string $endDateInput,
        string $selectedMonth,
        string $selectedYear
    ): Collection {
        return $transactions->filter(function ($transaction) use ($canApprove, $selectedUserId, $dateFilter, $startDateInput, $endDateInput, $selectedMonth, $selectedYear) {
            if ($canApprove && $selectedUserId !== '') {
                $matchesTarget = (string) ($transaction['target_user_id'] ?? '') === (string) $selectedUserId;
                $matchesRequester = (string) ($transaction['requested_by_id'] ?? '') === (string) $selectedUserId;

                if (! $matchesTarget && ! $matchesRequester) {
                    return false;
                }
            }

            if ($dateFilter === 'range') {
                $startDate = ! empty($startDateInput) ? $this->parseTransactionDate($startDateInput) : null;
                $endDate = ! empty($endDateInput) ? $this->parseTransactionDate($endDateInput) : null;
                $requestedAt = $this->parseTransactionDate($transaction['requested_at'] ?? null);

                if (! $requestedAt) {
                    return false;
                }

                if ($startDate && $requestedAt->lt($startDate)) {
                    return false;
                }

                if ($endDate && $requestedAt->gt($endDate)) {
                    return false;
                }
            } elseif ($dateFilter === 'month' && $selectedMonth !== '') {
                $requestedAt = $this->parseTransactionDate($transaction['requested_at'] ?? null);

                if (! $requestedAt) {
                    return false;
                }

                $expectedMonth = (int) $selectedMonth;
                $expectedYear = $selectedYear !== '' ? (int) $selectedYear : $requestedAt->year;

                if ($requestedAt->month !== $expectedMonth || $requestedAt->year !== $expectedYear) {
                    return false;
                }
            } elseif ($dateFilter === 'year' && $selectedYear !== '') {
                $requestedAt = $this->parseTransactionDate($transaction['requested_at'] ?? null);

                if (! $requestedAt) {
                    return false;
                }

                if ($requestedAt->year !== (int) $selectedYear) {
                    return false;
                }
            }

            return true;
        })->values();
    }

    private function parseTransactionDate(?string $value): ?Carbon
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (is_numeric($value)) {
            $serial = (float) $value;

            if ($serial > 1000) {
                $days = (int) floor($serial);
                $fraction = $serial - $days;
                $seconds = (int) round($fraction * 86400);

                return Carbon::create(1899, 12, 30, 0, 0, 0, config('app.timezone', 'Asia/Jakarta'))
                    ->addDays($days)
                    ->addSeconds($seconds);
            }
        }

        $formats = [
            'Y-m-d H:i:s',
            'Y-m-d H:i',
            'Y-m-d',
            'd/m/Y H:i:s',
            'd/m/Y H:i',
            'd/m/Y',
            'm/d/Y H:i:s',
            'm/d/Y H:i',
            'm/d/Y',
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);

                if ($date) {
                    return $date;
                }
            } catch (\Throwable $e) {
                //
            }
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function formatTransactionDateForExport(?string $value): string
    {
        $date = $this->parseTransactionDate($value);

        if ($date) {
            return $date->format('Y-m-d H:i:s');
        }

        return trim((string) $value) ?: '-';
    }

    private function resolveExportOwner(string $targetUserId, bool $isAdmin): array
    {
        if ($isAdmin && ($targetUserId === '' || $targetUserId === 'all')) {
            return [
                'name' => 'Semua Karyawan / Kas',
                'nrp' => '-',
            ];
        }

        $userId = $isAdmin
            ? $targetUserId
            : $this->currentUserId();

        $user = $this->findUserById($userId);

        return [
            'name' => $user['name'] ?? $this->currentUserName(),
            'nrp' => $user['nrp'] ?? '-',
        ];
    }

    private function downloadTransactionsExcel(
        Collection $transactions,
        Carbon $startDate,
        Carbon $endDate,
        string $targetUserId,
        array $owner
    ) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Laporan Keuangan');

        $periodText = $startDate || $endDate
            ? ($startDate?->format('d/m/Y') ?? '-') . ' - ' . ($endDate?->format('d/m/Y') ?? '-')
            : 'Semua Periode';

        $sheet->setCellValue('A1', 'Laporan Keuangan DKM AL HIKMAH');

        $sheet->setCellValue('A2', 'Periode');
        $sheet->setCellValue('B2', $periodText);
        $sheet->setCellValue('A3', 'Nama Pemilik Laporan');
        $sheet->setCellValue('B3', $owner['name'] ?? '-');

        $sheet->setCellValue('A4', 'NRP');
        $sheet->setCellValue('B4', $owner['nrp'] ?? '-');

        $sheet->setCellValue('A5', 'Dicetak Oleh');
        $sheet->setCellValue('B5', $this->currentUserName());

        $sheet->setCellValue('A6', 'Tanggal Cetak');
        $sheet->setCellValue('B6', now()->format('d/m/Y H:i:s'));

        $headers = [
            'No',
            'Jenis Transaksi',
            'Aksi',
            'Tanggal',
            'Nominal',
        ];

        $headerRow = 8;

        foreach ($headers as $index => $header) {
            $columnLetter = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue($columnLetter . $headerRow, $header);
        }

        $rowNumber = $headerRow + 1;

        if ($transactions->isEmpty()) {
            $sheet->mergeCells("A{$rowNumber}:E{$rowNumber}");
            $sheet->setCellValue("A{$rowNumber}", 'Tidak ada data transaksi sesuai filter yang dipilih.');

            $sheet->getStyle("A{$rowNumber}")->applyFromArray([
                'font' => [
                    'italic' => true,
                    'color' => ['rgb' => '64748B'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ]);

            $lastDataRow = $rowNumber;
        } else {
            foreach ($transactions as $index => $transaction) {
                $amount = (float) ($transaction['amount'] ?? 0);

                $actionLabel = match ($transaction['action_type'] ?? '') {
                    'deposit' => 'Setor',
                    'withdraw' => 'Ambil',
                    'expense' => 'Kas Keluar',
                    'salary_deduction' => 'Infaq',
                    default => ucfirst($transaction['action_type'] ?? '-'),
                };

                $rowValues = [
                    $index + 1,
                    ucfirst($transaction['fund_type'] ?? '-'),
                    $actionLabel,
                    $this->formatTransactionDateForExport(
                        $transaction['requested_at'] ?? ''
                    ),
                    $amount,
                ];

                foreach ($rowValues as $columnIndex => $value) {
                    $columnLetter = Coordinate::stringFromColumnIndex($columnIndex + 1);
                    $sheet->setCellValue($columnLetter . $rowNumber, $value);
                }

                $rowNumber++;
            }

            $lastDataRow = $rowNumber - 1;
            $summaryRow = $lastDataRow + 3;

            $totalQurban = $transactions
                ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'qurban')
                ->sum(function ($trx) {
                    $amount = (float) ($trx['amount'] ?? 0);
                    return ($trx['action_type'] ?? '') === 'withdraw'
                        ? -$amount
                        : $amount;
                });

            $totalUmrah = $transactions
                ->filter(fn ($trx) => strtolower($trx['fund_type'] ?? '') === 'umrah')
                ->sum(function ($trx) {
                    $amount = (float) ($trx['amount'] ?? 0);
                    return ($trx['action_type'] ?? '') === 'withdraw'
                        ? -$amount
                        : $amount;
                });

            $sheet->setCellValue(
                "A{$summaryRow}",
                'Total Tabungan Qurban'
            );

            $sheet->setCellValue(
                "B{$summaryRow}",
                $totalQurban
            );


            $sheet->setCellValue(
                "A" . ($summaryRow + 1),
                'Total Tabungan Umrah'
            );

            $sheet->setCellValue(
                "B" . ($summaryRow + 1),
                $totalUmrah
            );
        }

        $lastColumn = 'E';

        $sheet->mergeCells('A1:E1');

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle("A{$headerRow}:{$lastColumn}{$headerRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        $sheet->getStyle("A{$headerRow}:{$lastColumn}{$lastDataRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ]);

        if ($lastDataRow >= 7 && $transactions->isNotEmpty()) {
            $sheet->getStyle("E9:E{$lastDataRow}")
                ->getNumberFormat()
                ->setFormatCode('#,##0');

            $sheet->getStyle("A8:E{$lastDataRow}")
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_TOP);

            $sheet->getStyle("A8:E{$lastDataRow}")
                ->getAlignment()
                ->setWrapText(true);
        }

        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(18);

        $sheet->freezePane('A7');
        $sheet->setAutoFilter("A{$headerRow}:{$lastColumn}{$lastDataRow}");

        $exportDir = storage_path('app/exports');

        if (! File::exists($exportDir)) {
            File::makeDirectory($exportDir, 0755, true);
        }

        $fileName = 'laporan-keuangan-'
            . ($startDate ? $startDate->format('Ymd') : 'all')
            . '-'
            . ($endDate ? $endDate->format('Ymd') : 'all')
            . '.xlsx';

        $path = $exportDir . DIRECTORY_SEPARATOR . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()
            ->download($path, $fileName)
            ->deleteFileAfterSend(true);
    }

    public function importForm()
    {
        $this->authorizeAdminAction();

        return view('admin.keuangan.import');
    }

    public function importStore(Request $request)
    {
        $this->authorizeAdminAction();
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv'
            ]
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $rows = collect($spreadsheet->getActiveSheet()->toArray());
        $header = $rows->shift();
        $imported = 0;
        $failed = [];

        foreach ($rows as $index => $row) {
            if (!array_filter($row)) {
                continue;
            }

            try {
                $data = [
                    'nrp' => trim($row[1] ?? ''),
                    'fund_type' => strtolower(trim($row[2] ?? '')),
                    'action' => strtolower(trim($row[3] ?? '')),
                    'amount' => $this->parseImportAmount($row[4] ?? 0),
                    'date' => $row[5] ?? null,
                ];

                $user = $this->findUserByNrp($data['nrp']);

                if (!$user) {
                    throw new \Exception(
                        "NRP {$data['nrp']} tidak ditemukan"
                    );
                }

                $fundType = $this->normalizeFundType(
                    $data['fund_type']
                );

                $actionType = $this->normalizeActionType(
                    $data['action']
                );

                $transaction = $this->appendTransaction([
                    'target_user_id' => $user['id_user'],
                    'target_user_name' => $user['name'],
                    'fund_type' => $fundType,
                    'action_type' => $actionType,
                    'amount' => $data['amount'],
                    'status' => 'approved',
                    'note' => 'Import Excel',
                ]);

                if ($fundType === 'qurban' || $fundType === 'umrah') {
                    if ($actionType === 'deposit') {
                        $this->increaseUserBalance(
                            $user['id_user'],
                            $user['name'],
                            $fundType,
                            $data['amount']
                        );
                    }

                    if ($actionType === 'withdraw') {
                        $this->decreaseUserBalance(
                            $user['id_user'],
                            $user['name'],
                            $fundType,
                            $data['amount']
                        );
                    }
                }

                $imported++;
            } catch(\Throwable $e) {
                $failed[] = [
                    'row' => $index + 2,
                    'message'=>$e->getMessage()
                ];
            }

        }

        return redirect()
            ->route('admin.keuangan.index')
            ->with(
                'success',
                "{$imported} transaksi berhasil diimport."
            );

    }

    private function findUserByNrp(string $nrp): ?array
    {
        return $this->getSheetCollection('users')
            ->first(function ($user) use ($nrp){
                return trim(
                    (string)($user['nrp'] ?? '')
                ) === trim($nrp);
            });
    }

    private function normalizeFundType(string $value): string
    {
        return match(strtolower($value)){
            'qurban' => 'qurban',
            'umrah' => 'umrah',
            'infaq' => 'infaq',
            'kas' => 'kas',

            default => throw new \Exception(
                "Jenis transaksi tidak valid: {$value}"
            )
        };
    }

    private function normalizeActionType(string $value): string
    {
        return match(strtolower($value)){
            'setor',
            'deposit' => 'deposit',

            'ambil',
            'withdraw' => 'withdraw',

            'infaq',
            'potong',
            'salary deduction' => 'salary_deduction',

            'kas keluar',
            'expense' => 'expense',

            default => throw new \Exception(
                "Aksi tidak valid: {$value}"
            )

        };
    }

    protected function parseImportAmount($value): float
    {
        $text = trim((string) $value);

        if ($text === '') {
            return 0.0;
        }

        // Indonesian thousands separator syntax.
        if (preg_match('/^[0-9]{1,3}(\.[0-9]{3})*(,[0-9]+)?$/', $text)) {
            $normalized = str_replace(['.', ','], ['', '.'], $text);
            return (float) $normalized;
        }

        // Indonesian decimal-only syntax.
        if (preg_match('/^[0-9]+(,[0-9]+)?$/', $text)) {
            $normalized = str_replace(',', '.', $text);
            return (float) $normalized;
        }

        return is_numeric($text) ? (float) $text : 0.0;
    }
}