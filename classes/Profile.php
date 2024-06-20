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
    public function update_profile($form_type, $new_value) {
        if($form_type=="password"){
            $filters = new Flter();
            $new_value = $filters->password_hash($new_value);
        }
        try {
            // Check if user is logged in
            if (!isset($_SESSION['mrbook_userid'])) {
                throw new Exception("User is not logged in.");
            }

            $user_id = $_SESSION['mrbook_userid'];
            $filters = new Flter();

            // Filter the new value
            $new_value = $filters->html_filter($new_value);
            $new_value = $filters->sql_filter($new_value);

            // Validate phone number if form type is phone
            if ($form_type == "phone") {
                $phone_check = $filters->is_phone($new_value);
                if ($phone_check !== true) {
                    return $phone_check; // Return validation error
                }
            }

            // Prepare and execute the query
            $DB = new Database();
            $query = "UPDATE users SET $form_type = ? WHERE user_id = ?";
            if ($DB->save($query, [$new_value, $user_id])) {
                return true;
            } else {
                throw new Exception("Failed to update profile.");
            }
        } catch (Exception $e) {
            return $e->getMessage(); // Return the exception message
        }
    }

}