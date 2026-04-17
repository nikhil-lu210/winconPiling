<?php

declare(strict_types=1);

final class Database
{
    private static ?\PDO $instance = null;

    public static function getInstance(): \PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $relative = ltrim(str_replace(['\\', '..'], '/', DB_PATH), '/');
        $dbFile = ROOT_PATH . '/' . $relative;
        $dir = dirname($dbFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $dsn = 'sqlite:' . $dbFile;
        $pdo = new \PDO($dsn, null, null, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
        $pdo->exec('PRAGMA foreign_keys = ON;');
        $pdo->exec('PRAGMA journal_mode=WAL;');

        self::$instance = $pdo;
        return self::$instance;
    }
}
