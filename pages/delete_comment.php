<?php 
include("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);     
$COMENT = new Comment();
$error = "";
$coment = false;
$post_id = $_GET['post_id'];

if(isset($_GET['ID'])){
    $coment = $COMENT->get_one_comment($_GET['ID']);
    if(!$coment){
        $error = "No such comment was found!";
    } else {
        if ($coment["users_user_id"] != $_SESSION['mrbook_userid']) {
            $error = "Access denied!";
        }   
    }
} else {
    $error = "No such comment was found!";
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $COMENT->delete_comment($_POST["comment_id"],$post_id);
    header("Location: ../supbage/comment.php?post_id=$post_id");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post | MrBook</title>
    <link rel="stylesheet" href="../style/delete_post.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <?php include ("../supbage/header.php"); ?>
    <div class="container">
        <div class="post-container">
            <div class="post-box">
                <?php if($coment && !$error): ?>
                    <h2>Delete comment</h2>
                    <?php
                    $user = new User();
                    $user_data_post = $user->get_user_data_post($coment["users_user_id"]);
                    include ("../supbage/delete_comment.php");
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="comment_id" value="<?php echo $coment['id']; ?>">
                        <div class="button-container">
                            <input type="submit" class="delete-post-button" value="Delete">
                        </div>
                    </form>
                <?php else: ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
