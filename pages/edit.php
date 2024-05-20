<?php 
include("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);     
$POST = new Post();
$error = "";
$post = false;

if(isset($_GET['ID'])){
    $post = $POST->get_one_post($_GET['ID']);
    if(!$post){
        $error = "No such post was found!";
    } else {
        if ($post["user_id"] != $_SESSION['mrbook_userid']) {
            $error = "Access denied!";
        }   
    }
} else {
    $error = "No such post was found!";
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $POST->edit_post($user_data['user_id'], $_POST, $_FILES);
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post | MrBook</title>
    <link rel="stylesheet" href="../style/edit_post.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <?php include ("../supbage/header.php"); ?>
    <div class="container">
        <div class="post-container">
            <div class="post-box">
                <?php if($post && !$error): ?>
                    <h2>Edit Post</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="post_content" class="post_textarea" placeholder="What's on your mind"><?php echo htmlspecialchars($post['post']); ?></textarea>
                            <input type="file" name="file" id="file" class="file" onchange="previewImage(event)">
                            <label for="file" class="file-label">Choose Image</label>
                        </div>
                        <div id="image-preview">
                            <?php
                            if (file_exists($post['image'])) {
                                $image_class = new Image();
                                $post_image = $image_class->get_thumb_post($post['image']);
                                echo "<img src='$post_image' class='post_image'>";
                            }
                            ?>
                        </div>
                        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['post_id']); ?>">
                        <div class="button-container">
                            <input type="submit" class="edit-post-button" value="Save">
                        </div>
                    </form>
                <?php else: ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('image-preview');
                output.innerHTML = '<img src="' + reader.result + '" class="post_image">';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
