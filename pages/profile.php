<?php 
    include ("../clsses/Connect.php");
    include ("../clsses/Login.php");
    include ("../clsses/User.php");
    include ("../clsses/Post.php");
    session_start();

    // isset($_SESSION['mrbook_userid']);
    $login = new Login();
    $user_data=$login->check_login($_SESSION['mrbook_userid']);
    //posting starts here
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_SESSION['mrbook_userid'];
        $post = new Post();
        $result = $post->create_post($id,$_POST);
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
    $id = $_SESSION['mrbook_userid'];
    $post = new Post();
    $posts = $post->get_post($id);

    // collect friends
    $id = $_SESSION['mrbook_userid'];
    $user = new User();
    $friends = $user->get_friends_data($id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile | MrBook</title>
    <link rel="stylesheet" href="../style/signup.css">
</head>

<body>
    <!-- top profile bar -->
    <div class="blue_bar">
        <div class="mrbook_pro">
            MrBook
            <input type="text" class="search_box" placeholder="Search for people">
            <img src="../assets/selfie.jpg" alt="" class="mine_pro_img">
            <a href="logout.php" class="logout">
                <span>
                    Logout
                </span>
            </a>
        </div>
    </div>
    <!-- cover area -->
    <div class="cover_div">
        <div class="cover_img">
            <img src="../assets/mountain.jpg" alt="" class="cover_cover_img">

            <img src="../assets/selfie.jpg" alt="" class="cover_smal_img">
            <br>
            <div class="name">
                <?php echo $user_data['first_name'] . " " . $user_data['last_name']?>
            </div>
            <br>

            <div class="menu_buttons">
                <a href="index.php">
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
                    <form action="profile.php" method='post'>
                        <textarea name="post_content" class="post_textarea" placeholder="Whats on your mind"></textarea>
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
