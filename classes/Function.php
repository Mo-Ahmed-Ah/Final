<?php
class Flter{

    

    public function sql_filter($sql_code){
        $sql_code = addslashes($sql_code);
        return $sql_code;
    }

    public function html_filter($html_code)
    {
        $html_code = strip_tags($html_code);
        return $html_code;
    }

    public function flter_data($data){
        $data = $this->html_filter($data);
        $data = $this->sql_filter($data);
        return $data;
    }
    

    public function check_is_set($data , $feld_name){
        $referrer = $_SERVER['HTTP_REFERER'];
        if(empty($data)){

            echo "<script>
                    alert('The $feld_name is empty!');
                    window.location.href = '$referrer';
                </script>";
            exit();
        }

        return $this->flter_data($data);
    }


    public function is_phone($phone){
        $referrer = $_SERVER['HTTP_REFERER'];
        if(!is_numeric($phone)){
            echo "<script>
                    alert('not numeric');
                    window.location.href = '$referrer';
                </script>";
            exit();
        }else{
            if(strlen($phone)!=11){
                echo "<script>
                        alert('the length is not valed');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }else{
                return true;
            }
        }
    }

    private function flter_email($email){
        $email=str_replace(" ", "", $email);
        $email = trim($email);
        $email = filter_var($email , FILTER_SANITIZE_EMAIL);
        return $email;
    }
    public function is_email($email){
        $referrer = $_SERVER['HTTP_REFERER'];
        if(empty($email)){
            echo "<script>
                    alert('The email is empty!');
                    window.location.href = '$referrer';
                </script>";
                exit();
        }
            $email = $this->flter_email($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                echo "<script>
                    alert('Invalid email address!');
                    window.location.href = '$referrer';
                </script>";
                exit();
            }
        return $email;
    }
    

    // passeord flter

    public function check_password_it_ok($password , $email){
        $referrer = $_SERVER['HTTP_REFERER'];
        $password = $this->html_filter($password);
        $password = $this->sql_filter($password);
        $password = $this->password_hash($password);
        $user = new User();
        $user_data = $user->get_data_login($email);
        if($password == $user_data){
            return $password;
        }

        echo "<script>
                alert('the passowrd is not true!');
                window.location.href = '$referrer';
            </script>";
        exit();


    }

    // check password strength
    public function check_password_strength($password){
        $password = $this->flter_data($password);
        
        $referrer = $_SERVER['HTTP_REFERER'];
        if(empty($password)){
            echo "<script>
                    alert('Enter password. The password is empty!');
                    window.location.href = '$referrer';
                </script>";
            exit();
        }else{
            if(strlen($password)<8){
                echo "<script>
                        alert('Password must be at least 8 characters long');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }else{
                if (!preg_match('/[A-Z]/', $password)) {
                    echo "<script>
                            alert('Password must contain at least one uppercase letter.');
                            window.location.href = '$referrer';
                        </script>";
                    exit();
                }else{
                    if (!preg_match('/[a-z]/', $password)) {
                        echo "<script>
                                alert('Password must contain at least one lowercase letter.');
                                window.location.href = '$referrer';
                            </script>";
                        exit();
                    }else{
                        if (!preg_match('/[0-9]/', $password)) {
                            echo "<script>
                                    alert('Password must contain at least one number.');
                                    window.location.href = '$referrer';
                                </script>";
                            exit();
                        }else{
                            return $password;
                        }
                    }
                }
            }
        }
    }
    // hash passeord with sha1
    public function password_hash($password){
        return hash("sha1", $password);
    }

    // check old function 
    public function check_old_password($password){
        $user = new User();
        $referrer = $_SERVER['HTTP_REFERER'];

        if(empty($password)){

            echo "<script>
                alert('The old password is empty!');
                window.location.href = '$referrer';
            </script>";
            exit();
        }
        $user_data = $user->get_data($_SESSION['mrbook_userid']);
        $password = $this->flter_data($password);

        
        if($this->password_hash($password)==$user_data["password"]){
            return true;
        }else{
            echo "<script>
                alert('The old password is not true! ');
                window.location.href = '$referrer';
            </script>";
            exit();
        }
    }

    public function confirmation_password_signup($new_password , $confirm_password){
        $new_password = $this->check_password_strength($new_password);
        if($this->confirmation_password($new_password, $confirm_password)){
            return $this->password_hash($new_password);
        }

    }

    public function confirmation_password($new_password , $confirm_password){
        $referrer = $_SERVER['HTTP_REFERER'];
        if(empty($new_password )){
            echo "<script>
                alert('The new password is empty!');
                window.location.href = '$referrer';
            </script>";
            exit();
        }else if(empty($confirm_password)){
            echo "<script>
                alert('The confirm password is empty!');
                window.location.href = '$referrer';
            </script>";
            exit();
        }
        if($new_password == $confirm_password){
            return true;
        }else{
            echo "<script>
                alert('The new password is not equle comfirm password! ');
                window.location.href = '$referrer';
            </script>";
            exit();
        }
    }
}

class Check_Images{
    public function is_user_have_image($user_data_profile,$user_data_post_type){
        $image_class = new Image();
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

    public function is_group_have_image($group_profile){
        $image_class = new Image();
        if(file_exists($group_profile)){
            return $image_class ->get_thumb_profile($group_profile);
        }else{
            return "../assets/group.png";
        }
    }


}