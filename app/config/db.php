<?php

class MyPDO extends PDO {
    public function run($sql, $args = NULL) {
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    function pdoSet($fields, $values) {
        $set = '';
        $allFields = array_combine($fields, $values);
        foreach ($allFields as $key => $value) {
            $set.="`".str_replace("`","``",$key)."`". "=\"$value\", ";
        }
        return substr($set, 0, -2); 
    }

    public function getUserId() {
        $sql = "SELECT id FROM user WHERE username = ?";
        $user_id = MyPDO::run($sql, [$_SESSION['username']])->fetchColumn();
        return $user_id;
    }

    public function getUserEmail() {
        $sql = "SELECT id FROM user WHERE email = ?";
        $email = MyPDO::run($sql, [$_POST['email']])->fetchColumn();
        return $email;
    }

    public function findToken() {
        $sql = "SELECT * FROM user WHERE tokenValidated = ?";
        $user_data = MyPDO::run($sql, [$_GET['token']])->fetch();
        return $user_data;
    }

    public function getAllPhotos() {
        $sql = "SELECT * FROM photo";
        $photos = MyPDO::run($sql)->fetchAll();
        return $photos;
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
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
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