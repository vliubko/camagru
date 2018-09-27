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

    public function uploadPhoto() {
        $base64_string = $_POST['base64img'];

        // var_dump($file . ".{$type}");

        $res = $this->base64_to_jpeg($base64_string);

        return $res;
    }

    public function base64_to_jpeg($base64_string) {
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string);
        $type = substr($data[0], strpos($data[0], "/") + 1, 4);
        $type = str_replace(";", "", $type);

        $base64str = base64_decode($data[1]);

        $unique_stamp = sprintf("%0.6f", microtime(true));

        $file = ROOT . "/uploads/" . uniqid("photo_") . $unique_stamp . ".{$type}";

        $res['success'] = file_put_contents($file, $base64str);
        $res['file'] = $file;

        $mimeType = mime_content_type($file);

        if (strpos($mimeType, "image/") === FALSE) {
            return ;
        }

        return $res;
    }
}
