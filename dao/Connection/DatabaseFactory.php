<?php
include_once 'DAO/Connection/Database.php';

class DatabaseFactory {

    //Singleton
    private static $verbinding;

    public static function getDatabase() {

        if (self::$verbinding == null) {
            $host = "localhost:3306";
            $username = "root";
            $password = "wachtwoord";
            $databaseName = "towerlands_v00";
            self::$verbinding = new Database($host, $username, $password, $databaseName);
        }
        return self::$verbinding;
    }

}
?>

