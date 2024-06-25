<?php
    $ch_image= new Check_Images();
    $image = $ch_image->is_group_have_image($go['image']);
?>

<link rel="stylesheet" href="../style/user.css">

<div class="friend">
    
    <a href="../pages/group_profile.php?ID=<?=$go['id'];?>" class='friend_link' >
        <img src="<?php echo $image ?>" alt="" class="friedns_img"><br>
        <?php echo $go['group_name'] ; ?>
    </a>
    
</div>