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

    public function addNewPhotoToDB($photo_url) {
        $user_id = $this->db->getUserId();
        
        $fields = array("user","url");
        $values = array(
            $user_id, $photo_url);
        $sql = "INSERT INTO photo SET ".$this->db->pdoSet($fields,$values);
        $res = $this->db->run($sql);
        return ;
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
        
        $sticker = ROOT .$_POST['sticker'];

        $res['success'] = file_put_contents($file, $base64str);
        $res['file'] = $file;

        if ($sticker) {
            $this->merge_sticker($file, $sticker);
        }
        
        $mimeType = mime_content_type($file);

        if (strpos($mimeType, "image/") === FALSE) {
            return ;
        }

        $photo_url = str_replace(ROOT, "", $file);
        $this->addNewPhotoToDB($photo_url);

        return $res;
    }

    public function merge_sticker($dest_file, $src_file) {
        $dest = imagecreatefrompng($dest_file);
        $src = imagecreatefrompng($src_file);

        list($srcfileWidth, $srcfileHeight) = getimagesize($src_file);

        if (!$dest || !$src) {
            return ;
        }

        imagealphablending($dest, true);
        imagesavealpha($dest, true);

        imagecopy($dest, $src, 30, 30, 0, 0, $srcfileWidth, $srcfileHeight);
        
        header('Content-Type: image/png');

        imagepng($dest, $dest_file);
        
        imagedestroy($dest);
        imagedestroy($src);
    }

    public function deletePhotoById($photo_id) {
        if (!$this->checkUserAccess($photo_id)) {
            http_response_code(403);
            echo "403. Forbidden" ;
            return ;
        }
        $comments = $this->db->getComments($photo_id);

        foreach ($comments as $i => $comment) {
            $this->db->pdoDelete("comment", $comment['id']);
        }
        $deleted = $this->db->pdoDelete("photo", $photo_id);
        header("Location: /");
    }

    public function checkUserAccess($photo_id) {
        $current_user_id = $this->db->getUserId();
        $owner_user_id = $this->db->getUserIdByPhotoId($photo_id);
        if ($current_user_id == $owner_user_id) {
            return true;
        }
        return ;
    }


}
