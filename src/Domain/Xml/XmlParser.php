<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Domain\Xml;

use SimpleXMLElement;

/**
 * Class XmlParser
 * @package Wajdisawa\spreadsheet\Domain\Xml
 */
class XmlParser implements XmlParserInterface
{
    /**
     * @param string $xmlFile
     * @return array
     */
    public function xmlFileToArray(string $xmlFile): array
    {
        $xmlString = simplexml_load_string(
            file_get_contents($xmlFile, true),
            SimpleXMLElement::class,
            LIBXML_NOCDATA
        );
        return $this->xmlToArray($xmlString);
    }

    /**
     * @param SimpleXMLElement $xmlObject
     * @param array $outArray
     * @return array
     */
    private function xmlToArray(SimpleXMLElement $xmlObject, array $outArray = []): array
    {
        foreach ((array)$xmlObject as $index => $node) {
            $outArray[$index] = (is_object($node)) ? $this->xmlToArray($node) : $node;
        }
        return $outArray;
    }
}
