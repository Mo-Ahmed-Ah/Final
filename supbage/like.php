<?php
include_once("../classes/autoloder.php");

if (isset($_SERVER["HTTP_REFERER"])) {
    $return_to = $_SERVER["HTTP_REFERER"];
} else {
    $return_to = "profile.php";
}

if (isset($_GET['type']) && isset($_GET["id"])) {

            $post = new Post();
            $post->like_post($_GET["id"],$_SESSION['mrbook_userid']);
}

header("Location: " . $return_to);

