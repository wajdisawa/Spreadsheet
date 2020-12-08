<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Google;

/**
 * Interface PermissionInterface
 * @package Wajdisawa\spreadsheet\Domain\Google
 */
interface PermissionInterface
{
    /**
     * @param string $sheetId
     */
    public function createSharePermission(string $sheetId): void;

}
