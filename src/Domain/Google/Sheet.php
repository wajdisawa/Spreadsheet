<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Google;

use Google_Service_Sheets;
use Google_Service_Sheets_AppendCellsRequest;
use Google_Service_Sheets_CellData;
use Google_Service_Sheets_ExtendedValue;
use Google_Service_Sheets_Request;
use Google_Service_Sheets_RowData;
use Google_Service_Sheets_Spreadsheet;
use SimpleXMLElement;

/**
 * Class Sheet
 * @package Wajdisawa\spreadsheet\Domain\Google
 */
final class Sheet implements SheetInterface
{
    public const SPREADSHEET_ID = 'spreadsheetId';
    public const USER_ENTERED_VALUE = 'userEnteredValue';

    /**
     * @var Google_Service_Sheets
     */
    private Google_Service_Sheets $service;

    /**
     * Sheet constructor.
     * @param Google_Service_Sheets $service
     */
    public function __construct(Google_Service_Sheets $service)
    {
        $this->service = $service;
    }

    /**
     * @param string $title
     * @return string
     */
    public function createSheet(string $title): string
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => $title
            ]
        ]);
        $spreadsheet = $this->service->spreadsheets->create($spreadsheet, [
            'fields' => self::SPREADSHEET_ID
        ]);
        return $spreadsheet->spreadsheetId;
    }

    /**
     * @param int $sheetId
     * @param array $newValues
     * @return Google_Service_Sheets_Request
     */
    public function addRow(int $sheetId, array $newValues = []): Google_Service_Sheets_Request
    {
        $values = [];
        foreach ($newValues as $d) {
//            TODO: remove this from here
            if ($d instanceof SimpleXMLElement) {
                continue;
            }
            $cellData = new Google_Service_Sheets_CellData();
            $value = new Google_Service_Sheets_ExtendedValue();
            if (is_numeric($d)) {
                $value->setNumberValue((float)$d);
            } else {
                $value->setStringValue($d);
            }
            $cellData->setUserEnteredValue($value);
            $values[] = $cellData;
        }
        $rowData = new Google_Service_Sheets_RowData();
        $rowData->setValues($values);
        $append_request = new Google_Service_Sheets_AppendCellsRequest();
        $append_request->setSheetId($sheetId);
        $append_request->setRows($rowData);
        $append_request->setFields(self::USER_ENTERED_VALUE);
        $request = new Google_Service_Sheets_Request();
        $request->setAppendCells($append_request);
        return $request;
    }
}
