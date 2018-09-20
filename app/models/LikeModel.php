<?php

class LikeModel extends Model {

    public function likeStatus() {
        $user_id = $this->db->getUserId();
        $like_id = $this->db->checkLikeStatus($user_id, $_POST['photo-id']);

        if (empty($like_id)) {
            $this->newLike($user_id);
            return "false";
        } else {
            $this->deleteLike($like_id);
            return "true";
        }
    }

    public function newLike($user_id) {
        $photo_id = $_POST['photo-id'];

        $fields = array("user","photo");
        $values = array($user_id,$photo_id);
        $sql = "INSERT INTO `like` SET ".$this->db->pdoSet($fields,$values);
        $res = $this->db->run($sql);
        return ;
    }

    public function deleteLike($like_id) {
        $deleted = $this->db->pdoDelete("like", $like_id);
    }

}
?>