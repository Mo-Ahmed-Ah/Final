<?php 
    include("../classes/autoloder.php");
    

    // isset($_SESSION['mrbook_userid']);
    $login = new Login();
    $user_data=$login->check_login($_SESSION['mrbook_userid']);

    $image_class = new Image();
    $image = "";
    if(file_exists($user_data['profile_image'])){
        $image = $image_class ->get_thumb_profile($user_data['profile_image']);
    }else{
        if ($user_data_post['gender'] == "Male"){
            $image = "../assets/user_male.jpg";
        }else{
            $image = "../assets/user_female.jpg";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile | MrBook</title>
    <link rel="stylesheet" href="../style/signup.css">
        <link rel="stylesheet" href="../style/link.css">
        <link rel="stylesheet" href="../style/post.css">
        <link rel="stylesheet" href="../style/timeline.css">


</head>

<body>
    <!-- top profile bar -->
    <?php
        include ("../supbage/header.php");
        ?>
    <!-- cover area -->
    <div class="cover_div_timeline">
        
        <!-- below cover area -->
        <div class="profile_content_timeline">
            <!-- friedns area -->
            <div class="friedns">
                <div class="friedns_bar friedns_bar_timeline">
                    <img src=<?= $image;?> alt="" class="cover_smal_img_timeline">
                    <br>

                    <a href="profile.php" class="timeline_pro">
                        <?php
                        echo $user_data['first_name'] . " " . $user_data["last_name"]
                        ?>
                    </a> 

                </div>
            </div>
            <!-- post area -->
            <div class="post_timeline">
                <div class="post_pox_timeline">
                    <textarea name="" class="post_textarea_timeline" placeholder="Whats on your mind"></textarea>
                    <br>
                    <input type="submit" class="post_button_timeline" value="post">
                    <br>
                </div>

                <!-- posts -->
                <div class="posts_bar_timeline">
                    <!-- post 1 -->
                    <div class="posts_timeline">
                        <div>
                            <img src="../assets/user1.jpg" alt="" class="post_img_timeline">
                        </div>
                        <div>
                            <div class="post_num_timeline"> First guy</div>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Nostrum molestias unde blanditiis aliquam in magni hic nulla tempore
                            obcaecati voluptates non laboriosam omnis
                            excepturi ipsum dolores dolore ducimus, iste voluptas?
                            <br><br>
                            <a href="">Like</a> . <a href="">comment</a> . <span class="post_data_timeline">April 23 2020</span>

                        </div>
                    </div>
                    <div class="posts_timeline">
                        <div>
                            <img src="../assets/user2.jpg" alt="" class="post_img_timeline">
                        </div>
                        <div>
                            <div class="post_num_timeline"> First guy</div>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Nostrum molestias unde blanditiis aliquam in magni hic nulla tempore
                            obcaecati voluptates non laboriosam omnis
                            excepturi ipsum dolores dolore ducimus, iste voluptas?
                            <br><br>
                            <a href="">Like</a> . <a href="">comment</a> . <span class="post_data_timeline">April 23 2020</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>