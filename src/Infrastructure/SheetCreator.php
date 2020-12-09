<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Infrastructure;

use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateSpreadsheetRequest;
use Slim\Logger;
use Wajdisawa\spreadsheet\Domain\Google\Authenticator;
use Wajdisawa\spreadsheet\Domain\Google\AuthenticatorInterface;
use Wajdisawa\spreadsheet\Domain\Google\Permission;
use Wajdisawa\spreadsheet\Domain\Google\Sheet;

/**
 * Class SheetCreator
 * @package Wajdisawa\spreadsheet\Infrastructure
 */
class SheetCreator implements SheetCreatorInterface
{
    public const SHEET_ID = 0;

    /**
     * @var AuthenticatorInterface
     */
    private AuthenticatorInterface $auth;

    /**
     * @var Logger
     */
    private logger $logger;

    /**
     * SheetCreator constructor.
     * @param Authenticator $auth
     * @param Logger $logger
     */
    public function __construct(Authenticator $auth, Logger $logger)
    {
        $this->auth = $auth;
        $this->logger = $logger;
    }

    /**
     * @param array $dataArray
     * @param string $sheetTitle
     * @return bool
     * @throws \Google\Exception
     */
    public function create(array $dataArray, string $sheetTitle): bool
    {
        $client = $this->auth->authenticate();
        $service = new Google_Service_Sheets($client);
        $sheet = new Sheet($service);
        $spreadsheetId = $sheet->createSheet($sheetTitle);
        (new Permission($client))->createSharePermission($spreadsheetId);
        $requests = array();
        foreach ($dataArray as $data) {
            foreach ($data as $item) {
                $requests[] = $sheet->addRow(self::SHEET_ID, (array)$item);
            }
        }
        $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
            'requests' => $requests
        ));
        try {
            $response = $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
            if ($response->valid()) {
                return true;
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
        return false;
    }
}
