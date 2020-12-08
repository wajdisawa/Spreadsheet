<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

declare(strict_types=1);

namespace Wajdisawa\spreadsheet\Application\Command;

use Slim\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wajdisawa\spreadsheet\Domain\Xml\XmlParser;
use Wajdisawa\spreadsheet\Domain\Xml\XmlParserInterface;
use Wajdisawa\spreadsheet\Infrastructure\SheetCreator;

final class XmlToSheetConverter extends Command
{
    private const FILE = 'xml_file';
    private const  SHEET_TITLE = 'sheet_title';

    /**
     * @var SheetCreator
     */
    private SheetCreator $sheetCreator;

    /**
     * @var XmlParserInterface
     */
    private XmlParserInterface $xmlParser;

    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * XmlConvert constructor.
     * @param SheetCreator $sheetCreator
     * @param XmlParser $xmlParser
     * @param Logger $logger
     */
    public function __construct(SheetCreator $sheetCreator, XmlParser $xmlParser, logger $logger)
    {
        parent::__construct();
        $this->sheetCreator = $sheetCreator;
        $this->xmlParser = $xmlParser;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function configure(): void
    {
        $this
            ->setName('spreadsheet:xml_to_sheet')
            ->setDescription('This command imports data from xml file to Google sheet.')
            ->addArgument(
                self::SHEET_TITLE,
                InputArgument::REQUIRED,
                'The name of the spread sheet')
            ->addArgument(
                self::FILE,
                InputArgument::REQUIRED,
                'The path to the xml file');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Google\Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument(self::FILE);
        if (false === file_exists($file)) {
            $this->logger->error('file not found');
            return 1;
        }
        $dataArray = $this->xmlParser->xmlFileToArray($file);
        return (int)$this->sheetCreator->create($dataArray, $input->getArgument(self::SHEET_TITLE));
    }
}
