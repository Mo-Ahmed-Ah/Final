<?php
include_once ("Function.php");

class Login {


    public function evaluate($email , $password) {
        // Prepare query to search user account
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        // Execute the query
        $DB = new Database();
        $result = $DB->read($query);
        $row = $result[0];
        $_SESSION['mrbook_userid'] = $row['user_id'];
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

