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

    public function sendmail() {
        $error = mail("neznam.ua@gmail.com", "Activation link", "Hi there! Camagru is waiting.", "From: Camagru");

        var_dump ($error);
    }

    public function register() {
        if(!$this->model->checkSession()) {
            $this->pageTpl = '/views/account/register.tpl.php';
            $this->pageData['title'] = "Register";

            if(!empty($_POST)) {
                if (!$this->model->validatePassword()) {
                    $this->pageData['error'] = "Password should contain min 8 chars. Also should be at least 1 capital letter and 1 number";
                }
                if (!$this->model->validateEmail()) {
                    $this->pageData['error'] = "Please, enter correct email";
                }
                if (!$this->model->validateUsername()) {
                    $this->pageData['error'] = "Current username is already been taken";
                }
            }
            $this->view->render($this->pageTpl, $this->pageData);
        }
        else {
            header ("Location: /account/settings");
        }
    }

    public function logout() {
        session_destroy();
        header ("Location: /");
    }
}