<?php

class AccountModel extends Model {
    
    public $username;
    public $password;
    public $email;
    public $name;
    public $token;
    public $user_id;

    public function checkSession() {
        if (!empty($_SESSION['username'])) {
            return true;
        }
        return false;
    }

    public function registerUser() {

        $this->username = $_POST['user'];
        $this->email = $_POST['email'];
        $this->name = $_POST['name'];
        $this->password = hash('whirlpool', $_POST['password']);

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
        $this->addNewUserToDB();
        $this->sendMailConfirmation();
        return "Succesful registration.";
    }

    public function addNewUserToDB() {
        $fields = array("username","name","email","password");
        $values = array(
            $this->username,$this->name,$this->email,$this->password);
        $sql = "INSERT INTO user SET ".$this->db->pdoSet($fields,$values);
        $res = $this->db->run($sql);
        return ;
    }

    public function updateUserSettings() {
        $fields = array("username","name","email","password");
        $values = array(
            $this->username,$this->name,$this->email,$this->password);

        $user_id = $this->getUserId();
        $sql = "UPDATE user SET ".$this->db->pdoSet($fields,$values)." WHERE id = ". $user_id;
        $res = $this->db->run($sql);
        return ;
    }

    //TODO sendmail message.
    public function sendMailConfirmation() {

        $this->token = $this->tokenGenerate();
        $to = $this->email;
        $subject = 'Activation link';
        $headers = array(
			'From' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'Reply-To' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/html; charset=UTF-8',
		);
        $message = "Cool registration. Your token is: " . $this->token;

        $error = mail($to, $subject, $message, $headers);
        if ($error != TRUE) {
            echo "Mail not send. Something went wrong.";
        }
        //var_dump ($error);
    }

    public function tokenGenerate() {
        $key = "";
        $alpha = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < 50; $i++) {
            $key .= $alpha[rand() % strlen($alpha)];
        }
        return $key . md5($this->email);
    }

    public function checkUserExist($username) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $res = $this->db->run($sql, [$username])->fetchColumn();

        if (!$res) {
            return false;
        } else {
            return true;
        }
    }

    public function checkUserLogin() {
        $username = $_POST['login'];
		$password = hash('whirlpool', $_POST['password']);
		$name = "default";
        
        if (!$this->checkUserExist($username)) {
            return false;
        }
        $sql = "SELECT name FROM user WHERE username = ? AND password = ?";
        $res = $this->db->run($sql, [$username, $password])->fetchColumn();
    
		if(!empty($res)) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $res;
			header("Location: /account/settings");
		} else {
			return false;
		}
    }

    public function getUserId() {
        $sql = "SELECT id FROM user WHERE username = ?";
        $id = $this->db->run($sql, [$_SESSION['username']])->fetchColumn();
        return $id;
    }

    public function validatePassword() {
        if (strlen($this->password) < 6) {
            return "Password too short (at least 6 symbols)";
        }
        if (!preg_match('/^(?=.*\d)([0-9a-zA-Z@!]+)$/', $this->password)) {
            return "Password should contain at least one digit";
        }
        return;
    }

    public function validateEmail() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email ". $this->email;
        }
        return;
    }

    public function validateUsername() {
        if (!preg_match('/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/', $this->username)) {
            return "Forbidden symbols in login";
        }
        if ($this->checkUserExist($this->username)) {
            return "Username already taken";
        }
        return;
    }
}

?>