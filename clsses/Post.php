<?php 
class Post{
    private $error="";
    public function create_post($userid,$data)
    {
        if (!empty($data["post_content"])){
            $post = addslashes($data['post_content']);
            $postid = $this->create_postid();
            $quary = "INSERT INTO 
                    posts (post_id,user_id,post)
                    VALUES ('$postid' , '$userid' ,'$post')";
            $DB = new Database();
            $DB->save($quary);
        }else{
            $this->error .= "please type something top post! <br>";
        }
        return $this->error;
    }

    private function create_postid(){
        // Generate a random number as post ID
        $number = '';
        do {
            $length = rand(4, 11);
            $number = '';
            for ($i = 1; $i < $length; $i++) { 
                $new_rand = rand(0, 9);
                $number .= $new_rand;
            }
        } while (strlen($number) > 11 || $number > 2147483647);
        
        return $number;
    }
    public function get_post($userid){
        $quary = "select * from posts where user_id = '$userid' order by id desc limit 10";
        $DB = new Database();
        $result = $DB->read($quary);
        if ($result) {
            return $result;
        }else{
            return false;
        }
    }
}