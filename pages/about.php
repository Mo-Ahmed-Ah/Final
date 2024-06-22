<?php

    include_once("../classes/autoloder.php");
    $user = new Profile();

    $ch_image= new Check_Images();
    $image_class = new Image();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/about.css">
        <title>
            About | MrBook
        </title>
    </head>
    <body>
        <?php include_once ("../supbage/header.php");?>
        <div class="about">
            <div class="about_bar">
                <h2>About</h2><br>
                <?php
                    $user_data = $user->get_profile($_GET['user_id']);
                    $user_data = $user_data[0];
                    $image = $ch_image->is_user_have_image($user_data['profile_image'],$user_data['gender']);
                    $image_cover = "../assets/mountain.jpg";
                    if(file_exists($user_data['cover_image'])){
                        $image_cover = $image_class ->get_thumb_cover($user_data['cover_image']) ;
                    }
                ?>
                
                <div class="images">
                    <img src="<?=$image_cover?>" alt="" class="cover_image">
                    <img src="<?=$image?>" alt="" class="profile_image">
                </div>
                <div class="data_contener">
                    <h3>User Name : </h3>
                    <h4>
                        <?=$user_data['first_name'] . " " . $user_data['last_name']?>
                    </h4>
                </div>
                <div class="data_contener">
                    <h3>Gender : </h3>
                    <h4>
                        <?=$user_data['gender']?>
                    </h4>
                </div>
                <div class="data_contener">
                    <h3>Email : </h3>
                    <h4>
                        <?=$user_data['email']?>
                    </h4>
                </div>
                <?php
                    if ($user_data['phone']!= null){
                        $phone = strval($user_data['phone']);
                        echo "<div class='data_contener'>
                        <h3>Phone : </h3>
                        <h4>
                            $phone
                        </h4>
                        </div>";
                    }else{
                        echo "<div class='data_contener'>
                        <h3>Phone : </h3>
                        <h4>
                        hasn't phone
                        </h4>
                        </div>";
                    }
                ?>
                <div class="data_contener">
                    <h3>Number of follwers : </h3>
                    <h4>
                        <?=$user_data['follwers']?>
                    </h4>
                </div>
                <div class="data_contener">
                    <h3>User Link : </h3>
                    <h4>
                        <?=$user_data['url_address']?>
                    </h4>
                </div>
                <div class="data_contener">
                    <h3>Update in : </h3>
                    <h4>
                        <?=$user_data['updated_at']?>
                    </h4>
                </div>
                <div class="data_contener">
                    <h3>Create in : </h3>
                    <h4>
                        <?=$user_data['created_at']?>
                    </h4>
                </div>
            </div>
        </div>
    </body>
</html>