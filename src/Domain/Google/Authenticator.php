<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Google;

use Google\Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Sheets;

/**
 * Class Authenticator
 * @package Wajdisawa\spreadsheet\Domain\Google
 */
final class Authenticator implements AuthenticatorInterface
{

    public const APPLICATION_NAME = 'productsUp';
    public const ACCESS_TYPE = 'offline';
    public const AUTH_CONFIG = 'AUTH_CONFIG';

    /**
     * @return Google_Client
     * @throws Exception
     */
    public function authenticate(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName(self::APPLICATION_NAME);
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS, Google_Service_Drive::DRIVE]);
        $client->setAccessType(self::ACCESS_TYPE);
        $client->setAuthConfig(realpath(\Config::getEnv(self::AUTH_CONFIG)));
        return $client;
    }
}
