<?php

class AccountController extends Controller {

    private $pageTpl = '/views/account/login.tpl.php';

	public function __construct() {
		$this->model = new AccountModel();
        $this->view = new View();
	}

    public function index() {
		if(!$this->model->checkSession()) {
            $this->login();
        }
        else {
            $this->settings();
        }
	}

	public function login() {
        if(!$this->model->checkSession()) {
            $this->pageData['title'] = "Camagru Login";

            if(!empty($_POST)) {
                if (!$this->model->checkUserExist()) {
                    $this->pageData['error'] = "Wrong login or password";
                }
            }

            $this->view->render($this->pageTpl, $this->pageData);
        }
        else {
            $this->settings();
        }
    }

    public function settings() {

        if(!$this->model->checkSession()) {
            header ("Location: /account/login");
        }
        else {
            $this->pageTpl = '/views/account/settings.tpl.php';
            $this->pageData['title'] = "Settings";

            $this->view->render($this->pageTpl, $this->pageData);
        }
    }
    
    public function recovery() {
        if(!$this->model->checkSession()) {
            header ("Location: /account/login");
        }
        else {
            $this->pageTpl = '/views/account/recovery.tpl.php';
            $this->pageData['title'] = "Password Recovery";

            $this->view->render($this->pageTpl, $this->pageData);
        }
    }

    public function register() {
        if(!$this->model->checkSession()) {
            $this->pageTpl = '/views/account/register.tpl.php';
            $this->pageData['title'] = "Register";

            $this->view->render($this->pageTpl, $this->pageData);
        }
        else {
            header ("Location: /account/settings");
        }
    }

    public function sendmail() {
        //For sending mail
        $email = "neznam.ua@gmail.com";
        $encoding = "utf-8";
        $mail_subject = "Verification";
        $from_name = "Camagru";
        // Set preferences for Subject field
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
        // Set mail header
        $header = "Content-type: text/html; charset=" . $encoding . " \r\n";
        $header .= "From: " . $from_name . " <" . $from_mail . "> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: " . date("r (T)") . " \r\n";
        $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);
        $mail_message = ' <!doctype html> <html>
        <p>Hi,</p>
        <p>Thanks for register.</p>
        <p>Best regards! Camagru team.</p>
        </html>';
        // Send mail
        mail($email, $mail_subject, $mail_message, $header);
        header("Location: /account/login");
    }

    public function logout() {
        session_destroy();
        header ("Location: /");
    }
}