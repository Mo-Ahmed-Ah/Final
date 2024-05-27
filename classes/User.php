<?php 
class User {
    public function get_data($id){
        $query ="select * from users where user_id = '$id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if($result){
            $row = $result[0];
            return $row;
        } else {
            return false;
        }
    }

    public function get_user_data($id)
    {
        $query ="select * from users where user_id != '$id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    public function get_user_data_post($id)
    {
        $query ="select * from users where user_id = '$id' limit 1";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function get_friends_data($id){
        $query ="select * from users where user_id != '$id'";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function like_user($postid , $userid){
        $sql = "SELECT is_seet FROM likes WHERE user_id='$userid' && post_id = '$postid'";
        $DB = new Database();
        $result= $DB->read($sql);
        if(empty($result)){
            $sql = "INSERT INTO likes (user_id,post_id,is_seet) VALUES ('$userid','$postid','1')";
            $DB->save($sql);
            $sql = "UPDATE posts SET likes = likes + 1 WHERE post_id = '$postid' LIMIT 1";
            $DB->save($sql);
        }else{
            $sql = "DELETE FROM likes WHERE user_id = '$userid' && post_id = '$postid' LIMIT 1";
            $DB->save($sql);
            $sql = "UPDATE posts SET likes = likes - 1 WHERE post_id = '$postid' LIMIT 1";
            $DB->save($sql);
        }
    }

    public function follwer_user($follwer_id , $my_id){
        $sql = "SELECT is_seet FROM follwers WHERE user_id='$my_id' && follwer_id = '$follwer_id'";
        $DB = new Database();
        $result= $DB->read($sql);

        if(empty($result)){
            
            $sql = "INSERT INTO follwers (user_id,follwer_id,is_seet) VALUES ('$my_id','$follwer_id','1')";
            $DB->save($sql);
            $sql = "UPDATE users SET follwers = follwers + 1 WHERE user_id = '$follwer_id' LIMIT 1";
            $DB->save($sql);
        }else{
            
            $sql = "DELETE FROM follwers WHERE user_id = '$my_id' && follwer_id = '$follwer_id' LIMIT 1";
            $DB->save($sql);

            $sql = "UPDATE users SET follwers = follwers - 1 WHERE user_id = '$follwer_id' LIMIT 1";
            $DB->save($sql);

            
        }
    }
    public function is_follwer_user($follwer_id, $my_id)
    {
        $sql = "SELECT is_seet FROM follwers WHERE user_id='$my_id' AND follwer_id='$follwer_id'" ;
        $DB = new Database();
        $result= $DB->read($sql);
        if (empty($result)) {
            return false;
        }else{
            return true;
        }
    }
}
