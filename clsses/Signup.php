<?php
class Signup{
    private $error = '';
    
    // Check data 
    public function evaluate($data){
        // remove spaces from email 
        $data['email'] = filter_var($data['email'] , FILTER_SANITIZE_EMAIL);

        foreach ($data as $key => $value) {
            // remove HTML tags and trim whitespace
            $data[$key] = trim($value);

            // check data is empty or not 
            if(empty($value)){
                $this->error .= "The $key field is empty!<br>";
            }
        }

        // flter the email is calidated or not
        if(isset($data['email'])){
            // validated email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $this->error .= "Invalid email address!<br>";
            }
        }

        // check if password equal retype password or not
        if (isset($data['password']) && isset($data['retype_password']) && $data['password'] != $data['retype_password']){
            $this->error .= "Password confirmation must be equal to password<br>";
        }
        
        // check if last name includes a number and includes spaces
        if (isset($data['last_name']) && preg_match('/\d/', $data['last_name']) ) {
            $this->error .= "Last name cannot contain numbers<br>";
        } elseif (isset($data['last_name']) && strstr($data['last_name'], " ")) {
            $this->error .= "Last name cannot contain spaces<br>";
        }

        // check if first name includes a number and includes spaces
        if (isset($data['first_name']) && preg_match('/\d/', $data['first_name'])){
            $this->error .= "First name cannot contain numbers<br>";
        } elseif (isset($data['first_name']) && strstr($data['first_name'], " ")) {
            $this->error .= "First name cannot contain spaces<br>";
        }

        // if no error start user creation
        if ($this->error == ''){
            // No errors
            return $this->create_user($data);
        } else {
            return $this->error;
        }
    }

    // Create user
    public function create_user($data){
        // Decode HTML entities
        $first_name   =   ucfirst(htmlspecialchars_decode($data["first_name"]));
        $last_name    =   ucfirst(htmlspecialchars_decode($data["last_name"]));
        $gender = $data["gender"];
        $email = $data["email"];
        $password = $data["password"];
        
        // Create URL address and user ID
        $url_address = $this->create_url($first_name, $last_name);
        $userid = $this->create_userid();

        // Prepare query to insert user into the database
        $query = "INSERT INTO 
                    users (userid , first_name , last_name , gender , email , password,url_address)
                    VALUES ('$userid', '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";

        // Execute the query
        $DB =  new Database();
        $DB->save($query);
    }

    // Create URL address
    private function create_url($first_name, $last_name){
        return strtolower($first_name) . "." . strtolower($last_name);
    }

    // Create user ID
    private function create_userid(){
        // Generate a random number as user ID
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
}

