<?php
class Signup{
    public function check_data($data){
        // $referrer = $_SERVER['HTTP_REFERER'];
        $DB =  new Database();

        $flters = new Flter();

        // Filter the data before passing it to the evaluate method
        $first_name = $flters->check_is_set($data['first_name'],"first name");
        $last_name = $flters->check_is_set($data['last_name'],"last name");
        $gender = $flters->check_is_set($data['gender'],"gender");
        $email = $flters->is_email($data['email']);
        $query = "SELECT * FROM users WHERE email = '$email'";
        if($DB->read($query)){
            echo "<script>
                    alert('The email is set');
                    window.location.href = '../pages/login.php';
                </script>";
            exit();
        }
        $password = $flters->check_is_set($data['password'],"password");

        
    
        $retype_password = $flters->check_is_set($data['retype_password'],"retype password");
        $password = $flters->confirmation_password_signup($data['password'],$data['retype_password']);  
        return $data = array(
            "first_name"=>$first_name, 
            "last_name"=>$last_name, 
            "gender"=>$gender, 
            "email"=>$email,
            "password"=>$password
        );
    }
    // Create user
    public function create_user($data){
        $DB =  new Database();
        $first_name   =   $data["first_name"];
        $last_name    =   $data["last_name"];
        $gender = $data["gender"];
        $email = $data["email"];
        $password = $data["password"];

        // Create URL address and user ID
        $url_address = $this->create_url($first_name, $last_name);
        

        // Prepare query to insert user into the database
        $query = "INSERT INTO 
                    users (first_name , last_name , gender , email , password , url_address)
                    VALUES ('$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";

        // Execute the query
        $DB->save($query);
    }

    // Create URL address
    private function create_url($first_name, $last_name){
        return strtolower($first_name) . "." . strtolower($last_name);
    }

}

