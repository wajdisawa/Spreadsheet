<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Google;

use Config;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_Permission;

final class Permission implements PermissionInterface
{
    public const USER = 'user';
    public const SHEET_PERMISSION = 'SHEET_PERMISSION';
    public const DEFAULT_PERMISSION = 'writer';
    public const SHEET_SHARE_EMAIL = 'SHEET_SHARE_EMAIL';
    public const SEND_NOTIFICATION_EMAIL = 'sendNotificationEmail';
    public const SEND_NOTIFICATION_EMAIL_ENV = 'SEND_NOTIFICATION_EMAIL';

    private Google_Client $client;

    /**
     * Permission constructor.
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $sheetId
     */
    public function createSharePermission(string $sheetId): void
    {
        $permission = new Google_Service_Drive_Permission();
        $permission->setType(self::USER);
        $permission->setRole(Config::getEnv(self::SHEET_PERMISSION, self::DEFAULT_PERMISSION));
        $permission->setEmailAddress(Config::getEnv(self::SHEET_SHARE_EMAIL));
        $service = new Google_Service_Drive($this->client);
        $service->permissions->create(
            $sheetId,
            $permission,
            array(
                self::SEND_NOTIFICATION_EMAIL => Config::getEnv(self::SEND_NOTIFICATION_EMAIL_ENV)
            )
        );
    }
}
