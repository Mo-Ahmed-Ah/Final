<?php


class Login {
    private $error = '';

    public function evaluate($data) {
        // create opject from function class i want that on hash passwrod 
        $fun = new Fun();

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
                $_SESSION['mrbook_userid'] = $row['userid'];
            } else {
                $this->error .= "Wrong Email or password  <br>";
            }
        } else {
            $this->error .= "Wrong Email or password <br>";
        }
        
        return $this->error;
    }

    public function check_login($id) {
        if(is_numeric($id))
        {
            $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";

            // Execute the query
            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                $user_data = $result[0];
                return $user_data;
            }else{
                header("Location: login.php");
                die;
            }
        }
        else{
            header("Location: login.php");
            die;
        }
    }
}

