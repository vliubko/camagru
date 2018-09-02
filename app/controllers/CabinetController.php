<?php

class CabinetController extends Controller {

    private $pageTpl = "/views/cabinet/cabinet.tpl.php";

    public function __construct() {
        $this->model = new CabinetModel();
        $this->view = new View();
    }

    public function index() {
        $this->pageData['title'] = "Cabinet";

        $photosCount = $this->model->getPhotosCount();
        $this->pageData['photosCount'] = $photosCount;

        $usersCount = $this->model->getUsersCount();
        $this->pageData['usersCount'] = $usersCount;

        $this->view->render($this->pageTpl, $this->pageData);
    }

}

?>