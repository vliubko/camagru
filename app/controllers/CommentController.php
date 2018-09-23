<?php

class CommentController extends Controller {

    private $pageTpl = "/views/cabinet/cabinet.tpl.php";

    public function __construct() {
        $this->model = new CommentModel();
        $this->view = new View();
    }

    public function index() {
        
        if (!isset($_SESSION['username'])) {
            $arr['error'] = "no session";
            header('Content-type: application/json');
            echo json_encode($arr);
            return;
        }

        if(!$_POST['comment']) {
            header("Location: /public/404.html");
            return;
        }
        
        $this->model->addNewComment();
        $arr['username'] = $_SESSION['username'];
        header('Content-type: application/json');
        echo json_encode($arr);
    }

}

?>