<?php
$image = "";
if ($friend['gender'] == "Male"){
    $image = "../assets/user_male.jpg";
}else{
    $image = "../assets/user_female.jpg";
}
?>

<div class="friedn">
    <img src="<?php echo $image ?>" alt="" class="friedns_img"><br>
    <?php 
    echo $friend['first_name'] . " " . $friend['last_name']; 
    ?>
</div>