<?php

class LoginModel extends Model {

    public function checkUser() {
        $login = $_POST['login'];
		$password = md5($_POST['password']);
		$name = "default";

		$sql = "SELECT * FROM users WHERE login = :login AND password = :password";

		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":login", $login, PDO::PARAM_STR);
		$stmt->bindValue(":password", $password, PDO::PARAM_STR);
		$stmt->bindValue(":name", $name, PDO::PARAM_STR);
		$stmt->execute();

		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($res)) {
			$_SESSION['user'] = $login;
			$_SESSION['name'] = $name;
			header("Location: /cabinet");
		} else {
			return false;
		}

    }
}