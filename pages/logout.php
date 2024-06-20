<?php   
session_start();
if(isset( $_SESSION['mrbook_userid'])){
    unset($_SESSION['mrbook_userid']);
}
    header("Location: login.php");
    die;