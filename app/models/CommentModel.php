<?php

class CommentModel extends Model {

    public function addNewComment() {
        $user_id = $this->db->getUserId();
        $photo_id = $_POST['photo-id'];
        $message = $_POST['comment'];

        $this->newComment($user_id, $photo_id , $message);
        
        echo "php is ok!";
    }

    public function newComment($user_id, $photo_id , $message) {
        $fields = array("user","photo","message");
        $values = array($user_id,$photo_id,$message);
        $sql = "INSERT INTO `comment` SET ".$this->db->pdoSet($fields,$values);
        $res = $this->db->run($sql);
        return ;
    }

    // public function deleteLike($like_id) {
    //     $deleted = $this->db->pdoDelete("like", $like_id);
    // }

}
?>