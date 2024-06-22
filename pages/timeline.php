<?php
    include("../classes/autoloder.php");
    $id = $_SESSION['mrbook_userid'];
    $_SESSION["page"] = "timeline";
    $ch_image= new Check_Images();
    
    $login = new Login();
    $user_data=$login->check_login($_SESSION['mrbook_userid']);
    
    $image_class = new Image();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $post = new Post();
        $post->create_post($id,$_POST,$_FILES);
        header("Location: timeline.php");
        die;
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
                    if($post){
                        if($posts){
                            foreach ($posts as $post) {
                                $user = new User();
                                $user_data_post= $user->get_user_data_post($post["user_id"]);
                                include ("../supbage/post.php");
                            }
                        }
                    }
                ?>
                
            </div>
        </div>
    </div>
</body>

</html>