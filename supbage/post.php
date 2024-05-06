<?php
$image = "";
if ($user_data_post['gender'] == "Male"){
    $image = "../assets/user_male.jpg";
}else{
    $image = "../assets/user_female.jpg";
}
?>
<div class="posts">
    <div>
        <img src="<?php echo $image ?>" alt="" class="post_img">
    </div>
    <div>
        <div class="post_num"> 
            <?php 
            echo $user_data_post['first_name'] . " " . $user_data_post['last_name'];
            ?>
        </div>
        <?php
            echo $post['post'] ;
        ?>
        <br><br>
        <a href="">Like</a> . <a href="">comment</a> . 
        <span class="post_data">
            <?php 
                echo $post['date'] ;
            ?>
        </span>
            
    </div>
</div>