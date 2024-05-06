<?php

class Login {
    private $error = '';

    public function evaluate($data) {
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
            if ($password == $row['password']) {
                // Create session data
                $_SESSION['mrbook_userid'] = $row['userid'];
            } else {
                $this->error .= "Wrong password <br>";
            }
        } else {
            $this->error .= "No such email was found <br>";
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
                $user_data= $result[0];
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
?>
