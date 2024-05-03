<?php 
class Login{
    private $error = '';

    public function evaluate($data){
        $email = addcslashes($data["email"], "'");
        $password = addcslashes($data["password"], "'");


        // Prepare query to search user acount 
        $query = "select * from users where email = '$email' limit 1  ";

        // Execute the query
        $DB =  new Database();
        $result = $DB->read($query);
        if ($result){
            $row = $result[0];

            // check password 
            if ($password == $row['password']){
                // create session data
                $_SESSION['mrbook_userid'] = $row['userid'];

            }else{
                $error .="wrong password <br>";
            }
        }else{
            $error .="No such email was found <br>";
        }
        return $error;
        
    }
}