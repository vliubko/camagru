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
                $message = $this->model->checkUserLogin();
                $this->pageData['error'] = $message;
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
            $this->pageData['user_data'] = $this->model->getUserData();
            $this->pageTpl = '/views/account/settings.tpl.php';
            $this->pageData['title'] = "Settings";
            
            if(!empty($_POST)) {
                $message = $this->model->updateUserData();
                $this->pageData['error'] = $message;
            }
            $this->view->render($this->pageTpl, $this->pageData);
        }
    }

    public function changePassword() {
        if (!isset($_SESSION['username'])) {
            return;
        }

        if(!$_POST['oldPwd'] || !$_POST['newPwd']) {
            header("Location: /public/404.html");
            return;
        }

        $response = $this->model->tryChangePassword();

        header('Content-type: application/json');
        echo json_encode($response);
    }
    
    public function recovery() {
        if($this->model->checkSession()) {
            header ("Location: /account/login");
        }
        else {
            $this->pageTpl = '/views/account/recovery.tpl.php';
            $this->pageData['title'] = "Password Recovery";

            if(!empty($_POST)) {
                $message = $this->model->resetPassword();
                $this->pageData['error'] = $message;
            }

            $this->view->render($this->pageTpl, $this->pageData);
        }
    }

    public function register() {
        if(!$this->model->checkSession()) {
            $this->pageTpl = '/views/account/register.tpl.php';
            $this->pageData['title'] = "Register";

            if(!empty($_POST)) {
                $message = $this->model->registerUser();
                $this->pageData['error'] = $message;
            }
            $this->view->render($this->pageTpl, $this->pageData);
        }
        else {
            header ("Location: /account/settings");
        }
    }

    public function verify() {
        if($this->model->checkSession()) {
            header ("Location: /account/login");
        }
        else {
            $this->pageData['title'] = "Verify account";
            $this->pageTpl = '/views/account/success_register.tpl.php';
            
            $message = $this->model->verifyToken();
            if (empty($message)) {
                header ("Location: /");
            } else {
                $this->pageData['message'] = $message;
                
                $this->view->render($this->pageTpl, $this->pageData);
            }
        }
    }

    public function logout() {
        session_destroy();
        header ("Location: /");
    }
}