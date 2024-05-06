<?php   
session_start();
if(isset( $_SESSION['mrbook_userid'])){
    $_SESSION['mrbook_userid']=NULL;
    unset($_SESSION['mrbook_userid']);
}
    header("Location: login.php");
            die;