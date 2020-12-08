<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Google;

use Google_Service_Sheets_Request;

/**
 * Interface SheetInterface
 * @package Wajdisawa\spreadsheet\Domain\Google
 */
interface SheetInterface
{
    /**
     * @param string $title
     * @return string
     */
    public function createSheet(string $title): string;

    /**
     * @param int $sheetId
     * @param array $newValues
     * @return Google_Service_Sheets_Request
     */
    public function addRow(int $sheetId, array $newValues = []): Google_Service_Sheets_Request;
}
