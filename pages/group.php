<?php
    include_once("../classes/autoloder.php");
    
    $group = new Group();
    $groups = $group->show_all_group();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups | MrBook</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/group.css">   
    <link rel="stylesheet" href="../style/friedns.css">   
</head>
<body>
    <?php include_once ("../supbage/header.php"); ?>
    <div class="all">
        <div class="groups">
            <div class="my_groups">
                <h2>My Groups</h2>
                <div class="my_groups_area">
                    <?php 
                        if ($groups) {
                            foreach ($groups as $go) {
                                if ($go["owner_id"] != $_SESSION['mrbook_userid']) {
                                    continue;
                                }
                                include ("../supbage/groups.php");
                            }
                        }
                    ?>
    
                </div>
            </div>
            <div class="my_groups">
                <h2>Joined Groups</h2>
                <div class="my_groups_area">
                    <?php
                    $groups = $group->show_joined_groups();
                    if ($groups) {
                        foreach ($groups as $go) {
                            include ("../supbage/groups.php");
                            
                        }
                    }
                    ?>
                </div>
            </div> 
        </div>
        <div class="add_remove_groups">
            <h2>Update and Remove</h2>
            <div class="my_groups_area">
                <?php
                    $groups = $group->show_all_group();
                    if ($groups) {
                        foreach ($groups as $go) {
                        $group_id = $go['id'];
                            if ($go["owner_id"] != $_SESSION['mrbook_userid']) {
                                continue;
                            }
                            echo "<div class='groups_buttons'>";
                                include ("../supbage/groups.php");
                                echo"<div class='remov_buttons'>
                                        <a href='../supbage/delete_group.php?ID=$group_id'>Delet Group</a>
                                    </div>";
                            echo"</div>";
                        }
                    }
                ?>
            </div>
            <div class="menu_buttons">
                <a href="../supbage/create_group.php">Create Group</a>
            </div>
        </div>
    </div>
    
</body>
</html>