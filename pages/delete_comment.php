<?php 
include("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);     
$COMENT = new Comment();
$coment = false;
$post_id = $_GET['post_id'];

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

if(isset($_GET['ID'])){
    $coment = $COMENT->get_one_comment($_GET['ID']);
    if(!$coment){
        echo "<script>
                        alert('No such comment was found!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
    } else {
        if ($coment["users_user_id"] != $_SESSION['mrbook_userid']) {
            echo "<script>
                        alert('Access denied!');
                        window.location.href = '$referrer';
                    </script>";
                exit();
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
    <script>
        function confirmDeletion(event) {
            if (!confirm('Are you sure you want to delete this commint?')) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body>
    <?php include ("../supbage/header.php"); ?>
    <div class="container">
        <div class="post-container">
            <div class="post-box">
                    <h2>Delete comment</h2>
                    <?php
                    $user = new User();
                    $user_data_post = $user->get_user_data_post($coment["users_user_id"]);
                    include ("../supbage/delete_comment.php");
                    ?>
                    <form action="" method="post" onsubmit="confirmDeletion(event)">
                        <input type="hidden" name="comment_id" value="<?php echo $coment['id']; ?>">
                        <div class="button-container">
                            <input type="submit" class="delete-post-button" value="Delete">
                        </div>
                    </form>
            </div>
        </div>
    </div>
</body>

</html>
