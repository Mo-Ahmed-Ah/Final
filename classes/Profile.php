<?php
class Profile{
    
    public function get_profile($id){
        if(!isset($_SERVER['HTTP_REFERER'])){
            echo "<script>
                    alert('Dont play with me!');
                    setTimeout(function() {
                        window.location.href = '../pages/profile.php';
                    }, 1); 
                </script>";
            exit(); 
        }

        $filters = new Flter();
        $id = $filters->sql_filter($id);
        $DB = new Database();
        $query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
        $result = $DB->read($query);
        if($result){
            return $result;
        }
        
    }

    public function add_phone($new_value){
        $user_id=$_SESSION['mrbook_userid'];
        $filters = new Flter();
        $filters->is_phone($new_value);
        $DB = new Database();
        $new_value = $filters->flter_data($new_value);

        $query = "UPDATE users SET phone = '$new_value' WHERE user_id = '$user_id'";
        $DB->save($query);

    }
    public function update_profile($form_type, $new_value) {
        $referrer = $_SERVER['HTTP_REFERER'];

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
            $new_value = $filters->flter_data($new_value);

            // Validate phone number if form type is phone
            if ($form_type == "phone") {
                $filters->is_phone($new_value);
            }

            // Prepare and execute the query
            $DB = new Database();
            $query = "UPDATE users SET $form_type = '$new_value' WHERE user_id = $user_id";
            if ($DB->save($query)) {
                return true;
            } else {
                throw new Exception("Failed to update profile.");
            }
        } catch (Exception $e) {
            $e = $e->getMessage();
            echo "<script>
                            alert('$e');
                            window.location.href = '$referrer';
                        </script>";
                    exit();
        }
    }

    public function change_profile_image($user_data, $imagePro){
    $referrer = $_SERVER['HTTP_REFERER'];

        if (!empty($imagePro['name'])) {
            if ($imagePro['type'] == 'image/jpeg' && $imagePro['size'] < 3 * 1024 * 1024) {
                $folder = "../upload/" . $user_data["user_id"] . '/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $image = new Image();
                $file_name = $folder . $image->generate_filename(15) . '.jpg';
                move_uploaded_file($imagePro['tmp_name'], $file_name);

                if (file_exists($file_name)) {
                    $image->resize_image($file_name, $file_name, 1500, 1500);

                    $userid = $user_data['user_id'];
                    $query = "UPDATE users SET profile_image = '$file_name' WHERE user_id = '$userid' LIMIT 1";
                    $_POST["is_profile_image"] = 1;

                    $DB = new Database();
                    $DB->save($query);

                    // create the post 
                    $post = new Post();
                    $post->create_post($userid, $_POST, $file_name);

                    header("Location: profile.php");
                    exit;
                } else {
                    echo "<script>
                            alert('Failed to upload image!');
                            window.location.href = '$referrer';
                        </script>";
                    exit();
                }
            } else {
                echo "<script>
                        alert('Only jpeg images of size 3MB or lower are allowed!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }
        } else {
            echo "<script>
                    alert('Please input the image');
                    window.location.href = '$referrer';
                </script>";
            exit();
        }
    }

    public function change_cover_image($user_data,$image_pro){
        $referrer = $_SERVER['HTTP_REFERER'];
        if (!empty($image_pro['name'])) {
            if ($image_pro['type'] == 'image/jpeg') {
                if ($image_pro['size'] < 3 * 1024 * 1024) {
                    $folder = "../upload/" . $user_data["user_id"] . '/';
                    
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                    }

                    $image = new Image();
                    $file_name = $folder . $image->generate_filename(15) . '.jpg';
                    move_uploaded_file($image_pro['tmp_name'], $file_name);

                    if (file_exists($file_name)) {
                        $image->resize_image($file_name, $file_name, 1500, 1500);

                        $userid = $user_data['user_id'];
                        $query = "UPDATE users SET cover_image = '$file_name' WHERE user_id = '$userid' LIMIT 1";
                        $_POST["is_cover_image"] = 1;

                        $DB = new Database();
                        $DB->save($query);

                        $post = new Post();
                        $post->create_post($userid, $_POST, $file_name);
                        echo "<script>
                                alert('complet post');
                                window.location.href = '../pages/profile.php';
                            </script>";
                        exit();
                    }
                } else {
                    echo "<script>
                            alert('Only images of size 3MB or lower are allowed!');
                            window.location.href = '$referrer';
                        </script>";
                    exit();
                }
            } else {
                echo "<script>
                        alert('Only images of type jpeg are allowed!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }
        } else {
            echo "<script>
                    alert('Please input the image');
                    window.location.href = '$referrer';
                </script>";
            exit();
            }
    }


}