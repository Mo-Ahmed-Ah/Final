
<?php
    $comment_id = $comment['id'];
    $post_id = $comment['post_id'];
?>
<div class="post_comment_array">
    <div class="image_text">
        <a href="../pages/profile.php?ID=<?=$user_data_post['user_id'];?>" class="user_post_link">
            <img src="<?php echo $image?>" class="comment_image">
        </a>
        <div class="comment_user">
            <div class="user_name"><?php echo $user_data_post['first_name']." " . $user_data_post['last_name']?></div>
            <div class="comment_text_area"> <?php echo $comment["comment_content"]; ?></div>
        </div>
    </div>
    <div class="comment_setting">
    <div class="like_comment">
        <a href="../supbage/like.php?type=comments&id=<?=$comment_id?>" class="like">like</a>
        <span class="like_number_comment"><?=$comment['likes']?></span>
    </div>
    <?php
    if($_SESSION['mrbook_userid']==$comment['user_id']){
        echo "<a class='Edit_comment like' href='../pages/edit_comment.php?ID=$comment_id&post_id=$post_id'>Edit</a>
                <a class='Delete_comment like' href='../pages/delete_comment.php?ID=$comment_id&post_id=$post_id'>Delete</a>"; 
    }
    ?>
</div>


</div> 