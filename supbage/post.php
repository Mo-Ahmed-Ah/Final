<?php
    $html_filter = new Flter();
    $post_ch = new Post();
    $ch_image= new Check_Images();
    $image = $ch_image->is_user_have_image($user_data_post['profile_image'],$user_data_post['gender']);

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
            <div class="like_numbers">
                <a href="../supbage/like.php?type=posts&id=<?=$post['post_id']?>" class="like">
                    Like
                </a> 
                <span class="like_number"><?=$post['likes'] ;?></span>
            </div>
            <div class="comment_numbers">
                <a href="../supbage/comment.php?post_id=<?=$post['post_id']?>" class="comment">
                    Comment
                </a> 
                <span class="comment_number"><?=$post['comments'] ;?></span>
            </div>
            <span class="post_date">
                <?php 
                    echo $post['date'] ;
                ?>
            </span>
            <?php 
                if($post_ch->i_own_post($post['post_id'],$_SESSION["mrbook_userid"])){

                    echo "<span>
                        <a href='../pages/edit.php?ID=$post[post_id]' class='post_edit_and_delete'> 
                            Edit
                        </a>
                        <a href='../pages/delete.php?ID=$post[post_id]' class='post_edit_and_delete'> 
                            Delete
                        </a>";
                        
                }
                echo "</span>";
            
            ?>

        </div>
    </div>
</div>
