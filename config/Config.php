<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

/**
 * Class config
 * @package Wajdisawa\spreadsheet\config
 */
class Config
{
    /**
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getEnv(string $key, string $default=null): ?string
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}
