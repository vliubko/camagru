<?php

class LikeController extends Controller {

    private $pageTpl = "/views/cabinet/cabinet.tpl.php";

    public function __construct() {
        $this->model = new LikeModel();
        $this->view = new View();
    }

    public function index() {

        if(!$_POST['like-id']) {
            header("Location: /public/404.html");
            return;
        }

        echo "Php request OK!";
    }

}

?>