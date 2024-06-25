<?php
include_once ("autoloder.php");

class Comment {
    private $error;
    public function add_comment($post_id, $comment_content) {
        $user_id = $_SESSION['mrbook_userid'];
        $DB = new Database();
        $flters = new Flter();
        $comment_content = $flters->flter_data($comment_content);
        $sql = "INSERT INTO comments (comment_content, user_id, post_id) VALUES ('$comment_content', $user_id, $post_id)";
        $DB->save($sql);
        $sql = "UPDATE posts SET comments = comments + 1 WHERE post_id = '$post_id' LIMIT 1";
        $DB->save($sql);
    }

    public function get_comments($post_id) {
        $DB = new Database();
        $sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY id DESC ";
        return $DB->read($sql);
    }
    public function like_comment($comment , $userid){
        $sql = "SELECT is_seen FROM comment_likes WHERE user_id='$userid' && comment_id = '$comment'";
        $DB = new Database();
        if(empty($DB->read($sql))){
            $sql = "INSERT INTO comment_likes (user_id,comment_id,is_seen) VALUES ('$userid','$comment','1')";
            $DB->save($sql);
            $sql = "UPDATE comments SET likes = likes + 1 WHERE id = '$comment' LIMIT 1";
            $DB->save($sql);
        }else{
            $sql = "DELETE FROM comment_likes WHERE user_id = '$userid' && comment_id = '$comment' LIMIT 1";
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
        if(isset($_SERVER['HTTP_REFERER'])){
            $referrer = $_SERVER['HTTP_REFERER'];
        } else {
            echo "<script>
            alert('Dont play with me!');
            setTimeout(function() {
                window.location.href = 'logout.php';
                }, 1); 
                </script>";
                exit(); 
            }
            $userid = $_SESSION['mrbook_userid'];
            if (!empty($data["comment_content"])) { 
                $comment_id = $data['comment_id'];
                
                $html_filter = new Flter();
                $comment_content = $html_filter->flter_data($data['comment_content']);
                
                $DB = new Database();
                $query = "UPDATE comments SET comment_content = '$comment_content' WHERE id = '$comment_id' AND user_id = '$userid'";
                
                $DB->save($query);
        } else {

            echo "<script>
                    alert('Please type something to comment! ');
                    window.location.href = '$referrer';
                </script>";
            exit();
        }
    }

}
