<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Google;

use Google_Client;

/**
 * Interface AuthenticatorInterface
 * @package Wajdisawa\spreadsheet\Infrastructure
 */
interface AuthenticatorInterface
{
    public function authenticate(): Google_Client;
}
