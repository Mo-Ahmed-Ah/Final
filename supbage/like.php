<?php
include_once("../classes/autoloder.php");


if (isset($_SERVER["HTTP_REFERER"])) {
    $return_to = $_SERVER["HTTP_REFERER"];

} else {
    $return_to = "profile.php";

}



if (isset($_GET['type']) && isset($_GET["id"])) {
    if($_GET['type'] == "posts"){
        $post = new Post();
        $post->like_post($_GET["id"],$_SESSION['mrbook_userid']);
    }else if($_GET['type'] == "follwers"){
        $follwer = new User();
        $follwer->follwer_user($_GET["id"],$_SESSION['mrbook_userid']);
    }else if($_GET['type'] == "Join_Group"){
        $follwer = new Group();
        $follwer->join_group($_SESSION['mrbook_userid'],$_GET["id"]);
    }else if($_GET['type'] == "comments"){
        $coment = new Comment();
        $coment->like_comment($_GET["id"],$_SESSION['mrbook_userid']);
    }else if($_GET['type'] == "post_group"){
        $coment = new Group();
        $coment->like_post_group($_GET["id"],$_SESSION['mrbook_userid']);
    }
}

header("Location: " . $return_to);

