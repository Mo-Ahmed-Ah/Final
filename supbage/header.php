
<?php
    if(isset($_GET['ID'])){
        $user_class = new User();
        $user_data=$user_class->get_data($_GET['ID']);   
        $ch_image= new Check_Images();
        $image = $ch_image->is_user_have_image($user_data['profile_image'],$user_data['gender']);
    }else{

        $ch_image= new Check_Images();
        $login = new Login();
        $user_data=$login->check_login($_SESSION['mrbook_userid']);
        $image = $ch_image->is_user_have_image($user_data['profile_image'],$user_data['gender']);
    }
?>
<link rel="stylesheet" href="../style/header.css">

<div class="blue_bar">
    <div class="mrbook_pro">
        <a href="../pages/timeline.php" class="timeline">
            MrBook
        </a>
        <input type="text" class="search_box" placeholder="Search for people">
        <a href="../pages/profile.php">
            <img src=<?=$image;?> alt="" class="mine_pro_img">
        </a>
        <a href="../pages/logout.php" class="logout">
            <span>
                Logout
            </span>
        </a>
    </div>
</div>