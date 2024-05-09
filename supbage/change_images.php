<?php 
if (isset($_GET['change'])){
    if ($_GET["change"] == "profile"){
        header("Location: ../pages/change_profile_image.php");
        die;
    }else{
        header("Location: ../pages/change_cover_image.php");
        die;
    }
}else{
    header("Location: profile.php");
    die;
}