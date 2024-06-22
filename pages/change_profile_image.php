<?php 
include_once("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);
$profile = new Profile();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_pro'])) {
    $imagePro = $_FILES['image_pro'];
    $profile->change_profile_image($user_data, $imagePro);
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
                output.innerHTML = '<img src="' + reader.result + '" class="post_image" >';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
