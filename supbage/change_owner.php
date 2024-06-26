<?php
include_once("../classes/autoloder.php");

if (isset($_GET['ID'])) {
    $group_id = $_GET['ID'];
    $groups = new Group;
    $members = $groups->get_users_ingroup_not_owner($group_id);

}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['user_id'])) {
    $new_owner_id = $_POST['user_id'];
    $groups->change_owner($new_owner_id, $group_id);
    header("Location: ../pages/group_profile.php?ID=$group_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Group Owner | MrBook</title>
    <link rel="stylesheet" href="../style/group.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include ("../supbage/header.php"); ?>

    <div class="container">
        <h1>Select a Member to Make Owner</h1>
        <form method="post">
            <select name="user_id" required>
                <?php if ($members): ?>
                    <?php foreach ($members as $member):?>
                        <option value="<?= $member['user_id']; ?>">
                            <?= $member['first_name'] . ' ' . $member['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <input type="submit" value="Change Owner">
        </form>
    </div>
</body>
</html>
