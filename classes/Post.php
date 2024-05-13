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
}
?>
