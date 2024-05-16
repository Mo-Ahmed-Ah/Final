<?php
    $html_filter = new Flter();
    $image = "";
    if(file_exists($user_data['profile_image'])){
        $image = $image_class ->get_thumb_profile($user_data['profile_image']);
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
    <div class="post_content">
        <div class="post_num"> 
            <?php 
            echo $html_filter->html_filter($user_data_post['first_name']) . " " . $html_filter->html_filter($user_data_post['last_name']);

            if($post['is_profile_image']){
                $pronoun = "his";
                if($user_data_post["gender"]=="Female"){
                    $pronoun = "her";
                }
                echo "<span class='updated_profile_and_cover_post'> updated $pronoun profile image </span>";
            }
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
            echo "<img src='$post_image' class='post_image'>";
        }
        ?>
        <br><br>
        <div class="post_data">
            <a href="#" class="like">
                Like
            </a> 
            <a href="#" class="comment">
                Comment
            </a> 
            <span class="post_date">
                <?php 
                    echo $post['date'] ;
                ?>
            </span>
            <span class="post_edit_and_delete">
                <a href="../pages/edit.php"> 
                    Edit
                </a>
                <a href="../pages/delete.php?ID=<?=$post['post_id']?>"> 
                    Delete
                </a>
            </span>
        </div>
    </div>
</div>
