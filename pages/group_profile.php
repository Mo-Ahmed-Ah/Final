<?php
include_once("../classes/autoloder.php");
$_SESSION["page"] = "group";
$image_class = new Image();

if (isset($_GET['ID'])) {
    $groups = new Group;
    $flters = new Check_Images();
    $group = $groups->show_one_group($_GET['ID']);
    $posts = $groups->get_posts_group($_GET['ID']);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $userid = $_SESSION['mrbook_userid'];
    $data = [
        'post_content' => $_POST['post_content'] ?? '',
        'group_id' => $_GET['ID']
    ];
    $files = $_FILES;

    $groups->create_group_post($userid, $data, $files);

    header("Location: group_profile.php?ID=$data[group_id]");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups | MrBook</title>
    <link rel="stylesheet" href="../style/group.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include ("../supbage/header.php"); ?>
    
    <div class="cover_div">
        <div class="cover_img">
            <?php
                $image_cover = "../assets/mountain.jpg";
                if (isset($user_data['cover_image']) && file_exists($user_data['cover_image'])) {
                    $image_cover = $image_class->get_thumb_cover($user_data['cover_image']);
                }
            ?>
            <img src="<?= $image_cover; ?>" alt="Cover Image" class="cover_cover_img">
            
            <span class="profile_image">
                <?php if ($group["owner_id"] == $_SESSION['mrbook_userid']): ?>
                    <a href="../supbage/change_images.php?change=Group_image&ID=<?= $group['id']; ?>" class="change_image">Change Cover</a>
                <?php else: 
                    $follwer_user = $groups->is_user_ingroup($_SESSION['mrbook_userid'], $group['id']);
                ?>
                    <a href="../supbage/like.php?type=Join_Group&id=<?= $group['id']; ?>">
                        <input type="submit" class="<?= $follwer_user ? 'Frindes_button' : 'folow_button'; ?>" value="<?= $follwer_user ? 'Exit' : 'Join Group'; ?>">
                    </a>
                <?php endif; ?>
            </span>
            <br>
            <br>
            <div class="name">
                <?= $group['group_name']; ?>
            </div>
            <br>
            <div class="profile_set">
                <div class="menu_buttons">
                    <a href="timeline.php">Timeline</a>
                </div>
                <div class="menu_buttons">
                    <a href="../supbage/about_group.php?ID=<?= $_GET['ID']; ?>">About</a>
                </div>
                <div class="menu_buttons">
                    <a href="../supbage/group_members.php?ID=<?= $_GET['ID']; ?>">Members</a>
                </div>
                <div class="menu_buttons">
                    <a href="../supbage/group_photos.php?ID=<?= $_GET['ID']; ?>">Photos</a>
                </div>
                <?php if ($group["owner_id"] == $_SESSION['mrbook_userid']): ?>
                    <div class="menu_buttons">
                        <a href="group_sitting.php?ID=<?= $group['id']; ?>">Setting</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="post">
            <div class="post_pox">
                <?php 
                if($groups->is_user_ingroup($_SESSION['mrbook_userid'], $group["id"]) || $_SESSION['mrbook_userid']==$group['owner_id'] ){
                    echo '
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="post-inputs">
                            <textarea name="post_content" class="post_textarea" placeholder="What\'s on your mind"></textarea>
                            <input type="file" name="file" id="file" class="file" onchange="previewImage(event)">
                            <label for="file" class="file-label">Choose Image</label>
                        </div>
                        <img id="image-preview" class="image-preview" src="#" alt="Image Preview" style="display: none;">
                        <input type="submit" class="post_button" value="Post">
                    </form>';
                }
                ?>
            </div>
            
            <div class="posts_bar">
                <?php 
                if ($posts) {
                    foreach ($posts as $post) {
                        $user = new User();
                        $user_data_post = $user->get_user_data_post($post["user_id"]);
                        include ("../supbage/group_posts.php");
                    }   
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('image-preview');
                output.src = dataURL;
                output.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
</body>
</html>
