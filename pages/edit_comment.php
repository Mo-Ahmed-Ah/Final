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
        if ($coment["user_id"] != $_SESSION['mrbook_userid']) {
            echo "<script>
                    alert('Access denied!');
                    window.location.href = '$referrer';
                </script>";
            exit();
        }   
    }
} else {
    echo "<script>
            alert('No such comment was found!');
            window.location.href = '$referrer';
        </script>";
    exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    
    $COMENT->edit_comment($_POST);

    header("Location: ../supbage/comment.php?post_id=$post_id");

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
    <script>
        function confirmDeletion(event) {
            if (!confirm('Are you sure you want to update this comment?')) {
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
                <h2>Edit comment</h2>
                <form action="" method="post" enctype="multipart/form-data" onsubmit="confirmDeletion(event)">
                    <div class="form-group">
                        <textarea name="comment_content" class="post_textarea" placeholder="What's on your mind"><?php echo htmlspecialchars($coment['comment_content']); ?></textarea>
                    </div>
                    <input type="hidden" name="comment_id" value="<?php echo $coment['id']; ?>">
                    <div class="button-container">
                        <input type="submit" class="edit-post-button" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
