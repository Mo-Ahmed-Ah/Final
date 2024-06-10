<?php 
include_once("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_FILES['image_pro'])){
        if(isset($_FILES['image_pro']['name']) && $_FILES['image_pro']['name'] != ""){
            if($_FILES['image_pro']['type'] == 'image/jpeg'){
                $allowed_size = 1024 * 1024 * 3;
                if($_FILES['image_pro']['size'] < $allowed_size ){
                    $folder = "../upload/" . $user_data["user_id"] . '/';
                    
                    if(!file_exists($folder)){
                        mkdir($folder, 0777, true);
                    }
                    $image = new Image(); 

                    $file_name = $folder . $image->generate_filename(15) . '.jpg';
                    move_uploaded_file($_FILES['image_pro']['tmp_name'], $file_name);

                    // Ensure that the image file exists before cropping
                    if(file_exists($file_name)){
                        $image->resize_image($file_name , $file_name , 1500 , 1500);
                        $userid = $user_data['user_id'];
                        $query = "UPDATE users SET profile_image = '$file_name' WHERE user_id = '$userid' LIMIT 1";
                        $_POST["is_profile_image"] = 1;
                        $DB = new Database();
                        $DB->save($query);

                        // create the post 
                        $post = new Post();
                        $post->create_post($userid,$_POST,$file_name);
                        header("Location: profile.php");
                        die;    
                    } else {
                        echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
                        echo "Failed to upload image!";
                        echo "</div>";
                    }
                } else {
                    echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
                    echo "Only images of size 3Mb or lower are allowed!";
                    echo "</div>";
                }
            } else {
                echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
                echo "Only images of type jpeg are allowed!";
                echo "</div>";
            }
        } else {
            echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
            echo "Please input the image ";
            echo "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change profile image | MrBook</title>
    <link rel="stylesheet" href="../style/change_image.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <!-- top profile bar -->
    <?php include ("../supbage/header.php"); ?>

    <!-- cover area -->
    <div class="cover_div">
        <!-- post area -->
        <div class="post">
            <div class="post_pox">
                <!-- post form add post  -->
                <form action="change_profile_image.php" method='post' enctype="multipart/form-data">
                    <div class="file-input-wrapper">
                        <input type="file" name="image_pro" class="file-input" onchange="previewImage(event)">
                        <span class="file-input-label">Choose Image</span>
                    </div>
                    <br>
                    <input type="submit" class="change_image_button" value="Change">
                    <br>
                    <div id="image-preview" style="text-align: center; margin-top: 10px;"></div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image-preview');
                output.innerHTML = '<img src="' + reader.result + '" class="post_image" style="max-width: 100%; height: auto;">';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
