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

    



    public function is_phone($phone){
        if(!is_numeric($phone)){
            return $error = "not numeric";
        }else{
            if(strlen($phone)!=11){
                return $error = "the length is not valed";
            }else{
                return true;
            }
        }
    }

    private function flter_email($email){
        $email = trim($email);
        $email = filter_var($email , FILTER_SANITIZE_EMAIL);
        return $email;
    }
    public function is_email($email){
        $email = $this->flter_email($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<script>
                alert('Invalid email address!');
                window.location.href = '../supbage/change_setting.php?type=change Email';
            </script>";
            exit();
        }
        return $email;
    }
    

    // passeord flter

    // hash passeord with sha1
    public function password_hash($password){
        return hash("sha1", $password);
    }

    // check old function 
    public function check_old_password($password){
        $user = new User();
        if(empty($password)){
            echo "<script>
                alert('The old password is empty!');
                window.location.href = '../supbage/change_setting.php?type=change Password';
            </script>";
            exit();
        }
        $user_data = $user->get_data($_SESSION['mrbook_userid']);
        $password = $this->html_filter($password);
        $password = $this->sql_filter($password);

        
        if($this->password_hash($password)==$user_data["password"]){
            return true;
        }else{
            echo "<script>
                alert('The old password is not true! ');
                window.location.href = '../supbage/change_setting.php?type=change Password';
            </script>";
            exit();
        }
    }


    public function confirmation_password($new_password , $confirm_password){
        if(empty($new_password )){
            echo "<script>
                alert('The new password is empty!');
                window.location.href = '../supbage/change_setting.php?type=change Password';
            </script>";
            exit();
        }else if(empty($confirm_password)){
            echo "<script>
                alert('The confirm password is empty!');
                window.location.href = '../supbage/change_setting.php?type=change Password';
            </script>";
            exit();
        }
        if($new_password == $confirm_password){
            return true;
        }else{
            echo "<script>
                alert('The new password is not equle comfirm password! ');
                window.location.href = '../supbage/change_setting.php?type=change Password';
            </script>";
            exit();
        }
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