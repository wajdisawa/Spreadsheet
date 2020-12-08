<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Infrastructure;

/**
 * Interface SheetCreatorInterface
 * @package Wajdisawa\spreadsheet\Infrastructure
 */
interface SheetCreatorInterface
{
    public function create(array $dataArray, string $sheetTitle): bool;
}
