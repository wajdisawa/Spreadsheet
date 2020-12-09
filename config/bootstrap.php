<?php
/*
 * Wajdi AlSawafta <wajdee.sawaf@gmail.com>
 * THIS FILE IS PART OF A PRIVATE PROJECT spreadsheet
 * @copyright MIT 2020
 */

use Slim\App;

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions(__DIR__ . '/container.php');
$container = $containerBuilder->build();
$app = $container->get(App::class);
require __DIR__ . '/Config.php';
$config = new Config();
$app->addErrorMiddleware(
    $config->getEnv('PHP_DISPLAY_ERRORS', false),
    $config->getEnv('PHP_LOG_ERROR', true),
    $config->getEnv('PHP_LOG_ERROR_DETAILS', true)
);
ini_set("memory_limit", "1G");
return $app;
