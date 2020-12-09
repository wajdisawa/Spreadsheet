<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */
declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Tests\Application\Command;

use PHPUnit\Framework\MockObject\MockObject;
use Slim\Logger;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Wajdisawa\spreadsheet\Application\Command\XmlToSheetConverter;
use PHPUnit\Framework\TestCase;
use Wajdisawa\spreadsheet\Domain\Xml\XmlParser;
use Wajdisawa\spreadsheet\Infrastructure\SheetCreator;

final class XmlToSheetConverterTest extends TestCase
{
    /**
     * @var SheetCreator|MockObject
     */
    private SheetCreator $sheetCreator;

    /**
     * @var XmlParser|MockObject
     */
    private XmlParser $xmlParser;

    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @var CommandTester
     */
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        parent::setUp();
        $this->xmlParser = $this->getMockBuilder(XmlParser::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->sheetCreator = $this->getMockBuilder(SheetCreator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->logger = $this->getMockBuilder(Logger::class)
            ->setMethodsExcept(array('debug', 'info'))
            ->getMock();
        $application = new Application();
        $application->add(new XmlToSheetConverter(
                $this->sheetCreator,
                $this->xmlParser,
                $this->logger
            )
        );

        $command = $application->find('spreadsheet:xml_to_sheet');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteWithSheetTitleEmpty(): void
    {
        $this->xmlParser->expects(self::never())
            ->method('xmlFileToArray');
        $this->sheetCreator->expects(self::never())
            ->method('create');
        $this->commandTester->execute(
            [
                XmlToSheetConverter::SHEET_TITLE => '',
                XmlToSheetConverter::FILE => 'file_test_path'
            ]
        );
    }

    public function testExecuteWithFileEmpty(): void
    {
        $this->xmlParser->expects(self::never())
            ->method('xmlFileToArray');
        $this->sheetCreator->expects(self::never())
            ->method('create');
        $this->commandTester->execute(
            [
                XmlToSheetConverter::SHEET_TITLE => 'title',
                XmlToSheetConverter::FILE => ''
            ]
        );
    }

    public function testExecute(): void
    {
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
        $this->xmlParser->expects(self::once())
            ->method('xmlFileToArray')
            ->with('tests/data/coffee_feed.xml')
            ->willReturn($expectedArray);
        $this->sheetCreator->expects(self::once())
            ->method('create')
            ->with($expectedArray)
            ->willReturn(true);
        $this->commandTester->execute(
            [
                XmlToSheetConverter::SHEET_TITLE => 'title',
                XmlToSheetConverter::FILE => 'tests/data/coffee_feed.xml'
            ]
        );
    }
}
