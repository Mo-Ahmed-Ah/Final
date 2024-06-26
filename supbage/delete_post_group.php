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
            echo $user_data_post['first_name'] . " " . $user_data_post['last_name'];

            if($post['is_cover_image']){
                $pronoun = "his";
                if($user_data_post["gender"]=="Female"){
                    $pronoun = "her";
                }
                echo "<span class='updated_profile_and_cover_post'> updated $pronoun cover image </span>";
                
            }
            ?>
        </div>
        <?php
            echo $post['post'] ;
        ?>
        <br><br>

        <?php
        if (file_exists($post['image'])){
            $post_image = $image_class->get_thumb_post($post['image']);
            echo "<img src='$post_image' class='post_image'";
        }
        ?>
        
    </div>
</div>