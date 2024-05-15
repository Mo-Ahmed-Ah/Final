<?php

    include_once("../classes/autoloder.php");

    // isset($_SESSION['mrbook_userid']);
    $login = new Login();
    $user_data=$login->check_login($_SESSION['mrbook_userid']);

    if(isset($_GET['ID']) && is_numeric($_GET['ID'])){

        $profile = new Profile();
        $profile_data=$profile->get_profile($_GET["ID"]);
        if(is_array($profile_data) ){
            $user_data = $profile_data[0];
        }
    }


    //posting starts here
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_SESSION['mrbook_userid'];
        $post = new Post();
        $result = $post->create_post($id,$_POST,$_FILES);
        if ($result == "") {
            header("Location: profile.php");
            die;
        }else{
            echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
            echo $result;
            echo "</div>";
        }
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile | MrBook</title>
    <link rel="stylesheet" href="../style/signup.css">
    <link rel="stylesheet" href="../style/profile.css">
    <link rel="stylesheet" href="../style/link.css">
    <link rel="stylesheet" href="../style/post.css">  
    <link rel="stylesheet" href="../style/user.css">
    <link rel="stylesheet" href="../style/timeline.css">
    
</head>

<body>
    <!-- top profile bar -->
        <?php
        include ("../supbage/header.php");
        ?>

    <!-- cover area -->
    <div class="cover_div">
        <div class="cover_img">
            <?php
                $image_cover = "../assets/mountain.jpg";
                if(file_exists($user_data['cover_image'])){
                    
                    $image_cover = $image_class ->get_thumb_cover($user_data['cover_image']) ;
                }
            ?>
            <img src=<?= $image_cover;?> alt="" class="cover_cover_img">
            <span class="profile_image" >
                <?php
                $image = '../assets/user_male.jpg';
                if($user_data['gender'] == "Female"){
                    
                    $image = '../assets/user_female.jpg';
                }
                if(file_exists( $user_data['profile_image'])){
                    $image = $image_class ->get_thumb_profile($user_data['profile_image']);
                }
                ?>
                <img src=<?= $image;?> alt="" class="cover_smal_img">
                <br>
                <a href="../supbage/change_images.php?change=profile" class="change_image">
                    change image
                </a>
                |
                <a href="../supbage/change_images.php?change=cover" class="change_image">
                    change cover
                </a>

            </span>
            <br>
            <div class="name">
                <?php echo $user_data['first_name'] . " " . $user_data['last_name']?>
            </div>
            <br>

            <div class="menu_buttons">
                <a href="index.php" class="timeline">
                    Timeline
                </a>
            </div>
            <div class="menu_buttons">About</div>
            <div class="menu_buttons">Friedns </div>
            <div class="menu_buttons">Phontos </div>
            <div class="menu_buttons">Settings</div>
        </div>
        <!-- below cover area -->
        <div class="profile_content">
            <!-- friedns area -->
            <div class="friedns">
                <div class="friedns_bar">
                    friends<br>
                    <?php 
                    if($friends){
                        foreach ($friends as $friend) {
                            include ("../supbage/users.php");
                        }      
                    }
                    ?>
                    
                </div>
            </div>
            <!-- post area -->
            <div class="post">
                <div class="post_pox">
                    <!-- post form add post  -->
                    <form action="profile.php" method='post' enctype="multipart/form-data">
                        <textarea name="post_content" class="post_textarea" placeholder="Whats on your mind"></textarea>
                        <br>
                        <input type="file" name="file">
                        <br>
                        <input type="submit" class="post_button" value="post">
                        <br>
                    </form>
                </div>

                <!-- posts -->
                <div class="posts_bar">
                    
                    <?php 
                    if($posts){
                        foreach ($posts as $post) {
                            $user = new User();
                            $user_data_post= $user->get_user_data_post($post["user_id"]);
                            include ("../supbage/post.php");
                        }
                    }
                        
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
