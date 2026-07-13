<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\AdminKeuanganController;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AdminKeuanganControllerTest extends TestCase
{
    public function testItFiltersTransactionsBySelectedUserAndDateRange(): void
    {
        config(['google.spreadsheet_id' => 'test-sheet-id']);

        $controller = new class($this->createMock(GoogleSheetService::class)) extends AdminKeuanganController {
            public function exposeFilterTransactions(
                Collection $transactions,
                bool $canApprove,
                string $selectedUserId,
                string $dateFilter,
                string $startDateInput,
                string $endDateInput,
                string $selectedMonth,
                string $selectedYear
            ): Collection {
                return $this->filterTransactions(
                    $transactions,
                    $canApprove,
                    $selectedUserId,
                    $dateFilter,
                    $startDateInput,
                    $endDateInput,
                    $selectedMonth,
                    $selectedYear
                );
            }
        };

        $transactions = collect([
            [
                'id_transaction' => '1',
                'target_user_id' => '100',
                'requested_by_id' => '200',
                'requested_at' => '2024-02-01 10:00:00',
            ],
            [
                'id_transaction' => '2',
                'target_user_id' => '300',
                'requested_by_id' => '400',
                'requested_at' => '2024-03-05 10:00:00',
            ],
            [
                'id_transaction' => '3',
                'target_user_id' => '300',
                'requested_by_id' => '500',
                'requested_at' => '2024-04-01 10:00:00',
            ],
        ]);

        $filtered = $controller->exposeFilterTransactions(
            $transactions,
            true,
            '300',
            'range',
            '2024-03-01',
            '2024-03-31',
            '',
            ''
        );

        $this->assertCount(1, $filtered);
        $this->assertSame('2', $filtered->first()['id_transaction']);
    }

    public function testItParsesIndonesianAmountFormattingForImport(): void
    {
        config(['google.spreadsheet_id' => 'test-sheet-id']);

        $controller = new class($this->createMock(GoogleSheetService::class)) extends AdminKeuanganController {
            public function exposeParseImportAmount($value): float
            {
                return $this->parseImportAmount($value);
            }
        };

        $this->assertSame(500000.0, $controller->exposeParseImportAmount('500.000'));
        $this->assertSame(1234567.0, $controller->exposeParseImportAmount('1.234.567'));
        $this->assertSame(8500.5, $controller->exposeParseImportAmount('8.500,50'));
        $this->assertSame(0.0, $controller->exposeParseImportAmount(''));
    }
}
