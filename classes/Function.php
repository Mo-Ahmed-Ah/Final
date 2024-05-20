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