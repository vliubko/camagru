<?php

class IndexModel extends Model {
    public function showPhotos() {
        $photos = $this->db->getAllPhotos();
        // foreach ($photos as $photo) {
        //     $photo_id = $photo['id'];
        //     $likes = $this->db->countLikes($photo_id);
        //     $photo['likes'] = $likes;
        //     echo $likes;
        // }


        // var_dump($photos);
        return $photos;
    }

}