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
        $photo["comments"] = $this->getCommentDeleteButton($photo["comments"]);
    
        return $photo;
    }

    public function getCommentDeleteButton($comments) {
        
        $current_user_id = $this->db->getUserId();

        foreach ($comments as $key => $comment) {
            $owner_user_id = $this->db->getUserIdByCommentId($comment['id']);
            if ($current_user_id == $owner_user_id) {
                $comments[$key]["showDelete"] = "true";
            }
        }
        return $comments;
    }
}
