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
            http_response_code(403);
            header('Content-type: application/json');
            echo json_encode($arr);
            return;
        }

        if(!$_POST['comment']) {
            header("Location: /public/404.html");
            return;
        }

        $author = $_SESSION['username'];
        
        $this->model->addNewComment();
        $this->model->commentMailNotification($author);
        
        $arr['username'] = $author;
        header('Content-type: application/json');
        echo json_encode($arr);
    }

    public function delete() {
        $route = explode("/", $_SERVER['REQUEST_URI']);
        $comment_id = $route[3];

        if(!isset($_SESSION['username']) || empty($comment_id)) {
            header("Location: /public/404.html");
            return;
        }

        $allowed = $this->model->checkUserAccess($comment_id);
        if ($allowed) {
            $this->model->deleteComment($comment_id);
        } else {
            header("Location: /");
            return;
        }

        if (empty($_SERVER['HTTP_REFERER'])) {
            header("Location: /");
            return;
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            return ;
        }
    }

}

?>