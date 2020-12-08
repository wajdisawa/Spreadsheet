<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Xml;

/**
 * Interface XmlParserInterface
 * @package Wajdisawa\spreadsheet\Domain\Xml
 */
interface XmlParserInterface
{
    /**
     * @param string $xmlFile
     * @return array
     */
    public function xmlFileToArray(string $xmlFile): array;
}
