<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Tests\Domain\Xml;

use Wajdisawa\spreadsheet\Domain\Xml\XmlParser;
use PHPUnit\Framework\TestCase;

/**
 * Class XmlParserTest
 * @package Wajdisawa\spreadsheet\Tests\Domain\Xml
 */
class XmlParserTest extends TestCase
{
    public function testXmlFileToArray(): void
    {
        $xmlFile = 'tests/data/coffee_feed.xml';
        $expectedArray =
            [
                'item' =>
                    [
                        'entity_id' => 6926, 'CategoryName' => 'New Products', 'sku' => '6336C',
                        'name' => 'Green Mountain Coffee Toasted Marshmallow Mocha K-cup Pods 96ct',
                        'description' =>
                            [],
                        'shortdesc' => 'Green Mountain Coffee Toasted Marshmallow Mocha K-cup Pods 96ct is like drinking a smores right from the fire place. Transport yourself back the holidays with this delicious coffee treat.',
                        'price' => 59.9600,
                        'link' => 'http://www.coffeeforless.com/green-mountain-coffee-toasted-marshmallow-mocha-k-cup-pods-96ct.html',
                        'image' => 'http://mcdn.coffeeforless.com/media/catalog/product//g/r/green-montain-toasted-marshmallow-mocha-kcup-pods_1.jpg',
                        'Brand' => 'Green Mountain Coffee',
                        'Rating' => 5,
                        'CaffeineType' => 'Caffeinated',
                        'Count' => 96,
                        'Flavored' => 'Yes',
                        'Seasonal' => 'Yes',
                        'Instock' => 'Yes',
                        'Facebook' => 0,
                        'IsKCup' => 1
                    ]
            ];
        $xmlArray = (new XmlParser())->xmlFileToArray($xmlFile);
        self::assertEquals($expectedArray, $xmlArray);
    }
}
