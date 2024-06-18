<?php 
    
    include("../classes/autoloder.php");
    $_SESSION["page"] = "timeline";
    $ch_image= new Check_Images();

    // isset($_SESSION['mrbook_userid']);
    $login = new Login();
    $user_data=$login->check_login($_SESSION['mrbook_userid']);
    
    $image_class = new Image();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_SESSION['mrbook_userid'];
        $post = new Post();
        $result = $post->create_post($id,$_POST,$_FILES);
        if ($result == "") {
            header("Location: timeline.php");
            die;
        }else{
            echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
            echo $result;
            echo "</div>";
        }
    }


    // collect posts
    $post = new Post();
    $posts = $post->get_all_post();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile | MrBook</title>
    <link rel="stylesheet" href="../style/timeline.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <!-- top profile bar -->
    <?php
        include ("../supbage/header.php");
        ?>
    <div class="cover_div_timeline">
        <!-- cover area -->
        <div class="friedns">
            <div class="friedns_bar_timeline">
                <a href="profile.php" class="timeline_pro">
                    <img src=<?= $image;?> alt="" class="cover_smal_img_timeline">
                    <br>
                    <?php
                    echo $user_data['first_name'] . " " . $user_data["last_name"]
                    ?>
                </a> 
            </div>
            <div class="post_pox">
                <!-- post form add post  -->
                <form action="timeline.php" method='post' enctype="multipart/form-data">
                    <div class="post-inputs">
                        <textarea name="post_content" class="post_textarea" placeholder="What's on your mind"></textarea>
                        <input type="file" name="file" id="file" class="file">
                        <label for="file" class="file-label">Choose Image</label>
                    </div>
                    <input type="submit" class="post_button" value="Post">  
                </form>
            </div>
        </div>

    </div> 
        
    <div class="profile_content_timeline">
        <!-- post area -->
    
        <div class="post_timeline">

            <!-- posts -->
            <div class="posts_bar_timeline">
                <?php
                    if($posts){
                        foreach ($posts as $post) {
                            $user = new User();
                            $user_data_post= $user->get_user_data_post($post["user_id"]);
                            $image = $ch_image->is_user_have_image($user_data_post['profile_image'],$user_data['gender']);
                            include ("../supbage/post.php");
                        }
                    }
                ?>
                
            </div>
        </div>
    </div>
</body>

</html>