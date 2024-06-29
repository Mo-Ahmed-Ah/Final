<?php
    $ch_image= new Check_Images();
    $image = $ch_image->is_user_have_image($friend['profile_image'],$friend['gender']);
?>

<link rel="stylesheet" href="../style/user.css">

<div class="friend">

    <a href="../pages/profile.php?ID=<?=$friend['user_id'];?>" class='friend_link' >
        <img src="<?php echo $image ?>" alt="" class="friedns_img"><br>
        <?php echo $friend['first_name'] . " " . $friend['last_name']; ?>
    </a>
    
</div>