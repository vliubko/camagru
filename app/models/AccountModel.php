<?php

class AccountModel extends Model {
    
    public $user;
    public $password;
    public $email;

    public function checkSession() {
        if (!empty($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    public function registerUser() {

        $this->$user = $_POST['user'];
        $this->$email = $_POST['email'];
        $this->$password = $_POST['password'];

        $errors[] = AccountModel::validatePassword();
        $errors[] = AccountModel::validateEmail();
        $errors[] = AccountModel::validateUsername();
        $errors = array_filter($errors);
        
        foreach ($errors as $e) {
            if (!empty($e))
            $message = $e;
        }
        if (!empty($message)) {
            return $message;
        }
        return "Succesful registration.";
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
        if (strlen($this->$password) < 6) {
            return "Password too short (at least 6 symbols)";
        }
        if (!preg_match('/^(?=.*\d)([0-9a-zA-Z@!]+)$/', $this->password)) {
            return "Password should contain at least one digit";
        }
        return;
    }

    // TODO check email already registered
    public function validateEmail() {
        if (!filter_var($this->$email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email ". $this->$email;
        }
        return;
    }

     // TODO check username already taken
    public function validateUsername() {
        if (!preg_match('/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/', $this->$password)) {
            return "Forbidden symbols in login";
        }
        return;
    }
}

?>