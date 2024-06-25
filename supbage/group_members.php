<?php
    include_once("../classes/autoloder.php");
    $_SESSION["page"] = "group";

    if (isset($_GET['ID'])) {
        $groups = new Group;
        $flters = new Check_Images();
        $group = $groups->show_one_group($_GET['ID']);
    }
    $user = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members | MrBook</title>
    <link rel="stylesheet" href="../style/group.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/friedns.css">
</head>
<body>
    <?php include ("../supbage/header.php"); ?>
    <div class="all_member">
        <div class="add_remove_admin">
            <?php 
                if($group["owner_id"]==$_SESSION['mrbook_userid']){
                    echo "<a href=''>Change owner</a>
                        <a href=''>Add admin</a>
                        <a href=''>Delete admin</a>
                    ";
                }
            ?>
            
            
        </div>
        <div class="members">
            <div class="owner">
                <h3>Owner</h3>
                <?php
                $friend = $user->get_user_data_post($group["owner_id"]);
                include_once ("../supbage/users.php");
                ?>
            </div>
            <div class="admins">
                <h3>Admins</h3>
                <?php
                    $friends = $groups->get_admin_ingroup($group["id"]);
                    foreach($friends as $friend){
                        include ("../supbage/users.php");
                    }
                ?>
            </div>
            <div class="users">
                <h3>Users</h3>
                <?php
                    $friends = $groups->get_users_ingroup($group["id"]);
                    foreach($friends as $friend){
                        include ("../supbage/users.php");
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>