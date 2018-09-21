<?php

class IndexModel extends Model {
    public function showPhotos() {
        $photos = $this->db->getAllPhotos();
        $user_id = $this->db->getUserId();
        foreach ($photos as $key => $photo) {
            if (isset($_SESSION['username'])) {
                $status = $this->db->checkLikeStatus($user_id, $photo['id']);
                $photos[$key]["like_status"] = $status;
            }
            $photos[$key]["timeAgo"] = $this->diffTime($photos[$key]["createdAt"]);
            $photos[$key]["comments"] = $this->db->getComments($photo['id']);
        }
        // var_dump($photos);
        return $photos;
    }

    function diffTime($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
 
}