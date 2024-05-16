<?php 
    include("../classes/autoloder.php");
    

    // isset($_SESSION['mrbook_userid']);
    $login = new Login();
    $user_data=$login->check_login($_SESSION['mrbook_userid']);     
    $POST = new Post();
    $error = "";
    if(isset($_GET['ID'])){

        $post = $post = $POST->get_one_post($_GET['ID']);
        if(!$post){
            
            $error = "No such post was found!";
        }
    }else{
        $error = "No such post was found!";
    }

    if($_SERVER['REQUEST_METHOD']== "POST"){
        $POST->delete_post($_POST["post_id"]);
        header("Location: profile.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete | MrBook</title>
    <link rel="stylesheet" href="../style/delete_post.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <?php
    ?>
    <!-- top profile bar -->
    <?php
        include ("../supbage/header.php");
        ?>
    <!-- cover area -->
    <div class="cover_div_delete_post">
        
        <!-- below cover area -->
        <div class="profile_content_delete_post">
            <!-- post area -->
            <div class="post_delete_post">
                <div class="post_pox_delete_post">
                    <br>
                    <form action="" method="post">
                        <br>
                        <br>
                        <?php
                                if($post){
                                echo "<h2>Delete Post</h2>";
                                    $user=new User();
                                    $user_data_post = $user->get_user_data_post($post["user_id"]);
                                    include ("../supbage/delete_post.php");
                                }else{
                                    echo $error;
                                }
                            ?>
                        <input type="hidden" name="post_id" value="<?=$post['post_id']?>">
                        <input type="submit" class="delete_post_button" value="Delete">
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</body>

</html>