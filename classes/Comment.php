<?php
include_once ("autoloder.php");

class Comment {
    private $error;
    public function add_comment($post_id, $comment_content) {
        $user_id = $_SESSION['mrbook_userid'];
        $DB = new Database();
        $comment_content = $DB->escape_string($comment_content);
        $sql = "INSERT INTO comments (comment_content, users_user_id, posts_post_id) VALUES ('$comment_content', $user_id, $post_id)";
        $DB->save($sql);
        $sql = "UPDATE posts SET comments = comments + 1 WHERE post_id = '$post_id' LIMIT 1";
        $DB->save($sql);
    }

    public function get_comments($post_id) {
        $DB = new Database();
        $sql = "SELECT * FROM comments WHERE posts_post_id = $post_id ORDER BY id DESC LIMIT 10";
        return $DB->read($sql);
    }
    public function like_comment($comment , $userid){
        $sql = "SELECT is_sit FROM comment_likes WHERE users_user_id='$userid' && comments_id = '$comment'";
        $DB = new Database();
        $result= $DB->read($sql);
        if(empty($result)){
            $sql = "INSERT INTO comment_likes (users_user_id,comments_id,is_sit) VALUES ('$userid','$comment','1')";
            $DB->save($sql);
            $sql = "UPDATE comments SET likes = likes + 1 WHERE id = '$comment' LIMIT 1";
            $DB->save($sql);
        }else{
            $sql = "DELETE FROM comment_likes WHERE users_user_id = '$userid' && comments_id = '$comment' LIMIT 1";
            $DB->save($sql);
            $sql = "UPDATE comments SET likes = likes - 1 WHERE id = '$comment' LIMIT 1";
            $DB->save($sql);
        }
    }
    public function get_one_comment($commentid) {
        if(!is_numeric($commentid)){
            return false;
        }
        $DB = new Database();
        $result = $DB->read("SELECT * FROM comments WHERE id = '$commentid' LIMIT 1"); 
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    public function delete_comment($commentid,$post_id) {
        
        if(!is_numeric($commentid)){
            return false;
        }
        
        $DB = new Database();
        $DB->save("DELETE FROM comments WHERE id = '$commentid' LIMIT 1"); 
        $sql = "UPDATE posts SET comments = comments - 1 WHERE post_id = '$post_id' LIMIT 1";
        $DB->save($sql);
    }

    public function edit_comment($data) {
        $userid = $_SESSION['mrbook_userid'];
        if (!empty($data["comment_content"])) { 
            $comment_id = $data['comment_id'];
            $comment_content = addslashes($data['comment_content']);
            $html_filter = new Flter();
            $comment_content = $html_filter->html_filter($comment_content);
            
            $DB = new Database();
            $query = "UPDATE comments SET comment_content = '$comment_content' WHERE id = '$comment_id' AND users_user_id = '$userid'";
            
            $DB->save($query);
        } else {
            $this->error .= "Please type something to comment! <br>";
        }
        
        return $this->error;
    }

}
