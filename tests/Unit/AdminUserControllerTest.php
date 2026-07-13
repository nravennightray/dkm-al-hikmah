<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\AdminUserController;
use App\Services\GoogleSheetService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    public function testItSkipsExistingNrpOrNameAndKeepsNewRows(): void
    {
        config(['google.spreadsheet_id' => 'test-sheet-id']);

        $controller = new class($this->createMock(GoogleSheetService::class)) extends AdminUserController {
            public function exposeBuildImportPayloads(array $rows, Collection $existingUsers): array
            {
                return $this->buildImportPayloads($rows, $existingUsers);
            }
        };

        $existingUsers = collect([
            ['nrp' => '1001', 'name' => 'Ada'],
            ['nrp' => '1002', 'name' => 'Budi'],
        ]);

        $rows = [
            ['1001', 'Ada'],
            ['1002', 'Budi'],
            ['1003', 'Cici'],
            ['', 'Dedi'],
            ['1004', ''],
            ['1005', 'Eko'],
        ];

        $result = $controller->exposeBuildImportPayloads($rows, $existingUsers);

        $this->assertCount(2, $result['payloads']);
        $this->assertSame('1003', $result['payloads'][0]['nrp']);
        $this->assertSame('1005', $result['payloads'][1]['nrp']);
        $this->assertSame(4, $result['skipped']);
    }
}
