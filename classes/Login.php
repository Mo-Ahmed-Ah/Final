<?php
include_once ("Function.php");

class Login {
    private $error = '';

    public function evaluate($data) {
        // create opject from function class i want that on hash passwrod 
        $fun = new Flter();

        $email = addcslashes($data["email"], "'");
        $password = addcslashes($data["password"], "'");
        
        
        // Prepare query to search user account
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

        

        // Execute the query
        $DB = new Database();
        $result = $DB->read($query);
        
        if ($result) {
            $row = $result[0];
            // Check password
            if ($fun->password_hash($password) == $row['password']) {
                // Create session data
                $_SESSION['mrbook_userid'] = $row['user_id'];
            } else {
                $this->error .= "Wrong Email or password  ";
            }
        } else {
            $this->error .= "Wrong Email or password  ";
        }
        
        return $this->error;
    }

    public function check_login($id) {
        if(is_numeric($id))
        {
            $query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";

            // Execute the query
            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                $user_data = $result[0];
                return $user_data;
            }else{
                header("Location: ../pages/login.php");
                die;
            }
        }
        else{
            header("Location: ../pages/login.php");
            die;
        }
    }
}

