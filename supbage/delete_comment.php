<?php
    $html_filter = new Flter();
    $image = "";
    $image_class = new Image();
    if(file_exists($user_data['profile_image'])){
        $image = $image_class->get_thumb_profile($user_data['profile_image']);
    }else{
        if ($user_data_post['gender'] == "Male"){
            $image = "../assets/user_male.jpg";
        }else{
            $image = "../assets/user_female.jpg";
        }
    }
?>
<link rel="stylesheet" href="../style/post.css">
<div class="posts">
    <div>
        <img src="<?php echo $image ?>" alt="" class="post_img">
    </div>
    <div class="post_conten">
        <div class="post_num"> 
            <?php 
            echo $html_filter->html_filter($user_data_post['first_name']) . " " . $html_filter->html_filter($user_data_post['last_name']);
            ?>
        </div>
        <?php
            echo $coment['comment_content'] ;
        ?>
        <br><br>

        
    </div>
</div>