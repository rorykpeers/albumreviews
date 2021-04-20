<?php

use App\DataProvider\DatabaseProvider;

require_once '../vendor/autoload.php';

$whoops = new \Whoops\Run();
$whoops->pushHandler(
    new \Whoops\Handler\PrettyPageHandler()
);

$whoops->register();

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$logger = new \Monolog\Logger('application');
$logger->pushHandler(
    new \Monolog\Handler\StreamHandler(
        'application.log',
        \Monolog\Logger::WARNING
    )
);

$dbProvider = new DatabaseProvider();

session_start();

if (isset($_SESSION['loginId'])) {
    $loggedInUser = $dbProvider->getUser($_SESSION['loginId']);
}

