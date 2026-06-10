<?php


namespace Gfiedler\GerenciaContatos\Config;
use PDO;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance == null) {
            self::$instance = new PDO(
                dsn: "pgsql:host=" . $_ENV['DB_HOST'] .
                ";port=" . $_ENV['DB_PORT'] .
                ";dbname=" . $_ENV['DB_NAME'],
                username: $_ENV['DB_USER'],
                password: $_ENV['DB_PASS'],
                options: [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_STRINGIFY_FETCHES => false,
                    PDO::ATTR_EMULATE_PREPARES => false
                ],
            );
        }
        return self::$instance;
    }
}