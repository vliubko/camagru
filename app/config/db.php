<?php

Class DB {

    public static function connToDB() {
        $host = $_SERVER['MYSQL_HOST'];
        $dbname = $_SERVER['MYSQL_DATABASE'];
        
        $dsn = 'mysql:dbname='.$dbname.';host='.$host;
        $user = $_SERVER['MYSQL_ROOT_USER'];
        $pass = $_SERVER['MYSQL_ROOT_PASSWORD'];
        
        try {
            $connection = new PDO($dsn, $user, $pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
        return $connection;
    }
}