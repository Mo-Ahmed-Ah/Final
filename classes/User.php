<?php 
class User {
    public function get_data_login($email){
        $query ="SELECT password from users where email = '$email' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if($result){
            return $result[0]["password"];
        } else {
            return false;
        }
    }
    public function get_data($id){
        $query ="SELECT * from users where user_id = '$id' limit 1";
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
        $referrer = $_SERVER['HTTP_REFERER'];
        $query ="SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result[0];
        } else {
            echo "<script>
                alert('Don't found user!');
                window.location.href = '$referrer';
            </script>";
            exit();
        }
    }

    public function get_friends_data($id){
        $query ="SELECT * FROM users WHERE user_id != '$id'";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function get_my_friends_data($id) {
        if(!isset($_SERVER['HTTP_REFERER'])){
            echo "<script>
                    alert('Dont play with me!');
                    setTimeout(function() {
                        window.location.href = '../pages/profile.php';
                    }, 1); 
                </script>";
            exit(); 
        }else{
            $referrer = $_SERVER['HTTP_REFERER'];
        }

        $query = "
            SELECT users.* 
            FROM users 
            INNER JOIN follwers ON users.user_id = follwers.follwer_id
            WHERE follwers.user_id = $id
        ";
        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            return $result;
        } else {
            echo "<script>
                alert('No such User was found!');
                window.location.href = '$referrer';
                </script>";     
            exit();
        }
}


    public function like_user($postid , $userid){
        $sql = "SELECT is_seet FROM likes WHERE user_id='$userid' AND post_id = '$postid'";
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
