<?php
require_once './model/Player.php';
require_once './dao/Connection/DatabaseFactory.php';
require_once './dao/Connection/Database.php';

class PlayerDAO {
    private static function getConnection() {
        return DatabaseFactory::getDatabase();
    }

    public static function getPlayers() {
        $result = self::getConnection()->executeSqlQuery("SELECT * FROM player");
        $resultArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRow = $result->fetch_array();
            $object = self::convertRowToObject($databaseRow);
            $resultArray[$index] = $object;
        }
        return $resultArray;
    }

    public static function getPlayerById($id) {
        $result = self::getConnection()->executeSqlQuery(
            "SELECT * FROM player WHERE id=?",
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
    public static function getPlayersByClanId($clanId) {
        $result = self::getConnection()->executeSqlQuery(
            "SELECT * FROM player WHERE clanId=?",
            array($clanId));
        $resultArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRow = $result->fetch_array();
            $object = self::convertRowToObject($databaseRow);
            $resultArray[$index] = $object;
        }
        return $resultArray;
    }

    public static function insert($player) {
        return self::getConnection()->executeSqlQuery(
            "INSERT INTO Player(name, towerLevel, clanId, clanJoinDate, clanJoinTowerLevel, categoryId, score, 'rank') VALUES ('?','?','?','?','?','?','?','?')",
            array($player->getName(), $player->getTowerLevel(), $player->getClanId(), $player->getClanJoinDate(), $player->getClanJoinTowerLevel(), $player->getCategoryId(), $player->getScore(), $player->getRank())
        );
    }

    public static function deleteById($id) {
        return self::getConnection()->executeSqlQuery(
            "DELETE FROM player where id=?",
            array($id)
        );
    }

    public static function delete($player) {
        return self::deleteById($player->getId());
    }

    public static function update($player) {
        return self::getConnection()->executeSqlQuery(
            "UPDATE Player SET name='?', towerLevel='?', clanId='?', clanJoinDate='?', clanJoinTowerLevel='?', categoryId='?', score='?', 'rank'='?' WHERE id=?",
            array($player->getName(), $player->getTowerLevel(), $player->getClanId(), $player->getClanJoinDate(), $player->getClanJoinTowerLevel(), $player->getCategoryId(), $player->getScore(), $player->getRank(), $player->getId())
        );
    }

    protected static function convertRowToObject($databaseRow) {
        return new Player($databaseRow['id'], $databaseRow['name'], $databaseRow['towerLevel'], $databaseRow['clanId'], $databaseRow['clanJoinDate'], $databaseRow['clanJoinTowerLevel'], $databaseRow['categoryId'], $databaseRow['score'], $databaseRow['rank']);
    }

}
