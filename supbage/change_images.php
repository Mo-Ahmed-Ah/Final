<?php

if (isset($_GET['change'])){
    if ($_GET["change"] == "profile"){
        header("Location: ../pages/change_profile_image.php");
        die;
    }elseif($_GET["change"]== "Group_image"){
        header("Location: ../pages/change_cover_image.php?type=group&ID=$_GET[ID]");
        die;
    }else{
        header("Location: ../pages/change_cover_image.php");
        die;
    }
}else{
    header("Location: profile.php");
    die;
}