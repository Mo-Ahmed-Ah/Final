<?php
include_once("../classes/autoloder.php");
$group = new Group();  // تعديل هنا: استبدال Profile بـ Group

$ch_image = new Check_Images();
$image_class = new Image();

// جلب بيانات الجروب
$group_data = $group->show_one_group($_GET['ID']);

// جلب بيانات المالك
$owner_data = $group->get_owner_name($group_data['owner_id']); // افتراض أن الدالة get_owner_name موجودة في الكلاس Group وتقوم بجلب بيانات المالك

$image_cover = "../assets/mountain.jpg";
if (file_exists($group_data['image'])) {
    $image_cover = $image_class->get_thumb_cover($group_data['image']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/about.css">
    <title>
        About Group | MrBook
    </title>
</head>
<body>
    <?php include_once ("../supbage/header.php");?>
    <div class="about">
        <div class="about_bar">
            <h2>About Group</h2><br>
            <div class="images">
                <img src="<?=$image_cover?>" alt="" class="cover_image">
            </div>
            <div class="data_contener">
                <h3>Group Name : </h3>
                <h4>
                    <?=$group_data['group_name']?>
                </h4>
            </div>
            <div class="data_contener">
                <h3>Description : </h3>
                <h4>
                    <?=$group_data['description']?>
                </h4>
            </div>
            <div class="data_contener">
                <h3>Owner : </h3>
                <h4>
                    <?=$owner_data['first_name'] . " " . $owner_data['last_name']?> <!-- تعديل هنا: عرض اسم المالك -->
                </h4>
            </div>
            <div class="data_contener">
                <h3>Number of members : </h3>
                <h4>
                    <?=$group_data['number_of_members']?>
                </h4>
            </div>
            <div class="data_contener">
                <h3>Group Link : </h3>
                <h4>
                    <?=$group_data['group_url']?>
                </h4>
            </div>
            <div class="data_contener">
                <h3>Update in : </h3>
                <h4>
                    <?=$group_data['update_at']?>
                </h4>
            </div>
            <div class="data_contener">
                <h3>Create in : </h3>
                <h4>
                    <?=$group_data['create_at']?>
                </h4>
            </div>
        </div>
    </div>
</body>
</html>
