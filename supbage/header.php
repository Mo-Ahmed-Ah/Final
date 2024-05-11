<div class="blue_bar">
    <div class="mrbook_pro">
        <?php
            $image = '../assets/user_male.jpg';
            if($user_data['gender'] == "Female"){
                
                $image = '../assets/user_female.jpg';
            }
            if(file_exists( $user_data['profile_image'])){
                $image_class = new Image;
                $image = $image_class ->get_thumb_profile($user_data['profile_image']);
            }
        ?>
        <a href="index.php" class="timeline">
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