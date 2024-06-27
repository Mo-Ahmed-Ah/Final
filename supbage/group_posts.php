<?php
    $html_filter = new Flter();
    $post_ch = new Post();
    $groups = new Group;
    $group = $groups->show_one_group($_GET['ID']);
    $image_class = new Image();
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
            echo "<img src='$post_image' class='post_image'>";
        }
        ?>
        <br><br>
        <div class="post_data">
            <div class="like_numbers">
                <a href="../supbage/like.php?type=post_group&id=<?=$post['id']?>" class="like">
                    Like
                </a> 
                <span class="like_number"><?=$post['likes'] ;?></span>
            </div>
            <div class="comment_numbers">
                <a href="../supbage/comment.php?post_id=<?=$post['id']?>" class="comment">
                    Comment
                </a> 
                <span class="comment_number"><?=$post['comments'] ;?></span>
            </div>
            <span class="post_date">
                <?php 
                if($post['create_at'] == $post['update_at']){
                    $date = $post['create_at'];
                }else{
                    $date = $post['update_at'];

                }
                    echo $date ;
                ?>
            </span>
            <?php 
                $check_post = $groups->check_user_access_post($_SESSION["mrbook_userid"],$group['owner_id'],$post['user_id']);
                if($check_post){
                    if($post['user_id']==$_SESSION["mrbook_userid"]){
                        echo "<span>
                            <a href='../supbage/edit_group_post.php?ID=$post[id]' class='post_edit_and_delete'> 
                                Edit
                            </a>
                            <a href='../pages/delete_group_post.php?ID=$post[id]' class='post_edit_and_delete'> 
                                Delete
                            </a>";
                    }elseif($group['owner_id'] == $_SESSION["mrbook_userid"]){
                        echo "<span>
                            <a href='../pages/delete_group_post.php?ID=$post[id]' class='post_edit_and_delete'> 
                                Delete
                            </a>";
                    }
                        
                }
                echo "</span>";
            
            ?>

        </div>
    </div>
</div>
