<?php

class MyPDO extends PDO {
    public function run($sql, $args = NULL) {
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}

Class DB {

    public static function connToDB() {
        $host = $_SERVER['MYSQL_HOST'];
        $dbname = $_SERVER['MYSQL_DATABASE'];
        
        $dsn = 'mysql:dbname='.$dbname.';host='.$host;
        $user = $_SERVER['MYSQL_ROOT_USER'];
        $pass = $_SERVER['MYSQL_ROOT_PASSWORD'];

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $connection = new MyPDO($dsn, $user, $pass, $opt);
        }
        catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
        return $connection;
    }
}