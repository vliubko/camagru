<?php

include_once "IndexModel.php";

class PhotoModel extends Model {
    
    public function showPhoto($photo_id) {
        $photo = $this->db->getPhoto($photo_id);
        if (empty($photo)) {
            return ;
        }
        $user_id = $this->db->getUserId();

        if (isset($_SESSION['username'])) {
            $status = $this->db->checkLikeStatus($user_id, $photo_id);
            $photo["like_status"] = $status;
        }
        $photo["timeAgo"] = IndexModel::diffTime($photo["createdAt"]);
        $photo["comments"] = $this->db->getComments($photo_id);
    
        return $photo;
    }
}
