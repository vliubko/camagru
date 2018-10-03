<?php

class CommentModel extends Model {

    public function addNewComment() {
        $user_id = $this->db->getUserId();
        $photo_id = $_POST['photo-id'];
        $message = htmlspecialchars($_POST['comment']);

        $this->newComment($user_id, $photo_id , $message);
    }

    public function newComment($user_id, $photo_id , $message) {
        $fields = array("user","photo","message");
        $values = array($user_id,$photo_id,$message);
        $sql = "INSERT INTO `comment` SET ".$this->db->pdoSet($fields,$values);
        $res = $this->db->run($sql);
        return ;
    }

    public function commentMailNotification($author) {
        $photo_id = $_POST['photo-id'];
        $comment = $_POST['comment'];
        $user_id = $this->db->getUserIdByPhotoId($photo_id);
        
        $user_data = $this->db->getUserDataById($user_id);
        if ($user_data['notification']) {
            $this->sendCommentMail($author, $user_data, $comment, $photo_id);
        }
        return ;
    }

    public function sendCommentMail($author, $user_data, $comment, $photo_id) {
        $to = $user_data['email'];
        $subject = 'New Comment on Photo DevOps Camagru';
        $headers = array(
			'From' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'Reply-To' => 'DevOps Camagru <vliubko@stundent.unit.ua>',
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/html; charset=UTF-8',
        );
        $src = "http://" . $_SERVER['SERVER_NAME'] . '/photo/' . $photo_id;
        
        $first_row = $user_data['username'] . " , you have new comment on your photo! <br>";
        $second_row = $author . " commented: " . "\"" . $comment . "\"<br>" ;
        $thid_row = "You can check new comments ";
        $fourth_row = "<a href=\"" . $src . "\"> >> here <<</a>";

        $message = $first_row . $second_row . $thid_row . $fourth_row;

        $error = mail($to, $subject, $message, $headers);
        if ($error != TRUE) {
            echo "Mail not send. Something went wrong.";
        }
    }


    public function deleteComment($comment_id) {
        $deleted = $this->db->pdoDelete("comment", $comment_id);
    }

    public function checkUserAccess($comment_id) {
        $current_user_id = $this->db->getUserId();
        $owner_user_id = $this->db->getUserIdByCommentId($comment_id);
        if ($current_user_id == $owner_user_id) {
            return true;
        }
        return ;
    }

}
?>