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

        }else{
            if ($post["user_id"] != $_SESSION['mrbook_userid']) {
                $error = "Access denied! " ;
                
            }   
        }
    }else{
        $error = "No such post was found!";
    }

    if($_SERVER['REQUEST_METHOD']== "POST"){
        $POST->delete_post($_POST["post_id"]);
        header("Location: profile.php");
    }
    $pps=$post['post_id']
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
    <?php include ("../supbage/header.php"); ?>
    <div class="container">
        <!-- <div class="content"> -->
            <div class="post-container">
                <div class="post-box">
                    <?php if($post): ?>
                        <h2>Delete Post</h2>
                        <?php 
                        if($error != ""){
                            echo $error;
                        }else{

                            $user=new User();
                            $user_data_post = $user->get_user_data_post($post["user_id"]);
                            include ("../supbage/delete_post.php");
                            echo "<form action='' method='post'>";;
                            echo "<input type='hidden' name='post_id' value='<?=$pps?>";
                            echo "<input type='submit' class='delete-post-button' value='Delete'>";
                            echo "<?php else: ?>";
                            echo "<p><?=$error?></p>";
                        }
                            ?>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        <!-- </div> -->
    </div>
</body>

</html>
