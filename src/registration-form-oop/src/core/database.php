<?php
namespace Core;

use mysqli;

class Database {
    private static ?mysqli $connection = null;

    public static function connect(): mysqli {
        if (self::$connection === null) {
            self::$connection = new mysqli("localhost", "root", "", "registration");

            if (self::$connection->connect_error) {
                die("DB connection error: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }

    public static function query(string $sql) {
        return self::connect()->query($sql);
    }
}
