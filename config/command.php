<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

$commandRegistry['commands'] = [
    Wajdisawa\spreadsheet\Application\Command\XmlToSheetConverter::class,
];
return $commandRegistry;
