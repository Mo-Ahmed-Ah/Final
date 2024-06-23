<?php 
    include_once("../classes/autoloder.php");
    $_SESSION["page"] = "profile";
    $group = new Group();
    $groups = $group->show_all_group();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile | MrBook</title>
    <link rel="stylesheet" href="../style/profile.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <!-- top profile bar -->
    <?php include_once ("../supbage/header.php"); ?>

    <?php
        $login = new Login();
        $user_data = $login->check_login($_SESSION['mrbook_userid']);
        $USER = $user_data;
        
        if (isset($_GET['ID']) && is_numeric($_GET['ID'])) {
            $profile = new Profile();
            $profile_data = $profile->get_profile($_GET["ID"]);
            $profile_data = $profile_data[0];
            
            if (is_array($profile_data)) {
                $user_data = $profile_data;
            }
        }

        // posting starts here
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_SESSION['mrbook_userid'];
            $post = new Post();
            $post->create_post($id, $_POST, $_FILES);
            
            header("Location: profile.php");
            die;
        }

        // collect posts
        $id = $user_data['user_id'];
        $post = new Post();
        $posts = $post->get_post($id);

        // collect friends
        $user = new User();
        $friends = $user->get_friends_data($id);

        $image_class = new Image();
    ?>

    <!-- cover area -->
    <div class="cover_div">
        <div class="cover_img">
            <?php
                $image_cover = "../assets/mountain.jpg";
                if (file_exists($user_data['cover_image'])) {
                    $image_cover = $image_class->get_thumb_cover($user_data['cover_image']);
                }
            ?>
            <img src=<?= $image_cover; ?> alt="" class="cover_cover_img">
            
            <span class="profile_image">
                <?php
                    $ch_image = new Check_Images();
                    $image = $ch_image->is_user_have_image($user_data['profile_image'], $user_data['gender']);
                ?>
                <img src=<?= $image; ?> alt="" class="cover_smal_img">
                <br>
                <?php 
                if ($user_data["user_id"] == $_SESSION['mrbook_userid']) {
                    echo "
                    <div class='chabge'>
                        <a href='../supbage/change_images.php?change=profile' class='change_image'>
                            change image
                        </a>
                        <a href='../supbage/change_images.php?change=cover' class='change_image'>
                            change cover
                        </a>
                    </div>";
                } else {
                    $user_id = $user_data['user_id'];
                    $user = new User();
                    $follwer_user = $user->is_follwer_user($user_id, $_SESSION['mrbook_userid']);
                    if ($follwer_user == false) {
                        echo "  <a href='../supbage/like.php?type=follwers&id=$user_id'>
                                    <input type='submit' class='folow_button' value='Add Friends'>
                                </a>";
                    } else {
                        echo "  <a href='../supbage/like.php?type=follwers&id=$user_id'>
                                    <input type='submit' class='Frindes_button' value='Friends'>
                                </a>";
                    }
                }
                ?>
            </span>
            <br>
            <div class="name">
                <?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?>
            </div>
            <br>
            <!-- profile_set -->
            <div class="profile_set">
                <div class="menu_buttons">
                    <a href="timeline.php">Timeline</a>
                </div>
                <div class="menu_buttons">
                    <a href="about.php?user_id=<?= $id ?>">About</a>
                </div>
                <div class="menu_buttons">
                    <?php 
                        if (isset($_GET["ID"])) {
                            $ID = $_GET['ID'];
                            echo "<a href='friedns.php?ID=$ID'>Friends</a>";
                        } else {
                            echo "<a href='friedns.php'>Friends</a>";
                        }
                    ?>
                </div>
                <div class="menu_buttons">
                    <a href="photos.php?ID=<?= $id ?>">Photos</a>
                </div>
                <?php
                if ($user_data["user_id"] == $_SESSION['mrbook_userid']) {
                    echo "<div class='menu_buttons'>
                            <a href='../supbage/create_group.php'>Create group</a>
                        </div>";
                    echo "<div class='menu_buttons'>
                            <a href='setting.php'>Setting</a>
                        </div>";
                }
                ?>
            </div>
        </div>
        <!-- below cover area -->
        <div class="profile_content">
            <!-- friends area -->
            <div class="friedns">
                <div class="friedns_bar">
                    <div class="Frindes_par">Users</div><br>
                    <?php 
                    if ($friends) {
                        foreach ($friends as $friend) {
                            include ("../supbage/users.php");
                        }
                    }
                    ?>
                </div>
                <div class="friedns_bar">
                    <div class="Frindes_par">Groups</div><br>
                    <?php 
                    if ($groups) {
                        foreach ($groups as $go) {
                            include ("../supbage/groups.php");
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- post area -->
            <div class="post">
                <div class="post_pox">
                    <!-- post form add post  -->
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <div class="post-inputs">
                            <textarea name="post_content" class="post_textarea" placeholder="What's on your mind"></textarea>
                            <input type="file" name="file" id="file" class="file" onchange="previewImage(event)">
                            <label for="file" class="file-label">Choose Image</label>
                        </div>
                        <img id="image-preview" class="image-preview" src="#" alt="Image Preview" style="display: none;">
                        <input type="submit" class="post_button" value="Post">
                    </form>
                </div>
                <!-- posts -->
                <div class="posts_bar">
                    <?php 
                    if ($posts) {
                        foreach ($posts as $post) {
                            $user = new User();
                            $user_data_post = $user->get_user_data_post($post["user_id"]);
                            include ("../supbage/post.php");
                        }
                    }
                    ?>
                </div>
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
