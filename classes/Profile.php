<?php
class Profile{
    
    public function get_profile($id){
        $filters = new Flter();
        $id = $filters->sql_filter($id);
        $DB = new Database();
        $query = "select * from users where user_id = '$id' limit 1";
        return $DB->read($query);
    }

    public function add_phone($new_value){
        $user_id=$_SESSION['mrbook_userid'];
        $filters = new Flter();
        $phone_check = $filters->is_phone($new_value);
        if ($phone_check !== true) {
            return $phone_check;
        }
        $DB = new Database();
        $new_value = $filters->html_filter($new_value);
        $new_value = $filters->sql_filter($new_value);
        $query = "UPDATE users SET phone = '$new_value' WHERE user_id = '$user_id'";
        $DB->save($query);
    }
    public function update_profile($form_type, $new_value){
        $user_id=$_SESSION['mrbook_userid'];
        $filters = new Flter();
        $new_value = $filters->html_filter($new_value);
        $new_value = $filters->sql_filter($new_value);
        if($form_type=="phone"){
            $phone_check = $filters->is_phone($new_value);
            if ($phone_check !== true) {
                return $phone_check;
            }
        }
        $DB = new Database();
        $new_value = $filters->html_filter($new_value);
        $new_value = $filters->sql_filter($new_value);
        $query = "UPDATE users SET '$form_type' = '$new_value' WHERE user_id = '$user_id'";
        $DB->save($query);
    }

}