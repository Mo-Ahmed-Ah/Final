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
    $error = "No such post was found!";
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $error = $COMENT->edit_comment($_POST);
    if(empty($error)) {
        header("Location: ../supbage/comment.php?post_id=$post_id");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment | MrBook</title>
    <link rel="stylesheet" href="../style/edit_post.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <?php include ("../supbage/header.php"); ?>
    <div class="container">
        <div class="post-container">
            <div class="post-box">
                <?php if($coment && !$error): ?>
                    <h2>Edit comment</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="comment_content" class="post_textarea" placeholder="What's on your mind"><?php echo htmlspecialchars($coment['comment_content']); ?></textarea>
                        </div>
                        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($coment['id']); ?>">
                        <div class="button-container">
                            <input type="submit" class="edit-post-button" value="Save">
                        </div>
                    </form>
                <?php else: ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
</body>

</html>
