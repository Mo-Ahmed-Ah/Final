<?php 
include("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);     
$POST = new Post();
$error = "";
$post = false;

if(isset($_GET['ID'])){
    $post = $POST->get_one_post($_GET['ID']);
    if(!$post){
        $error = "No such post was found!";
    } else {
        if ($post["user_id"] != $_SESSION['mrbook_userid']) {
            $error = "Access denied!";
        }   
    }
} else {
    $error = "No such post was found!";
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $POST->delete_post($_POST["post_id"]);
    header("Location: profile.php");
    exit();
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
    <?php include ("../supbage/header.php"); ?>
    <div class="container">
        <div class="post-container">
            <div class="post-box">
                <?php if($post && !$error): ?>
                    <h2>Delete Post</h2>
                    <?php
                    $user = new User();
                    $user_data_post = $user->get_user_data_post($post["user_id"]);
                    include ("../supbage/delete_post.php");
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                        <input type="submit" class="delete-post-button" value="Delete">
                    </form>
                <?php else: ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
