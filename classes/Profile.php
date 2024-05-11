<?php
class Profile{

    public function get_profile($id){
        $sql_filter = new Fun();
        $id = $sql_filter->sql_filter($id);
        $DB = new Database();
        $query = "select * from users where userid= '$id' limit 1";
        return $DB->read($query);
    }


}