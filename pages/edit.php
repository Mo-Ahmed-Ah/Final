<?php 
    include("../classes/autoloder.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['mrbook_userid']);     
    $POST = new Post();
    $error = "";
    $post = false;

    if(isset($_SERVER['HTTP_REFERER'])){
        $referrer = $_SERVER['HTTP_REFERER'];
    } else {
        echo "<script>
                alert('Dont play with me!');
                setTimeout(function() {
                    window.location.href = 'logout.php';
                }, 1); 
            </script>";
        exit(); 
    }

    if(isset($_GET['ID'])){

        $post = $POST->get_one_post($_GET['ID']);
        if(!$post){
            echo "<script>
                    alert('No such post was found!');
                    window.location.href = '$referrer';
                </script>";
            exit();
        } else {
            if ($post["user_id"] != $_SESSION['mrbook_userid']) {
                echo "<script>
                        alert('Access denied!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
            }   
        }
    } else {
        echo "<script>
                    alert('No such post was found!');
                    window.location.href = '$referrer';
                </script>";
            exit();
    }

    if($_SESSION["page"] == "profile"){
        print_r($_FILES);
        die;
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $POST->edit_post($user_data['user_id'], $_POST, $_FILES);
            header("Location: profile.php");
            exit();
        }
    }else if($_SESSION["page"] == "timeline"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $POST->edit_post($user_data['user_id'], $_POST, $_FILES);
            header("Location: timeline.php");
            exit();
        }

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
    <script>
        function confirmDeletion(event) {
            if (!confirm('Are you sure you want to save this update?')) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body>
    <?php include ("../supbage/header.php"); ?>
    <div class="container">
        <div class="post-container">
            <div class="post-box">
                    <h2>Edit comment</h2>
                    <form action="" method="post" enctype="multipart/form-data" onsubmit="confirmDeletion(event)" >
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
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                        <div class="button-container">
                            <input type="submit" class="edit-post-button" value="Save">
                        </div>
                    </form>
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
