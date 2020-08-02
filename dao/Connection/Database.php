<?php

class Database {

    protected $host;
    protected $user;
    protected $password;
    protected $databaseName;
    protected $myConnection = null;

    public function __construct($host, $user, $password, $databaseName) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->databaseName = $databaseName;
    }

    public function __destruct() {
        if ($this->myConnection != null) {
            $this->disconnectToDatabase();
        }
    }

    protected function connectToDatabase() {
        $this->myConnection = new mysqli($this->host, $this->user, $this->password, $this->databaseName);
        if ($this->myConnection->connect_error) {
            die("Connect Error (" . $this->myConnection->connect_errno . ") " . $this->myConnection->connect_error);
        }
    }

    protected function disconnectFromDatabase() {
        if ($this->myConnection != null) {
            $this->myConnection->close();
			$this->myConnection = null;
        }
    }

    protected function preventSqlInjection($parameterValue) {
        $result = $this->myConnection->real_escape_string($parameterValue);
        return $result;
    }

    public function executeSqlQuery($mySqlQuery, $parameterArray = null) {
        return $this->executeAdvancedSqlQuery($mySqlQuery, true, $parameterArray);
    }

    protected function executeAdvancedSqlQuery($mySqlQuery, $autoDisconnect = true, $parameterArray = null) {
        $this->connectToDatabase();
        if ($parameterArray != null) {
            //Verander alle vraagtekens in de query door parameterwaarden uit de parameterArray
            $queryParts = preg_split("/\?/", $mySqlQuery);
            if (count($queryParts) != count($parameterArray) + 1) {
                return false;
            }
            $finalQuery = $queryParts[0];
            for ($index = 0; $index < count($parameterArray); $index++) {
                $finalQuery = $finalQuery . $this->preventSqlInjection($parameterArray[$index]) . $queryParts[$index + 1];
            }
            $mySqlQuery = $finalQuery;
        }

        $result = $this->myConnection->query($mySqlQuery);
        if ($autoDisconnect) {
            $this->disconnectFromDatabase();
        }
        return $result;
    }

}

?>