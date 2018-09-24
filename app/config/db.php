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

    function pdoSetNoQuotes($fields, $values) {
        $set = '';
        $allFields = array_combine($fields, $values);
        foreach ($allFields as $key => $value) {
            $set.="`".str_replace("`","``",$key)."`". "=$value, ";
        }
        return substr($set, 0, -2);
    }

    function pdoDelete($table_name, $id) {
        $sql = "DELETE FROM " . "`" . $table_name . "`" . " WHERE `id` = ?";
        $status = MyPDO::run($sql, [$id])->fetch();
        return $status;
    }

    public function getUserId() {
        $sql = "SELECT id FROM user WHERE username = ?";
        $user_id = MyPDO::run($sql, [$_SESSION['username']])->fetchColumn();
        return $user_id;
    }

    public function getUserIdByPhotoId($photo_id) {
        $sql = "SELECT user FROM photo WHERE id = ?";
        $user_id = MyPDO::run($sql, [$photo_id])->fetchColumn();
        return $user_id;
    }

    public function getUserDataById($user_id) {
        $sql = "SELECT * FROM user WHERE id = ?";
        $user_data = MyPDO::run($sql, [$user_id])->fetch();
        return $user_data;
    }

    public function getUserIdByCommentId($comment_id) {
        $sql = "SELECT user FROM comment WHERE id = ?";
        $user_id = MyPDO::run($sql, [$comment_id])->fetchColumn();
        return $user_id;
    }

    public function getUserIdByEmail($email) {
        $sql = "SELECT id FROM user WHERE email = ?";
        $user_id = MyPDO::run($sql, [$email])->fetchColumn();
        return $user_id;
    }

    public function findToken() {
        $sql = "SELECT * FROM user WHERE tokenValidated = ?";
        $user_data = MyPDO::run($sql, [$_GET['token']])->fetch();
        return $user_data;
    }

    public function getAllPhotos() {
        $sql = "SELECT COUNT(like.id) as likes, photo.id, photo.url, user.username, user.id as user_id, photo.createdAt
                FROM camagru.photo 
                LEFT JOIN camagru.like ON photo.id = like.photo
                INNER JOIN camagru.user ON photo.user = user.id
                GROUP BY photo.id, photo.url, user.username, user.id, photo.createdAt";
        $photos = MyPDO::run($sql)->fetchAll();
        return $photos;
    }

    public function getPhoto($photo_id) {
        $sql = "SELECT COUNT(like.id) as likes, photo.id, photo.url, user.username, user.id as user_id, photo.createdAt 
                FROM `photo`
                LEFT JOIN `like` ON photo.id = like.photo 
                INNER JOIN `user` ON photo.user = user.id
                WHERE photo.id = ?
                GROUP BY photo.id, photo.url, user.username, user.id, photo.createdAt";
        $photo = MyPDO::run($sql, [$photo_id])->fetch();
        return $photo;
    }

    public function checkLikeStatus($user_id, $photo_id) {
        $sql = "SELECT id FROM camagru.like WHERE user = ? AND photo = ?";
        $status = MyPDO::run($sql, [$user_id, $photo_id])->fetchColumn();
        return $status;
    }

    public function getComments($photo_id) {
        $sql = "SELECT comment.id, user.username, comment.message, comment.createdAt 
        FROM camagru.comment
        LEFT JOIN user on comment.user = user.id
        WHERE comment.photo = ?";
        $comments = MyPDO::run($sql, [$photo_id])->fetchAll();
        return $comments;
    }

    // public function countLikes($photo_id) {
    //     $sql = "SELECT COUNT(*) FROM camagru.like WHERE photo = ?";
    //     $likes = MyPDO::run($sql, [$photo_id])->fetchColumn();
    //     return $likes;
    // }
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