<?php
require_once './model/Category.php';
require_once './dao/Connection/DatabaseFactory.php';

class CategoryDAO {
    private static function getConnection() {
        return DatabaseFactory::getDatabase();
    }

    public static function getCategories() {
        $result = self::getConnection()->executeSqlQuery("SELECT * FROM Category");
        $resultArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRow = $result->fetch_array();
            $object = self::convertRowToObject($databaseRow);
            $resultArray[$index] = $object;
        }
        return $resultArray;
    }

    public static function getCategoryById($id) {
        $result = self::getConnection()->executeSqlQuery(
            "SELECT * FROM Category WHERE id=?",
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

    public static function insert($category) {
        return self::getConnection()->executeSqlQuery(
            "INSERT INTO Category(name) VALUES ('?')",
            array($category->getName())
        );
    }

    public static function deleteById($id) {
        return self::getConnection()->executeSqlQuery(
            "DELETE FROM Category where id=?",
            array($id)
        );
    }

    public static function delete($category) {
        return self::deleteById($category->getId());
    }

    public static function update($category) {
        return self::getConnection()->executeSqlQuery(
            "UPDATE Category SET name='?' WHERE id=?",
            array($category->getName(), $category->getId())
        );
    }

    protected static function convertRowToObject($databaseRow) {
        return new Category($databaseRow['id'], $databaseRow['name']);
    }

}
