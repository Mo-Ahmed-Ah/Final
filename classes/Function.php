<?php
class Flter{
    public function sql_filter($sql_code){
        $sql_code = addslashes($sql_code);
        return $sql_code;
    }

    public function html_filter($html_code)
    {
        $html_code = htmlspecialchars($html_code);
        return $html_code;
    }

    public function password_hash($password){
        return hash("sha1", $password);
    }

    
}

class Check_Images{
    public function is_user_have_image($user_data_profile,$user_data_post_type){

        $image_class = new Image();
        if($_SESSION["page"]=="profile"){
        if(file_exists($user_data_profile)){
            return $image_class ->get_thumb_profile($user_data_profile);
        }else{
            if ($user_data_post_type == "Male"){
                return "../assets/user_male.jpg";
            }else{
                return "../assets/user_female.jpg";
            }
        }
        } elseif ($_SESSION["page"] == "timeline") {
            if(file_exists($user_data_profile)){
                return $image_class ->get_thumb_profile($user_data_profile);
            }else{
                if ($user_data_post_type == "Male"){
                    return "../assets/user_male.jpg";
                }else{
                    return "../assets/user_female.jpg";
                }
            }
        }
    }

    
    

}