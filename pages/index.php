<?php 
    include ("../clsses/Connect.php");
    include ("../clsses/Login.php");
    include ("../clsses/User.php");
    include ("../clsses/Post.php");
    session_start();

    // isset($_SESSION['mrbook_userid']);
    $login = new Login();
    $user_data=$login->check_login($_SESSION['mrbook_userid']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile | MrBook</title>
    <link rel="stylesheet" href="../style/signup.css">
        <link rel="stylesheet" href="../style/link.css">

</head>

<body>
    <!-- top profile bar -->
    <?php
        include ("../supbage/header.php");
        ?>
    <!-- cover area -->
    <div class="cover_div">
        
        <!-- below cover area -->
        <div class="profile_content profile_content_timeline">
            <!-- friedns area -->
            <div class="friedns">
                <div class="friedns_bar friedns_bar_timeline">
                    <img src="../assets/selfie.jpg" alt="" class="cover_smal_img cover_smal_img_timeline">
                    <br>

                    <a href="profile.php" class="timeline_pro">
                        <?php
                        echo $user_data['first_name'] . " " . $user_data["last_name"]
                        ?>
                    </a> 

                </div>
            </div>
            <!-- post area -->
            <div class="post">
                <div class="post_pox">
                    <textarea name="" class="post_textarea" placeholder="Whats on your mind"></textarea>
                    <br>
                    <input type="submit" class="post_button" value="post">
                    <br>
                </div>

                <!-- posts -->
                <div class="posts_bar">
                    <!-- post 1 -->
                    <div class="posts">
                        <div>
                            <img src="../assets/user1.jpg" alt="" class="post_img">
                        </div>
                        <div>
                            <div class="post_num"> First guy</div>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Nostrum molestias unde blanditiis aliquam in magni hic nulla tempore
                            obcaecati voluptates non laboriosam omnis
                            excepturi ipsum dolores dolore ducimus, iste voluptas?
                            <br><br>
                            <a href="">Like</a> . <a href="">comment</a> . <span class="post_data">April 23 2020</span>

                        </div>
                    </div>
                    <div class="posts">
                        <div>
                            <img src="../assets/user2.jpg" alt="" class="post_img">
                        </div>
                        <div>
                            <div class="post_num"> First guy</div>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Nostrum molestias unde blanditiis aliquam in magni hic nulla tempore
                            obcaecati voluptates non laboriosam omnis
                            excepturi ipsum dolores dolore ducimus, iste voluptas?
                            <br><br>
                            <a href="">Like</a> . <a href="">comment</a> . <span class="post_data">April 23 2020</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>