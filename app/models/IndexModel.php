<?php

class IndexModel extends Model {
    public function showPhotos() {
        $photos = $this->db->getAllPhotos();
        return $photos;
    }

}