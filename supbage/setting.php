<?php
    include_once("../classes/autoloder.php");
    $user = new Profile();
    $user_data = $user->get_profile($_SESSION['mrbook_userid']);

    if ($_GET['type'] == "change First Name") {
        $form_type = "first_name";
    } else if ($_GET['type'] == "change Last Name") {
        $form_type = "last_name";
    } else if ($_GET['type'] == "change Gender") {
        $form_type = "gender";
    } else if ($_GET['type'] == "change Email") {
        $form_type = "email";
    } else if ($_GET['type'] == "change Phone") {
        $form_type = "phone";
        $phon_type = "change";
    } else if ($_GET['type'] == "Add Phone") {
        $form_type = "phone";
        $phon_type = "add";
    }

    // معالجة النموذج
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_value = $_POST[$form_type] ?? '';
        if ($form_type === "phone" && $phon_type === "add" && empty($user_data['phone'])) {
            $result = $user->add_phone($new_value);
            if ($result !== true) {
                echo "<script>alert('$result');</script>";
            }
        } else {
            $result = $user->update_profile($form_type, $new_value);
        }

        if ($result === true) {
            $user_data = $user->get_profile($_SESSION['mrbook_userid']);
            echo "<script>alert('Updated successfully');</script>";
        } else {
            echo "<script>alert('Failed to update');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$_GET['type']?> | MrBook</title>
    <link rel="stylesheet" href="../style/setting.css">
</head>

<body>
    <?php
        include_once ("../supbage/header.php");
    ?>
    <div class="update_area">
        <div class="form">
            <form action="" method="post">
                <label for=""><?=$_GET['type']?></label>
                <textarea name="<?=$form_type?>" id="<?=$form_type?>">
                    <?=$user_data["$form_type"]?>
                </textarea>
                <input type="submit" value="Save">
            </form>
        </div>
    </div>
</body>
</html>