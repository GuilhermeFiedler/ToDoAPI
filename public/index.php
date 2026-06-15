<?php
declare(strict_types=1);
use Dotenv\Dotenv;
require __DIR__ . '/../vendor/autoload.php';
Dotenv::createImmutable(__DIR__ . '/../')->load();
require __DIR__ . '/../src/config/app.php';