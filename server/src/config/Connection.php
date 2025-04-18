<?php

namespace App\config;

use PDO;

use PDOException;

class Connection {

    private static array $envs;
    private static ?PDO $pdo = null;

    private static function loadEnv(): void{
        if (empty(self::$envs)) {
            self::$envs = require __DIR__ . "/envs.php";
        }
    }

    private static function createConnection(): void{
        if(self::$pdo === null){
            try {
                $dsn = "pgsql:host=" . self::$envs['DATABASE_HOST'] .
                        ";port=" . self::$envs['DATABASE_PORT'] .
                        ";dbname=" . self::$envs['DATABASE_NAME'] ;

                self::$pdo = new PDO(
                    $dsn,
                    self::$envs['DATABASE_USER'],
                    self::$envs['DATABASE_PASSWORD'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("❌ Error de conexión: " . $e->getMessage());
            }
        }
    }

    public static function exportConnection(): PDO{
        if (self::$pdo === null) {
            self::loadEnv();
            self::createConnection();
        }

        return self::$pdo;
    }
}