<?php
include_once("../classes/autoloder.php");
$groups = new Group();
$flters = new Flter();
if(isset($_GET['ID'])){

    $group = $groups->show_one_group($_GET['ID']);
}

$form_type = ''; // Initialize the variable

if (isset($_GET['type'])) {
    $form_type = '';

    switch ($_GET['type']) {
        case "change Name":
            $form_type = "group_name";
            break;
        case "change Description":
            $form_type = "description";
            break;
        default:
            header("Location: ../pages/profile.php");
            exit();
    }

    // معالجة النموذج
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_value = $_POST[$form_type] ?? '';
        $groups->update_group_data($form_type, $new_value,$group['id']);
        
    }
} else {
    header("Location: ../pages/profile.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$_GET['type'] ?? 'Update'?> | MrBook</title>
    <link rel="stylesheet" href="../style/setting.css">
    <link rel="stylesheet" href="../style/style.css">
</head>


<body>
    <?php
        include_once ("../supbage/header.php");
    ?>
    <div class="update_area">
        <div class="form">
            <form action="" method="post">
                <label for="<?=$form_type?>"><?=$form_type?></label>
                <?php

                echo "<textarea name='$form_type' id='$form_type' class='post_textarea' placeholder='$group[$form_type]'></textarea>";

                ?>
                <input type="submit" value="Save" class="edit-post-button">
            </form>
        </div>
    </div>
</body>
</html>
