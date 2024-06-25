<?php
include_once("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);
$profile = new Profile();
$group = new Group();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image_pro'])) {
    $image_pro = $_FILES['image_pro'];
    
    if (isset($_POST['change']) && $_POST['change'] == 'group' && isset($_POST['group_id'])) {
        $group_id = $_POST['group_id'];
        $group->change_group_cover($group_id, $image_pro);
    } else {
        $profile->change_cover_image($user_data, $image_pro);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change cover image | MrBook</title>
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
                <form action="change_cover_image.php" method='post' enctype="multipart/form-data">
                    <div class="file-input-wrapper">
                        <input type="file" name="image_pro" id="image_pro" class="file-input" onchange="previewImage(event)">
                        <label for="image_pro" class="file-input-label">Choose Image</label>
                    </div>
                    <input type="hidden" name="change" value="<?php echo isset($_GET['type']) && $_GET['type'] == 'group' ? 'group' : 'cover'; ?>">
                    <?php if (isset($_GET['type']) && $_GET['type'] == 'group'): ?>
                        <input type="hidden" name="group_id" value="<?php echo $_GET['ID']; ?>">
                    <?php endif; ?>
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
<?php

