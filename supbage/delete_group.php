<?php
include_once("../classes/autoloder.php");
    
    if (isset($_GET['ID'])) {
        $groups = new Group;
        $flters = new Check_Images();
        $group = $groups->show_one_group($_GET['ID']);
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $groups->remove_group($_POST["post_id"]);
        header("Location: ../pages/group.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Group | MrBook</title>
        <link rel="stylesheet" href="../style/group.css">
    </head>
    <body>
        <?php
            include ("../supbage/header.php");
            $image= $flters->is_group_have_image($group["image"]);
        ?>
        <div class="posts">
            <div>
                <img src="<?php echo $image ?>" alt="" class="post_img">
            </div>
            <div class="post_conten">
                <div class="post_num"> 
                    <?php 
                        echo $group["group_name"];
                    ?>
                </div>
                    <?php
                        echo $group["description"];
                    ?>
                <br><br>
            </div>
            <form action="" method="post" onsubmit="confirmDeletion(event)">
                <input type="hidden" name="post_id" value="<?php echo $group['id']; ?>">
                <div class="button-container">
                    <input type="submit" class="delete-post-button" value="Delete">
                </div>
            </form>
        </div>
        <script>
        function confirmDeletion(event) {
            if (!confirm('Are you sure you want to delete this group?')) {
                event.preventDefault();
            }
        }
    </script>
    </body>
</html>
