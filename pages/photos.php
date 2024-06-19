<?php
include_once ("../classes/autoloder.php");
$id = $_GET["ID"];
$post = new Post();
$posts = $post->get_post($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photos | MrBook</title>
    <link rel="stylesheet" href="../style/photos.css">
</head>
<body>
    <?php include_once ("../supbage/header.php");?>
    <div class="photos">
        <!-- posts -->
                <div class="posts_bar">
                    
                    <?php 
                    if($posts){
                        foreach ($posts as $post) {
                            if(!empty($post["image"])){
                                $user = new User();
                                $user_data_post= $user->get_user_data_post($post["user_id"]);
                                include ("../supbage/post.php");
                            }
                        }
                    }
                        
                    ?>
                </div>

    </div>
</body>
</html>