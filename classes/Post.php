<?php 

class Post{
    private $error="";
    
    public function create_post($userid, $data, $files) {
        
        if (!empty($data["post_content"]) || !empty($files['file']['name']) || isset($data["is_profile_image"]) || isset($data["is_cover_image"])) {
            $post_image = "";
            $has_image = 0;
            $is_profile_image = 0; 
            $is_cover_image = 0; 
            
            if (isset($data["is_profile_image"]) || isset($data["is_cover_image"])) {
                $post_image = $files;
                $has_image = 1; 
                
                
                if (isset($data["is_profile_image"])) {
                    $is_profile_image = 1; 
                }
                
                if (isset($data["is_cover_image"])) {
                    $is_cover_image = 1; 
                }
            } else {
                if (!empty($files['file']['name'])) {
                    $folder = "../upload/" . $userid . '/';
                        
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", "");
                    }
                    
                    $image_class = new Image(); 
                    $post_image = $folder . $image_class->generate_filename(15) . '.jpg';
                    move_uploaded_file($files['file']['tmp_name'], $post_image);
                    $image_class->resize_image($post_image , $post_image , 1500 , 1500);
                    $has_image = 1;
                }
            }
            
            if (isset($data['post_content'])) {
                $post = addslashes($data['post_content']);
                $html_filter = new Flter();
                $post = $html_filter->html_filter($post);
            }
                
            
            // Using PDO for better security
            $DB = new Database();
            $query = "INSERT INTO posts (user_id, post, image , has_image , is_profile_image , is_cover_image) VALUES ( '$userid', '$post', '$post_image', '$has_image', '$is_profile_image', '$is_cover_image')";
            $result = $DB->save($query);

        } else {
            $this->error .= "Please type something to post! <br>";
        }
        
        return $this->error;
    }


    
    public function get_post($userid) {
        $DB = new Database();
        $result = $DB->read("SELECT * FROM posts WHERE user_id = '$userid' ORDER BY post_id DESC LIMIT 10"); 

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function get_one_post($postid) {
        if(!is_numeric($postid)){
            return false;
        }
        $DB = new Database();
        $result = $DB->read("SELECT * FROM posts WHERE post_id = '$postid' LIMIT 1"); 
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    public function delete_post($postid) {
        
        if(!is_numeric($postid)){
            return false;
        }
        
        $DB = new Database();
        $DB->save("DELETE FROM posts WHERE post_id = '$postid' LIMIT 1"); 
    }
    public function i_own_post($postid , $userid) {
        
        if(!is_numeric($postid)){
            return false;
        }
        $query = "SELECT * FROM posts WHERE post_id = '$postid' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);
        $result = $result[0];
        if(is_array($result)){

            if($result['user_id']==$userid){
                return true;
            }
        }
        return false;
    }
    public function like_post($postid , $userid){
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

    public function edit_post($userid, $data, $files) {    
    if (!empty($data["post_content"]) || !empty($files['file']['name']) || isset($data["is_profile_image"]) || isset($data["is_cover_image"])) {
        $post_image = "";
        $has_image = 0;
        $is_profile_image = 0; 
        $is_cover_image = 0; 
        
        if (isset($data["is_profile_image"]) || isset($data["is_cover_image"])) {
            $post_image = $files;
            $has_image = 1; 
            
            if (isset($data["is_profile_image"])) {
                $is_profile_image = 1; 
            }
            
            if (isset($data["is_cover_image"])) {
                $is_cover_image = 1; 
            }
        } else {
            if (!empty($files['file']['name'])) {
                $folder = "../upload/" . $userid . '/';
                    
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder . "index.php", "");
                }
                
                $image_class = new Image(); 
                $post_image = $folder . $image_class->generate_filename(15) . '.jpg';
                move_uploaded_file($files['file']['tmp_name'], $post_image);
                $image_class->resize_image($post_image , $post_image , 1500 , 1500);
                $has_image = 1;
            }
        }
        
        if (isset($data['post_content'])) {
            $post = addslashes($data['post_content']);
            $html_filter = new Flter();
            $post = $html_filter->html_filter($post);
        }
        
        $DB = new Database();
        $post_id = $data['post_id'];
        $query = "UPDATE posts SET post = '$post', image = '$post_image', has_image = '$has_image', is_profile_image = '$is_profile_image', is_cover_image = '$is_cover_image' WHERE post_id = '$post_id' AND user_id = '$userid'";
        $DB->save($query);

    } else {
        $this->error .= "Please type something to post! <br>";
    }
    
    return $this->error;
}

}

