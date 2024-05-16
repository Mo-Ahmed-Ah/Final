<?php
    $image = "";
    if (file_exists($friend['profile_image'])) {
        $image = $image_class->get_thumb_profile($friend['profile_image']);
    }else{
        if ($friend['gender'] == "Male"){
            $image = "../assets/user_male.jpg";
        }else{
            $image = "../assets/user_female.jpg";
        }
    }

?>

<link rel="stylesheet" href="../style/user.css">

<div class="friend">
    <a href="../pages/profile.php?ID=<?=$friend['user_id'];?>" class='friend_link' >

        <img src="<?php echo $image ?>" alt="" class="friedns_img"><br>
        <?php echo $friend['first_name'] . " " . $friend['last_name']; ?>
    </a>
</div>