<?php
    include_once ("../classes/autoloder.php");
    $user = new Profile();
    $user_data=$user->get_profile($_SESSION['mrbook_userid'])
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
                <a href="../supbage/setting.php?type=change First Name">
                    <h3>Frist Name : </h3>
                </a>
                <h4>
                    <?=$user_data['first_name']?>
                </h4>
            </div>
            <div class="data_contener">
                <a href="../supbage/setting.php?type=change Last Name">
                    <h3>Last Name : </h3>
                </a>
                <h4>
                    <?=$user_data['last_name']?>
                </h4>
            </div>
            <div class="data_contener">
                <a href="../supbage/setting.php?type=change Gender">
                    <h3>Gender : </h3>
                </a>
                <h4>
                    <?=$user_data['gender']?>
                </h4>
            </div>
            <div class="data_contener">
                <a href="../supbage/setting.php?type=change Email">
                    <h3>Email : </h3>
                </a>
                <h4>
                    <?=$user_data['email']?>
                </h4>
            </div>
            <?php
                if ($user_data['phone']!= null){
                    $phone = $user_data['phone'];
                    echo "<div class='data_contener'>
                    <a href='../supbage/setting.php?type=change Phone'>
                        <h3>Phone : </h3>
                    </a>
                    <h4>
                    <?=$phone?>
                    </h4>
                    </div>";
                }else{
                    echo "<div class='data_contener'>
                    <a href='../supbage/setting.php?type=Add Phone'>
                        <h3>Phone : </h3>
                    </a>
                    <h4>
                    hasn't phone
                    </h4>
                    </div>";
                }
            ?>
        </div>

    </div>
</body>
</html>