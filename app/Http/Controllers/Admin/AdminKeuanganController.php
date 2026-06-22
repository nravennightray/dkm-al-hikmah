<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AdminKeuanganController extends Controller
{
    protected GoogleSheetService $sheetService;
    protected string $spreadsheetId;

    private array $fundTypes = [
        'qurban',
        'umrah',
        'kas',
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
        $transactions = $this->getSheetCollection('trx_tabungan')
            ->sortByDesc(fn ($transaction) => (int) ($transaction['id_transaction'] ?? 0))
            ->values();

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

        return view('admin.keuangan.index', compact('transactions'));
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

        $rules = [
            'fund_type' => ['required', Rule::in($this->fundTypes)],
            'amount' => ['required', 'numeric', 'min:1000'],
            'note' => ['nullable', 'string', 'max:500'],
        ];

        if (in_array($currentRole, ['superadmin', 'admin'], true)) {
            $rules['target_user_id'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        if (in_array($currentRole, ['superadmin', 'admin'], true)) {
            $targetUserId = $validated['target_user_id'];
        } else {
            $targetUserId = $this->currentUserId();
        }

        $targetUser = $this->findUserById($targetUserId);

        if (! $targetUser) {
            return back()
                ->withInput()
                ->with('error', 'User tujuan tidak ditemukan.');
        }

        $this->appendTransaction([
            'target_user_id' => $targetUser['id_user'],
            'target_user_name' => $targetUser['name'],
            'fund_type' => $validated['fund_type'],
            'action_type' => 'deposit',
            'amount' => $validated['amount'],
            'status' => 'pending',
            'note' => $validated['note'] ?? '',
        ]);

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Pengajuan setor tabungan berhasil dikirim dan menunggu persetujuan admin.');
    }

    public function createWithdraw()
    {
        $currentRole = $this->currentUserRole();

        $users = in_array($currentRole, ['superadmin', 'admin'], true)
            ? $this->getActiveUsers()
            : collect([$this->currentSheetUser()]);

        $fundTypes = $this->personalFundTypes;

        return view('admin.keuangan.withdraw-create', compact('users', 'fundTypes', 'currentRole'));
    }

    public function storeWithdraw(Request $request)
    {
        $currentRole = $this->currentUserRole();

        $rules = [
            'fund_type' => ['required', Rule::in($this->personalFundTypes)],
            'amount' => ['required', 'numeric', 'min:1000'],
            'note' => ['nullable', 'string', 'max:500'],
        ];

        if (in_array($currentRole, ['superadmin', 'admin'], true)) {
            $rules['target_user_id'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        if (in_array($currentRole, ['superadmin', 'admin'], true)) {
            $targetUserId = $validated['target_user_id'];
        } else {
            $targetUserId = $this->currentUserId();
        }

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

        if ($currentBalance < (float) $validated['amount']) {
            return back()
                ->withInput()
                ->with('error', 'Saldo tidak mencukupi untuk pengajuan penarikan.');
        }

        $this->appendTransaction([
            'target_user_id' => $targetUser['id_user'],
            'target_user_name' => $targetUser['name'],
            'fund_type' => $validated['fund_type'],
            'action_type' => 'withdraw',
            'amount' => $validated['amount'],
            'status' => 'pending',
            'note' => $validated['note'] ?? '',
        ]);

        return redirect()
            ->route('admin.keuangan.index')
            ->with('success', 'Pengajuan ambil tabungan berhasil dikirim dan menunggu persetujuan admin.');
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
        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'trx_tabungan',
            $transaction['_row_number'],
            [
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
            ],
            'Q'
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

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'users_tabungan',
            $balance['_row_number'],
            [
                $balance['id_tabungan'],
                $userId,
                $name,
                $fundType === 'qurban' ? $newBalance : ($balance['qurban_balance'] ?? 0),
                $fundType === 'umrah' ? $newBalance : ($balance['umrah_balance'] ?? 0),
                now()->format('Y-m-d H:i:s'),
            ],
            'F'
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

        $this->sheetService->updateRow(
            $this->spreadsheetId,
            'kas_tabungan',
            $kas['_row_number'],
            [
                $kas['id_kas'] ?? 1,
                $newBalance,
                now()->format('Y-m-d H:i:s'),
            ],
            'C'
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
}