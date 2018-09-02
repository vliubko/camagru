<?php

class CabinetModel extends Model {

    public function getPhotosCount() {
        $sql = "SELECT COUNT(*) FROM photos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        return $res;
    }

    public function getUsersCount() {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        return $res;
    }
}

?>