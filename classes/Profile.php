<?php
class Profile{

    public function get_profile($id){
        $sql_filter = new Flter();
        $id = $sql_filter->sql_filter($id);
        $DB = new Database();
        $query = "select * from users where user_id = '$id' limit 1";
        return $DB->read($query);
    }


}