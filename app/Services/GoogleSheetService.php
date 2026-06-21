<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\DeleteDimensionRequest;
use Google\Service\Sheets\DimensionRange;
use Google\Service\Sheets\Request as SheetRequest;
use Google\Service\Sheets\ValueRange;

class GoogleSheetService
{
    protected Sheets $service;

    public function __construct()
    {
        $client = new Client();

        $client->setAuthConfig(config('google.service.file'));

        $client->setScopes([
            Sheets::SPREADSHEETS,
        ]);

        $this->service = new Sheets($client);
    }

    public function getSheet(string $spreadsheetId, string $sheetName): array
    {
        $response = $this->service->spreadsheets_values->get(
            $spreadsheetId,
            "{$sheetName}!A:Z"
        );

        return $response->getValues() ?? [];
    }

    public function appendRow(string $spreadsheetId, string $sheetName, array $values): void
    {
        $body = new ValueRange([
            'values' => [$values],
        ]);

        $this->service->spreadsheets_values->append(
            $spreadsheetId,
            $sheetName,
            $body,
            [
                'valueInputOption' => 'USER_ENTERED',
                'insertDataOption' => 'INSERT_ROWS',
            ]
        );
    }

    public function updateRow(string $spreadsheetId, string $sheetName, int $rowNumber, array $values, string $endColumn): void
    {
        $range = "{$sheetName}!A{$rowNumber}:{$endColumn}{$rowNumber}";

        $body = new ValueRange([
            'values' => [$values],
        ]);

        $this->service->spreadsheets_values->update(
            $spreadsheetId,
            $range,
            $body,
            [
                'valueInputOption' => 'USER_ENTERED',
            ]
        );
    }

    public function deleteRow(string $spreadsheetId, string $sheetName, int $rowNumber): void
    {
        $sheetId = $this->getSheetId($spreadsheetId, $sheetName);

        $request = new BatchUpdateSpreadsheetRequest([
            'requests' => [
                new SheetRequest([
                    'deleteDimension' => new DeleteDimensionRequest([
                        'range' => new DimensionRange([
                            'sheetId' => $sheetId,
                            'dimension' => 'ROWS',
                            'startIndex' => $rowNumber - 1,
                            'endIndex' => $rowNumber,
                        ]),
                    ]),
                ]),
            ],
        ]);

        $this->service->spreadsheets->batchUpdate($spreadsheetId, $request);
    }

    private function getSheetId(string $spreadsheetId, string $sheetName): int
    {
        $spreadsheet = $this->service->spreadsheets->get($spreadsheetId);

        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                return $sheet->getProperties()->getSheetId();
            }
        }

        throw new \Exception("Sheet {$sheetName} tidak ditemukan.");
    }
}