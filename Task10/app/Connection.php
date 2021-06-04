<?php declare(strict_types=1);

class Connection
{
    public static function sqlite3(string $fileName): PDO
    {
        $connectionString = 'sqlite:' . realpath($fileName);

        return new PDO($connectionString);
    }

    public static function setupSqlite3RedBean(string $fileName): void
    {
        $connectionString = 'sqlite:' . realpath($fileName);

        R::setup($connectionString);
    }
}
