<?php
    class Group{
        public function create_group($group_name,$description="",$file=""){
            $group_id = $this->select_end_id();
            $group_id ++;
            $user_id=$_SESSION['mrbook_userid'];
            $flter = new Flter;
            $db = new Database();
            $referrer = $_SERVER['HTTP_REFERER'];

            if (!empty($file['name'])) {
            if ($file['type'] == 'image/jpeg' && $file['size'] < 3 * 1024 * 1024) {
                $folder = "../upload/" . $group_name . $user_id . '/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $image = new Image();
                $file_name = $folder . $image->generate_filename(15) . '.jpg';
                move_uploaded_file($file['tmp_name'], $file_name);

                if (file_exists($file_name)) {
                    $file = $file_name;
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
        }
            if (empty($group_name)) {
                echo "<script>
                            alert('the group name is recoured');
                            window.location.href = '$referrer';
                        </script>";
                exit();
            }
            $group_name = $flter->flter_data($group_name);
            if(!empty($description)){
                $description = $flter->flter_data($description);
            }

            $query = "INSERT INTO groups (id,group_name,description,group_url,owner_id,image) 
                    VALUES ('$group_id','$group_name','$description','$group_name.$user_id','$user_id','$file')";
            if($db->save($query)){
                $query = "INSERT INTO users_group (user_id,group_id,role) VALUES ('$user_id','$group_id','owner')";
                if($db->save($query)){
                    echo "<script>
                                alert('create is done');
                                window.location.href = '../pages/profile.php';
                            </script>";
                    exit();
                }else{
                    echo "<script>
                                alert('error in add user owner in the group users taple');
                                window.location.href = '../pages/profile.php';
                            </script>";
                    exit(); 
                }
            }

        }

        public function show_all_group(){
            $db = new Database();
            $query = "SELECT * FROM groups";
            $groups = $db->read($query);
            if($groups){
                return $groups;
            }else{
                return false;
            }
        }

        public function select_end_id(){
            $db = new Database();
            $query ="SELECT id FROM groups ORDER BY id DESC LIMIT 1";
            $ids = $db->read($query);
            if ($ids){
                return $ids[0]['id'];
            }else{
                return 0;
            }
        }
        
        public function show_joined_groups() {
            $user_id = $_SESSION['mrbook_userid'];
            $db = new Database();

            
            // Query to get the groups the user has joined
            $query = "
                SELECT *
                FROM groups 
                JOIN users_group ON groups.id = users_group.group_id
                WHERE users_group.user_id = '$user_id'
            ";
            
            $groups = $db->read($query);
            
            if ($groups) {
                return $groups;
            } else {
                return [];
            }
        }

        public function show_one_group($id){
            $referrer = $_SERVER['HTTP_REFERER'];
            $db = new Database();
            $query = "SELECT * FROM groups WHERE id = $id";
            $groups = $db->read($query);
            if($groups){
                return $groups[0];
            }else{
                echo "<script>
                            alert('Not found group!');
                            window.location.href = '$referrer';
                        </script>";
                exit();
            }
        }

        public function remove_group($group_id){
            $db = new Database();
            $user_id=$_SESSION['mrbook_userid'];
            $query = "DELETE FROM groups WHERE id='$group_id' AND owner_id='$user_id'";
            $referrer = $_SERVER['HTTP_REFERER'];
            if($db->save($query)){
                echo "<script>
                        alert('complet remove');
                        window.location.href = '../pages/group.php';
                    </script>";
                exit();
            }else{
                echo "<script>
                        alert('Can't remove this group!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }
        }

        public function get_posts_group($group_id){
            $db = new Database();
            $query ="SELECT * FROM group_posts WHERE group_id='$group_id' ORDER BY id DESC";
            $ids = $db->read($query);
            if ($ids){
                return $ids;
            }else{
                return 0;
            }
        }

        public function create_group_post($userid, $data, $files){
            $referrer = $_SERVER['HTTP_REFERER'];

            // Check if post content or file is provided
            if (!empty($data["post_content"]) || !empty($files['file']['name']) || isset($data["is_cover_image"])) {
                $post_image = "";
                $has_image = 0;
                $is_cover_image = 0;

                // Handle cover image case
                if (isset($data["is_cover_image"])) {
                    $post_image = $files;
                    $has_image = 1;
                    $is_cover_image = 1;
                } else {
                    // Handle regular image upload
                    if (!empty($files['file']['name'])) {
                        $folder = "../upload/" . $userid . '/';
                        if (!file_exists($folder)) {
                            mkdir($folder, 0777, true);
                            file_put_contents($folder . "index.php", "");
                        }

                        $image_class = new Image();
                        $post_image = $folder . $image_class->generate_filename(15) . '.jpg';
                        move_uploaded_file($files['file']['tmp_name'], $post_image);
                        $image_class->resize_image($post_image , $post_image , 1500 , 1500);
                        $has_image = 1;
                    }
                }

                // Filter post content
                $post = "";
                if (isset($data['post_content'])) {
                    $html_filter = new Flter();
                    $post = $html_filter->flter_data($data['post_content']);
                }

                // Check for group ID
                if (isset($data['group_id'])) {
                    $group_id = $data['group_id'];
                } else {
                    echo "<script>
                            alert('Group ID is missing!');
                            window.location.href = '$referrer';
                        </script>";
                    exit();
                }

                // Insert post into database
                $DB = new Database();
                $query = "INSERT INTO group_posts (user_id, group_id, post, image, is_cover_image, has_image) 
                        VALUES ('$userid', '$group_id', '$post', '$post_image', '$is_cover_image', '$has_image')";
                $DB->save($query);

            } else {
                echo "<script>
                        alert('Please type something to post!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }
        }


        public function get_one_post($postid) {
            if(!is_numeric($postid)){
                return false;
            }
            $DB = new Database();
            $query = "SELECT * FROM group_posts WHERE id = '$postid' LIMIT 1";
            $result = $DB->read($query); 
            if ($result) {
                return $result[0];
            } else {
                return false;
            }
        }
        
        public function delete_post($postid) {
            
            if(!is_numeric($postid)){
                return false;
            }
            $DB = new Database();
            $query = "DELETE FROM group_posts WHERE id = '$postid' LIMIT 1";
            $DB->read($query); 
            


        }
        public function like_post_group($postid , $userid){
            $sql = "SELECT is_seen FROM group_post_likes WHERE user_id='$userid' && post_id = '$postid'";
            $DB = new Database();
            $result= $DB->read($sql);
            if(empty($result)){
                $sql = "INSERT INTO group_post_likes (user_id,post_id,is_seen) VALUES ('$userid','$postid','1')";
                $DB->save($sql);
                $sql = "UPDATE group_posts SET likes = likes + 1 WHERE id = '$postid' LIMIT 1";
                $DB->save($sql);
            }else{
                $sql = "DELETE FROM group_post_likes WHERE user_id = '$userid' && post_id = '$postid' LIMIT 1";
                $DB->save($sql);
                $sql = "UPDATE group_posts SET likes = likes - 1 WHERE id = '$postid' LIMIT 1";
                $DB->save($sql);
            }
        }

        public function edit_post($userid, $data, $files) {
            $referrer = $_SERVER['HTTP_REFERER'];

            // التحقق من وجود محتوى أو صورة
            if (empty($data['post_content']) && empty($files['file']['name'])) {
                echo "<script>
                        alert('Please type something to post!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }

            // تهيئة المتغيرات
            $post = "";
            $post_image = "";
            $has_image = 0;

            // معالجة رفع الصورة إذا كانت موجودة
            if (!empty($files['file']['name'])) {
                $folder = "../upload/" . $userid . '/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder . "index.php", "");
                }
                $image_class = new Image();
                $post_image = $folder . $image_class->generate_filename(15) . '.jpg';
                move_uploaded_file($files['file']['tmp_name'], $post_image);
                $image_class->resize_image($post_image, $post_image, 1500, 1500);
                $has_image = 1;
            }

            // تنقية وتحضير محتوى المنشور
            if (!empty($data['post_content'])) {
                $html_filter = new Flter(); // Assuming this is a typo and should be Filter
                $post = $html_filter->flter_data($data['post_content']);
            }

            // تحضير استعلام SQL بناءً على التغييرات
            $DB = new Database();
            $post_id = $data['post_id'];
            $query = "UPDATE group_posts SET post = '$post',";
            if (!empty($files['file']['name'])) {
                $query .= " image = '$post_image', has_image = '$has_image',";
            }
            $query = rtrim($query, ','); 
            $query .= " WHERE id = '$post_id'";
            
            // تنفيذ الاستعلام
            $DB->save($query);
        }

        public function change_group_cover($group_id, $image_pro) {
            $referrer = $_SERVER['HTTP_REFERER'];
            
            // التحقق إذا كانت الصورة موجودة
            if (!empty($image_pro['name'])) {
                // التحقق من نوع الصورة
                if ($image_pro['type'] == 'image/jpeg') {
                    // التحقق من حجم الصورة
                    if ($image_pro['size'] < 3 * 1024 * 1024) {
                        $folder = "../upload/groups/" . $group_id . '/';
                        
                        // إنشاء المجلد إذا لم يكن موجودًا
                        if (!file_exists($folder)) {
                            mkdir($folder, 0777, true);
                        }

                        $image = new Image();
                        $file_name = $folder . $image->generate_filename(15) . '.jpg';
                        move_uploaded_file($image_pro['tmp_name'], $file_name);

                        if (file_exists($file_name)) {
                            $image->resize_image($file_name, $file_name, 1500, 1500);

                            // تحديث صورة الغلاف في قاعدة البيانات
                            $query = "UPDATE groups SET image = '$file_name' WHERE id = '$group_id' LIMIT 1";

                            $DB = new Database();
                            $DB->save($query);

                            // إنشاء بوست لتحديث صورة الغلاف
                            $post_data = [
                                'group_id' => $group_id,
                                'is_cover_image' => 1
                            ];
                            $this->create_group_post($_SESSION['mrbook_userid'], $file_name, $post_data);
                            
                            
                            echo "<script>
                                    alert('Cover image updated successfully.');
                                    window.location.href = '../pages/group_profile.php?ID=$group_id';
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

        public function get_owner_name($owner_id) {
            $DB = new Database();
            $query = "SELECT first_name, last_name FROM users WHERE user_id = '$owner_id' LIMIT 1";
            $result = $DB->read($query);
            if ($result) {
                return $result[0];
            } else {
                return false;
            }
        }

        public function get_users_ingroup($group_id) {
            $DB = new Database();
            try {
                $query = "
                    SELECT *
                    FROM users
                    INNER JOIN users_group ON users.user_id = users_group.user_id
                    WHERE users_group.group_id = '$group_id' AND users_group.is_banned = 0
                ";
                return $DB->read($query);
            } catch (Exception $e) {
                throw new Exception("Error getting users in group: " . $e->getMessage());
            }
        }
        public function get_admin_ingroup($group_id) {
            $DB = new Database();
            try {
                $query = "
                    SELECT *
                    FROM users
                    INNER JOIN users_group ON users.user_id = users_group.user_id
                    WHERE users_group.group_id = '$group_id' AND users_group.is_banned = 0 AND role='Admin'
                ";
                return $DB->read($query);
            } catch (Exception $e) {
                throw new Exception("Error getting users in group: " . $e->getMessage());
            }
        }

        public function is_user_ingroup($user_id, $group_id)
        {
            $sql = "SELECT * FROM users_group WHERE user_id='$user_id' AND group_id='$group_id'" ;
            $DB = new Database();
            $result= $DB->read($sql);
            if (empty($result)) {
                return false;
            }else{
                return true;
            }
        }

        public function add_admin($user_id, $group_id) {
            $DB = new Database();
            $query = "UPDATE user_group SET role = 'Admin' WHERE user_id = '$user_id' AND group_id = '$group_id'";
            
            if ($DB->save($query)) {
                return true;
            }
            return false;
        }

        public function remove_admin($user_id, $group_id) {
            $DB = new Database();
            $query = "UPDATE user_group SET role = 'Member' WHERE user_id = '$user_id' AND group_id = '$group_id'";
            if ($DB->save($query)) {
                return true;
            }
            return false;
        }

        public function change_owner($new_owner_id, $group_id) {
            $DB = new Database();
            $query = "UPDATE groups SET owner_id = '$new_owner_id' WHERE id = '$group_id'";
            if ($DB->save($query)) {
                return true;
            }
            return false;
        }

        public function join_group($user_id, $group_id) {
            $DB = new Database();
            
            // Check if the user is already in the group
            $sql = "SELECT * FROM users_group WHERE user_id ='$user_id' AND group_id='$group_id'";
            $result = $DB->read($sql);
            
            if(empty($result)) {
                // If user is not in the group, insert them as a member
                $sql = "INSERT INTO users_group (user_id,group_id,role) VALUES ('$user_id','$group_id','Member')";
                $DB->save($sql);
                
                // Update the number of members in the group
                $sql = "UPDATE groups SET number_of_members = number_of_members + 1 WHERE id = '$group_id' LIMIT 1";
                $DB->save($sql);
            } else {
                // If user is already in the group, remove them
                $sql = "DELETE FROM users_group WHERE user_id = '$user_id' AND group_id = '$group_id' LIMIT 1";
                $DB->save($sql);
                
                // Update the number of members in the group
                $sql = "UPDATE groups SET number_of_members = number_of_members - 1 WHERE id = '$group_id' LIMIT 1";
                $DB->save($sql);
            }
        }
    }

    /*
        user type 
            1-Owner
            2-Admin
            3-Member
            
    */