<?php

    include_once("../classes/autoloder.php");
    $user = new User();
    if(isset($_GET["ID"])){
        $id = $_GET['ID'];
        $friends = $user->get_my_friends_data($id);;
    }else{
        $id = $_SESSION['mrbook_userid'];
        $friends = $user->get_my_friends_data($id);
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Friedns | MrBook
        </title>

    </head>
    <body>
        <?php include_once ("../supbage/header.php");?>   
        <div class="friedns">
            <div class="friedns_bar">
                <h2 class="friedns_bar">Friends</h2><br>
                <?php 
                if($friends){
                    foreach ($friends as $friend) {
                        include ("../supbage/users.php");
                    }      
                }   
                ?>
            </div>
        </div>
    </body>
</html>