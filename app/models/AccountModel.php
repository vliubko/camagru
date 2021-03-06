<?php

class AccountModel extends Model {
    
    public $username;
    public $password;
    public $old_pwd;
    public $email;
    public $name;
    public $token;
    public $user_id;
    public $notification;

    public function checkSession() {
        if (!empty($_SESSION['username'])) {
            return true;
        }
        return false;
    }

    public function addNewUserToDB() {
        $fields = array("username","name","email","password","tokenValidated");
        $values = array(
            $this->username,$this->name,$this->email,$this->password,$this->token);
        $sql = "INSERT INTO user SET ".$this->db->pdoSet($fields,$values);
        $res = $this->db->run($sql);
        return ;
    }

    public function updateUserDb() {
        $user_id = $this->db->getUserId();

        $fields = array("username","email","notification");
        $values = array(
            $this->username,$this->email,$this->notification);
        $sql = "UPDATE user SET ".$this->db->pdoSet($fields,$values)." WHERE id = ".$user_id;

        $res = $this->db->run($sql);
    }

    public function deleteUserToken($user_id) {
    
        $fields = array("tokenValidated");
        $values = array(
            $this->token);
        $sql = "UPDATE user SET ".$this->db->pdoSet($fields,$values)." WHERE id = ".$user_id;

        $res = $this->db->run($sql);
    }

    public function updateUserData() {
        $errors[] = AccountModel::validateUpdatingEmail($_POST['email']);
        $errors[] = AccountModel::validateUpdatingUsername($_POST['user']);
        
        foreach ($errors as $e) {
            if (!empty($e))
            $message = $e;
        }
        if (!empty($message)) {
            return $message;
        }
        $this->username = $_POST['user'];
        $this->email = $_POST['email'];
        if (isset($_POST['notification'])) {
            $this->notification = 1;
        } else {
            $this->notification = 0;
        }
        
        $this->updateUserDb();
        $_SESSION['username'] = $this->username;
        $_SESSION['email'] = $this->email;
        $_SESSION['notification'] = $this->notification;
        return "Data changed succesfully.";
    }

    public function validateUserData() {
        $errors[] = AccountModel::validatePassword($this->password);
        $errors[] = AccountModel::validateEmail($this->email);
        $errors[] = AccountModel::validateUsername($this->username);
        $errors = array_filter($errors);

        foreach ($errors as $e) {
            if (!empty($e))
            $message = $e;
        }
        if (!empty($message)) {
            return $message;
        }
        return ;
    }

    public function tryChangePassword() {
        $user_id = $this->db->getUserId();
        $user_data = $this->db->getUserDataById($user_id);
        $old_pwd = hash('whirlpool', $_POST['oldPwd']);

        if ($old_pwd !== $user_data['password']) {
            $response['success'] = "false";
            $response['message'] = "Old password does not match";
            return $response;
        }

        if ($_POST['oldPwd'] == $_POST['newPwd']) {
            $response['success'] = "false";
            $response['message'] = "Password should not be as old password";
            return $response;
        }

        $message = $this->validatePassword($_POST['newPwd']);
        if ($message) {
            $response['success'] = "false";
            $response['message'] = $message;
            return $response;
        }

        $newPwd = hash('whirlpool', $_POST['newPwd']);
        $this->updateUserPassword($user_id, $newPwd);

        $response['success'] = "OK";
        $response['message'] = "Password changed successfully";
        return $response;
    }

    public function updateUserPassword($user_id, $newPwd) {
        $fields = array("password",);
        $values = array($newPwd);
        $sql = "UPDATE user SET ".$this->db->pdoSet($fields,$values)." WHERE id = ".$user_id;

        $res = $this->db->run($sql);
    }

    public function registerUser() {

        $this->username = $_POST['user'];
        $this->email = $_POST['email'];
        $this->name = $_POST['name'];
        $this->password = $_POST['password'];

        $message = $this->validateUserData();
        if (!empty($message)) {
            return $message;
        }
        $this->password = hash('whirlpool', $_POST['password']);
        $this->sendMailConfirmation();
        $this->addNewUserToDB();
        return "Succesful registration. <br>Email with activation link sent to ".$this->email;
    }

    public function resetPassword() {
        $user_id = $this->db->getUserIdByEmail($_POST['email']);
        $user_data = $this->db->getUserDataById($user_id);

        if (empty($user_id)) {
            return "Email not found.";
        } else {
            $password = $this->generateNewPassword();
            $this->setNewPassword($user_id, hash('whirlpool', $password));
            $this->sendMailNewPassword($user_data, $password);
        }
        return "Succesful reset password. <br>Email with new password sent to ".$_POST['email'];
    }

    public function sendMailNewPassword($user_data, $password) {
        $to = $user_data['email'];
        $subject = 'Password reset DevOps Camagru';
        $headers = array(
			'From' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'Reply-To' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/html; charset=UTF-8',
        );
        $src = "http://" . $_SERVER['SERVER_NAME'] . "/account/login";

        $first_row = $user_data['username'] . " , you have requested password reset. <br>";
        $second_row = "Your new password is: " . $password . "<br>" ;
        $thid_row = "Please, use it for login ";
        $fourth_row = "<a href=\"" . $src . "\"> >> here <<</a>";
    
        $message = $first_row . $second_row . $thid_row . $fourth_row;

        $error = mail($to, $subject, $message, $headers);
        if ($error != TRUE) {
            echo "Mail not send. Something went wrong.";
        }
    }

    public function setNewPassword($user_id, $password) {
        $fields = array("password");
        $values = array($password);
        $sql = "UPDATE `user` SET ".$this->db->pdoSet($fields,$values)."WHERE id = ?";
        $this->db->run($sql, [$user_id]);
        return ;
    }

    public function generateNewPassword() {
        $key = "";
        $alpha = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < 5; $i++) {
            $key .= $alpha[rand() % strlen($alpha)];
        }
        $newPassword = $key . substr(md5($_POST['email']), 0, 5);
        return $newPassword;
    }

    //TODO sendmail message.
    public function sendMailConfirmation() {
        $this->token = $this->tokenGenerate();
        $to = $this->email;
        $subject = 'Activation link Camagru';
        $headers = array(
			'From' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'Reply-To' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/html; charset=UTF-8',
        );
        $address = $_SERVER['SERVER_NAME']."/account/verify?token=";
        $message = "Congrats with registration! <br> Your username: " . $this->username . "<br><br>Please, follow this <a href=\"http://" . $address . $this->token . "\">link</a>"; 

        $error = mail($to, $subject, $message, $headers);
        if ($error != TRUE) {
            echo "Mail not send. Something went wrong.";
        }
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

    public function verifyToken() {
        $user_data = $this->db->findToken();
        if (!empty($user_data)) {
            $fields = array("validated");
            $values = array(
                1);
            $sql = "UPDATE user SET ".$this->db->pdoSet($fields,$values)." WHERE id = ".$user_data['id'];
            $res = $this->db->run($sql);
            $this->token = NULL;
            $this->deleteUserToken($user_data['id']);
            return $user_data['name'] .", you have verified your email " . $user_data['email'] . " succesfully!<br>
            Wait 5 seconds for redirection";
        }
        return ;
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

    public function checkUserValidated($user_data) {
        if (!$user_data['validated']) {
            return false;
        }
        return true;
    }

    public function checkUserLogin() {
        $username = $_POST['login'];
		$password = hash('whirlpool', $_POST['password']);
		$name = "default";
        
        if (!$this->checkUserExist($username)) {
            return "Wrong login or password";
        }
        $sql = "SELECT name FROM user WHERE username = ? AND password = ?";
        $res = $this->db->run($sql, [$username, $password])->fetchColumn();
    
		if(!empty($res)) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $res;

            $user_data = $this->getUserData();
            if (!$this->checkUserValidated($user_data)) {
                session_destroy();
                return "Your account still not activated.";
            }

            $_SESSION['email'] = $user_data['email'];
            $_SESSION['notification'] = $user_data['notification'];
			header("Location: /");
		} else {
			return "Wrong login or password";
		}
    }

    public function getUserData() {
        $sql = "SELECT * FROM user WHERE username = ?";
        $user_data = $this->db->run($sql, [$_SESSION['username']])->fetch();
        
        $this->$username = $user_data['username'];
        $this->$email = $user_data['email'];
        $this->$name = $user_data['name'];
        $this->$user_id = $user_data['id'];
        $this->old_pwd = $user_data['password'];
        $this->notification = $user_data['notification'];

        return $user_data;
    }
    
    public function checkEmailRegistered($email) {
        $sql = "SELECT email FROM user WHERE email = ?";
        $email = $this->db->run($sql, [$email])->fetch();
        if (!empty($email)) {
            return true;
        }
        return false;
    }

    public function validatePassword($password) {
        if (strlen($password) < 6) {
            return "Password too short (at least 6 symbols)";
        }
        if (!preg_match('/^(?=.*\d)([0-9a-zA-Z@!]+)$/', $password)) {
            return "Password should contain at least one digit";
        }
        return;
    }

    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email ". $email;
        } else if ($this->checkEmailRegistered($email)) {
            return "Email " . $email . " already taken";
        }
        return;
    }

    public function validateUsername($username) {
        if (!preg_match('/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/', $username)) {
            return "Forbidden symbols in login";
        }
        if ($this->checkUserExist($username)) {
            return "Username " . $username . " already taken";
        }
        return;
    }

    public function validateUpdatingUsername($username) {
        $user_data = $this->getUserData();
        if (!preg_match('/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/', $username)) {
            return "Forbidden symbols in login";
        }
        if ($this->checkUserExist($username) && $username != $user_data['username']) {
            return "Username " . $username . " already taken";
        }
        return;
    }

    public function validateUpdatingEmail($email) {
        $user_data = $this->getUserData();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email ". $email;
        } else if ($this->checkEmailRegistered($email) && $email != $user_data['email']) {
            return "Email " . $email . " already taken";
        }
        return;
    }

}

?>