<?php

require_once MODEL_PATH. 'AccountModel.php';

class PhotoController extends Controller {

    private $pageTpl = '/views/account/photo.tpl.php';

	public function __construct() {
		$this->model = new AccountModel();
        $this->view = new View();
	}

    public function index() {
		if (!AccountModel::checkSession()) {
            header ("Location: /account/login");
        }
        else {
            $this->add();
        }
    }
    
    public function add() {
        if (!AccountModel::checkSession()) {
            header ("Location: /account/login");
        }
        else {
        $this->pageData['title'] = "Add photo";

        $this->view->render($this->pageTpl, $this->pageData);
        }
    }
    
}