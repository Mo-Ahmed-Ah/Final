<?php 
    class Group{
        public function create_group($group_name,$description="",$file=""){

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

            $query = "INSERT INTO groups (group_name,description,group_url,owner_id,image) 
                    VALUES ('$group_name','$description','$group_name.$user_id','$user_id','$file')";
            if($db->save($query)){
                echo "<script>
                            alert('create is done');
                            window.location.href = '../pages/profile.php';
                        </script>";
                exit();
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

        
    }