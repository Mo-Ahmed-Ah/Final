<?php
include_once("../classes/autoloder.php");

if (isset($_GET['ID'])) {
    $group_id = $_GET['ID'];
    $groups = new Group;
    $admins = $groups->get_admin_ingroup($group_id);
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $groups->remove_admin($user_id, $group_id);
    header("Location: ../pages/group_profile.php?ID=$group_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Admin | MrBook</title>
    <link rel="stylesheet" href="../style/group.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include ("../supbage/header.php"); ?>

    <div class="container">
        <h1>Select an Admin to Remove</h1>
        <form method="post">
            <select name="user_id" required>
                <?php if ($admins): ?>
                    <?php foreach ($admins as $admin): ?>
                        <option value="<?= $admin['user_id']; ?>">
                            <?=$admin['first_name'].' '.$admin['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <input type="submit" value="Remove Admin">
        </form>
    </div>
</body>
</html>
