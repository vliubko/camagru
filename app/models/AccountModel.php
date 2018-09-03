<?php

class AccountModel extends Model {

    public function checkSession() {
        if (!empty($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    public function checkUserExist() {
        $username = $_POST['login'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM user WHERE username = :username AND password = :password";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
		$stmt->execute();

		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($res)) {
            $_SESSION['user'] = $username;
            $_SESSION['name'] = $res['name'];
			header("Location: /account/settings");
		} else {
			return false;
		}
    }

    public function validatePassword() {
        return false;
    }

    public function validateEmail() {
        return false;
    }

    public function validateUsername() {
        return false;
    }
}

?>