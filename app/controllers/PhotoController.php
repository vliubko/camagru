<?php

require_once MODEL_PATH. 'AccountModel.php';

class PhotoController extends Controller {

    private $pageTpl = '/views/account/add_photo.tpl.php';

	public function __construct() {
		$this->model = new PhotoModel();
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
    
    public function showPhoto($id) {
        $this->pageData['title'] = "Camagru";
        $this->pageTpl = '/views/account/show_photo.tpl.php';
        $this->pageData['photo'] = $this->model->showPhoto($id);
        
        
        if (empty($this->pageData['photo'])) {
            header("Location: /public/404.html");
            return ;
        }
		$this->view->render($this->pageTpl, $this->pageData);
    }
}