<?php
include_once("../classes/autoloder.php");
$user = new Profile();
$flters = new Flter();
$user_data = $user->get_profile($_SESSION['mrbook_userid']);

$form_type = ''; // Initialize the variable
$phon_type = ''; // Initialize the variable

if (isset($_GET['type'])) {
    if ($_GET['type'] == "change First Name") {
        $form_type = "first_name";
    } else if ($_GET['type'] == "change Last Name") {
        $form_type = "last_name";
    } else if ($_GET['type'] == "change Password") {
        $form_type = "password";
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
            if($form_type != "email"){
                if($form_type != "password"){

                    $result = $user->update_profile($form_type, $new_value);
                    if ($result !== true) {
                        echo "<script>alert('$result');</script>";
                    } else {
                        echo "<script>alert('Updated successfully');</script>";
                        header("Location: ../pages/about.php?user_id=" . $_SESSION['mrbook_userid']);
                        exit();
                    }
                }else{
                    $old_password = $_POST["old_password"];
                    $new_password = $_POST["new_password"];
                    $confirm_password = $_POST["confirm_password"];

                    $confirmation_password = $flters->confirmation_password($new_password, $confirm_password);
                    $old_pass=$flters->check_old_password($old_password);
                    if($old_pass == true){
                        $result = $user->update_profile($form_type, $new_password);
                        if ($result !== true) {
                            echo "<script>alert('$result');</script>";
                        } else {
                            echo "<script>alert('Updated successfully');</script>";
                            header("Location: ../pages/about.php?user_id=" . $_SESSION['mrbook_userid']);
                            exit();
                        }
                    }
                }
            }else{
                $new_value = $flters->is_email($new_value);
                $result = $user->update_profile($form_type, $new_value);
                if ($result !== true) {
                    echo "<script>alert('$result');</script>";
                } else {
                    echo "<script>alert('Updated successfully');</script>";
                    header("Location: ../pages/about.php?user_id=" . $_SESSION['mrbook_userid']);
                    exit();
                }
            }
        }
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
                if ($form_type != "gender") {
                    if ($_GET['type'] != "change Password") {
                        echo "<textarea name='$form_type' id='$form_type' class='post_textarea'>" . htmlspecialchars($user_data[$form_type]) . "</textarea>";
                    } else {
                        // إذا كان نوع النموذج "change Password"
                        echo "<div class='passeord_erea'>";
                        echo "<input type='password' name='old_password' id='old_password' class='post_textarea' placeholder='Enter old password'>";
                        echo "<input type='password' name='new_password' id='new_password' class='post_textarea' placeholder='Enter new password'>";
                        echo "<br><input type='password' name='confirm_password' id='confirm_password' class='post_textarea' placeholder='Confirm new password'>";
                        echo "</div>";
                    }
                } else {
                    // إذا كان نوع النموذج "gender"
                    echo "<select name='$form_type' id='$form_type'>";
                    echo "<option value='male' " . ($user_data[$form_type] == 'male' ? 'selected' : '') . ">Male</option>";
                    echo "<option value='female' " . ($user_data[$form_type] == 'female' ? 'selected' : '') . ">Female</option>";
                    echo "</select>";
                }
                ?>
                <input type="submit" value="Save" class="edit-post-button">
            </form>
        </div>
    </div>
</body>
</html>
