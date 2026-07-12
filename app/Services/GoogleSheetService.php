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
                'valueInputOption' => 'RAW',
                'insertDataOption' => 'INSERT_ROWS',
            ]
        );
    }

    public function updateRow(
        string $spreadsheetId,
        string $sheetName,
        int $rowNumber,
        array $values,
        ?string $endColumn = null,
        string $startColumn = 'A'
    ): void {
        $values = array_values($values);

        $startColumn = strtoupper($startColumn);
        $endColumn = $endColumn
            ? strtoupper($endColumn)
            : $this->getEndColumn($startColumn, count($values));

        $range = "{$sheetName}!{$startColumn}{$rowNumber}:{$endColumn}{$rowNumber}";

        $body = new ValueRange([
            'majorDimension' => 'ROWS',
            'values' => [$values],
        ]);

        $this->service->spreadsheets_values->update(
            $spreadsheetId,
            $range,
            $body,
            [
                'valueInputOption' => 'RAW',
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

    private function getEndColumn(string $startColumn, int $columnCount): string
    {
        $startIndex = $this->columnLetterToNumber($startColumn);
        $endIndex = $startIndex + $columnCount - 1;

        return $this->numberToColumnLetter($endIndex);
    }

    private function columnLetterToNumber(string $column): int
    {
        $column = strtoupper($column);
        $number = 0;

        for ($i = 0; $i < strlen($column); $i++) {
            $number = ($number * 26) + (ord($column[$i]) - ord('A') + 1);
        }

        return $number;
    }

    private function numberToColumnLetter(int $number): string
    {
        $letter = '';

        while ($number > 0) {
            $mod = ($number - 1) % 26;
            $letter = chr(65 + $mod) . $letter;
            $number = intdiv($number - $mod, 26);
        }

        return $letter;
    }
}