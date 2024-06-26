<?php
    include_once ("../classes/autoloder.php");
    if (isset($_GET['ID'])) {
    $groups = new Group;
    $flters = new Check_Images();
    $group = $groups->show_one_group($_GET['ID']);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $userid = $_SESSION['mrbook_userid'];
        $data = [
            'post_content' => $_POST['post_content'] ?? '',
            'group_id' => $_GET['ID']
        ];
        $files = $_FILES;

        $groups->create_group_post($userid, $data, $files);

        header("Location: group_profile.php?ID=$data[group_id]");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting | MrBook</title>
    <link rel="stylesheet" href="../style/setting.css">
</head>
<body>
    <?php
        include_once ("../supbage/header.php");
    ?>
    <div class="setting">
        <div class="setting_bar">
            <h2>Setting</h2><br>
            <div class="data_contener">
                <a href="../supbage/change_group_sitting.php?type=change Name&&ID=<?=$group['id']?>">
                    <h3>Group Name : </h3>
                </a>
                <h4>
                    <?=$group['group_name']?>
                </h4>
            </div>
            <div class="data_contener">
                <a href="../supbage/change_group_sitting.php?type=change Description&ID=<?=$group['id']?>">
                    <h3>Group Description : </h3>
                </a>
                <h4>
                    <?=$group['description']?>
                </h4>
            </div>
        </div>

    </div>
</body>
</html>