<?php

class IndexController extends Controller {

    private $pageTpl = '/views/main.tpl.php';


	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
	}

    public function index() {
		$this->pageData['title'] = "Camagru";

		if(!empty($_POST)) {
			if(!$this->login()) {
				$this->pageData['error'] = "Wrong login or password";
			}
		}

		$this->view->render($this->pageTpl, $this->pageData);
	}

	public function login() {
		if(!$this->model->checkUser()) {
			return false;
		}
	}
}