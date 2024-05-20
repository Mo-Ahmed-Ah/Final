<link rel="stylesheet" href="../style/header.css">
<div class="blue_bar">
    <div class="mrbook_pro">
        <?php
            $login = new Login();
            $user_data=$login->check_login($_SESSION['mrbook_userid']);
            $USER = $user_data;
            $image = '../assets/user_male.jpg';
        
            if($user_data['gender'] == "Female"){

                
                $image = '../assets/user_female.jpg';
            }
            if(isset($USER)){
                if (file_exists($USER['profile_image'])){
                    $image_class = new Image;
                    $image = $image_class ->get_thumb_profile($USER['profile_image']);
                }else{
                    if($USER['gender']=="Female"){
                        $image = "../assets/user_female.jpg";
                    }
                }
            }
        ?>
        <a href="timeline.php" class="timeline">
            MrBook
        </a>
        <input type="text" class="search_box" placeholder="Search for people">
        <a href="../pages/profile.php">
            <img src=<?=$image;?> alt="" class="mine_pro_img">
        </a>
        <a href="logout.php" class="logout">
            <span>
                Logout
            </span>
        </a>
    </div>
</div>