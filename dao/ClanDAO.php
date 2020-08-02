<?php
require_once './model/Clan.php';
require_once './dao/Connection/DatabaseFactory.php';

class ClanDAO {
    private static function getConnection() {
        return DatabaseFactory::getDatabase();
    }

    public static function getClans() {
        $result = self::getConnection()->executeSqlQuery("SELECT * FROM Clan");
        $resultArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRow = $result->fetch_array();
            $object = self::convertRowToObject($databaseRow);
            $resultArray[$index] = $object;
        }
        return $resultArray;
    }

    public static function getClanById($id) {
        $result = self::getConnection()->executeSqlQuery(
            "SELECT * FROM Clan WHERE id=?",
            array($id)
        );
        if ($result->num_rows == 1) {
            $databaseRow = $result->fetch_array();
            return self::convertRowToObject($databaseRow);
        } else {
            //Error handling
            return false;
        }
    }

    public static function insert($clan) {
        return self::getConnection()->executeSqlQuery(
            "INSERT INTO Clan(name) VALUES ('?')",
            array($clan->getName())
        );
    }

    public static function deleteById($id) {
        return self::getConnection()->executeSqlQuery(
            "DELETE FROM Clan where id=?",
            array($id)
        );
    }

    public static function delete($clan) {
        return self::deleteById($clan->getId());
    }

    public static function update($clan) {
        return self::getConnection()->executeSqlQuery(
            "UPDATE Clan SET name='?' WHERE id=?",
            array($clan->getName(), $clan->getId())
        );
    }

    protected static function convertRowToObject($databaseRow) {
        return new Clan($databaseRow['id'], $databaseRow['name']);
    }

}
