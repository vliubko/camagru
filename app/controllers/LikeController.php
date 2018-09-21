<?php

class LikeController extends Controller {

    private $pageTpl = "/views/cabinet/cabinet.tpl.php";

    public function __construct() {
        $this->model = new LikeModel();
        $this->view = new View();
    }

    public function index() {
        
        if (!isset($_SESSION['username'])) {
            return;
        }

        if(!$_POST['photo-id']) {
            header("Location: /public/404.html");
            return;
        }

        $arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        $arr['like-pressed'] = $this->model->likeStatus();
        
        header('Content-type: application/json');
        echo json_encode($arr);
    }

}

?>