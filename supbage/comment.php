<?php
    include ("../classes/autoloder.php");
    $login = new Login();
    $user_data = $login->check_login($_SESSION['mrbook_userid']);

    $ch_image = new Check_Images();
    $html_filter = new Flter();
    $user = new User();
    $post_s = new Post();
    $post_id = $_GET['post_id'];
    $user_id = $_SESSION["mrbook_userid"];
    $image_class = new Image();

    $post = $post_s->get_one_post($post_id);
    if(isset($_SERVER['HTTP_REFERER'])){
        $referrer = $_SERVER['HTTP_REFERER'];
    } else {
        echo "<script>
                alert('Dont play with me!');
                setTimeout(function() {
                    window.location.href = 'logout.php';
                }, 1); 
            </script>";
        exit(); 
    }


    if (!$post) {
        echo "<script>
                alert('Post not found.');
                window.location.href = '$referrer';
            </script>";
        exit();
    }

    $user_data_post = $user->get_user_data_post($post['user_id']);
    if (!$user_data_post) {
        echo "<script>
                alert('User not found.');
                window.location.href = '$referrer';
            </script>";
        exit();
    }

    $comments = new Comment();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_content'])) {
        $comment_content = $_POST['comment_content'];
        if (!empty($comment_content)) {
            $comments->add_comment($post_id, $comment_content);
        }
        // Redirect to the same page to prevent form resubmission
        header("Location: comment.php?post_id=$post_id");
        exit;
    }

    $comments_n = $comments->get_comments($post_id);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/comment.css">
    <title>Comment | MrBook</title>
</head>
<body>
    <?php include_once("header.php"); ?>
    <div class="post_class">
        <div class="post">
            <?php 
                $image = $ch_image->is_user_have_image($user_data_post['profile_image'], $user_data_post['gender']);
            ?>
            <div>
                <img src="<?php echo $image; ?>" alt="" class="post_img">
            </div>
            <div class="post_content">
                <div class="post_num"> 
                    <?php 
                        echo $user_data_post['first_name'] . " " . $user_data_post['last_name'];

                        if ($post['is_profile_image']) {
                            $pronoun = ($user_data_post["gender"] == "Female") ? "her" : "his";
                            echo "<span class='updated_profile_and_cover_post'> updated $pronoun profile image </span>";
                        }
                        if ($post['is_cover_image']) {
                            $pronoun = ($user_data_post["gender"] == "Female") ? "her" : "his";
                            echo "<span class='updated_profile_and_cover_post'> updated $pronoun cover image </span>";
                        }
                    ?>
                </div>
                <?php echo $post['post']; ?>
                <br><br>
                <?php
                if (file_exists($post['image'])) {
                    $post_image = $image_class->get_thumb_post($post['image']);
                    echo "<img src='" . $post_image . "' class='post_image'>";
                }
                ?>
                <br><br>
                <div class="post_data">
                    <div class="like_numbers">
                        <a href="../supbage/like.php?type=posts&id=<?php echo $post['post_id']; ?>" class="like">Like</a> 
                        <span class="like_number"><?php echo $post['likes']; ?>   </span>
                    </div>
                    <span class="post_date">
                        <?php 
                            if($post['created_at'] == $post['updated_at']){
                                $date = $post['created_at'];
                            }else{
                                $date = $post['updated_at'];

                            }
                                echo $date ;
                        ?>
                    </span>
                    <?php 
                        if ($post_s->i_own_post($post['post_id'], $user_id)) {
                            echo"<span>
                                        <a href='../pages/edit.php?ID=" .$post['post_id'] . "' class='post_edit_and_delete'>Edit</a>
                                        <a href='../pages/delete.php?ID=" . $post['post_id'] . "' class='post_edit_and_delete'>Delete</a>
                                </span>";
                        }
                    ?>
                </div>
            </div>  
        </div>  

        <div class="post_comment">
            <?php
            if ($comments_n) {
                foreach ($comments_n as $comment) {
                    $user_data_post = $user->get_user_data_post($comment["user_id"]);
                    $image = $ch_image->is_user_have_image($user_data_post['profile_image'], $user_data_post['gender']);
                    include ("../supbage/comment_area.php");
                }
            }
            ?>
            <div class="comment_add_area">
                <div class="post_pox">
                    <!-- post form add post  -->
                    <form action="comment.php?post_id=<?php echo $post_id; ?>" method='post' enctype="multipart/form-data">
                        <div class="post-inputs">
                            <textarea name="comment_content" class="post_textarea" placeholder="What's on your mind"></textarea>
                        </div>
                        <input type="submit" class="post_button" value="Comment">  
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
