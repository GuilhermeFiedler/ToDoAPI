<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

\Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$appDebug = (bool) ($_ENV['APP_DEBUG' ?? false]);