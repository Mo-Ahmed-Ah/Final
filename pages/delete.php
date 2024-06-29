<?php 
include("../classes/autoloder.php");

$login = new Login();
$user_data = $login->check_login($_SESSION['mrbook_userid']);     
$POST = new Post();
$post = false;

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
    $post = $POST->get_one_post($_GET['ID']);
    if(!$post){
        echo "<script>
                alert('No such post was found!');
                window.location.href = '$referrer';
            </script>";
        exit();
    } else {
        if ($post["user_id"] != $_SESSION['mrbook_userid']) {
            echo "<script>
                    alert('Access denied!');
                    window.location.href = '$referrer';
                </script>";
            exit();
        }   
    }
} else {
    echo "<script>
                alert('No such post was found!');
                window.location.href = '$referrer';
            </script>";
        exit();
}
if($_SESSION["page"] == "profile"){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $POST->delete_post($_POST["post_id"]);
        header("Location: profile.php");
        exit();
    }
}else if($_SESSION["page"] == "timeline"){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $POST->delete_post($_POST["post_id"]);
        header("Location: timeline.php");
        exit();
    }
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
            if (!confirm('Are you sure you want to delete this post?')) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body>
    <?php include ("../supbage/header.php"); ?>
        <div class="post-container">
                    <h2>Delete Post</h2>
                    <?php
                        $user = new User();
                        $user_data_post = $user->get_user_data_post($post["user_id"]);
                        include ("../supbage/delete_post.php");
                    ?>
                    <form action="" method="post" onsubmit="confirmDeletion(event)">
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id'];?>">
                        <div class="button-container">
                            <input type="submit" class="delete-post-button" value="Delete">
                        </div>
                    </form>

        </div>
</body>

</html>
