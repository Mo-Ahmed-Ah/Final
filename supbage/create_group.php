<?php 
    include_once("../classes/autoloder.php");

    if(empty($_SERVER['HTTP_REFERER'])){
        echo "<script>
                alert('Dont play with me!');
                setTimeout(function() {
                    window.location.href = '../pages/logout.php';
                }, 1); 
            </script>";
        exit(); 
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $grop = new Group();
        $grop->create_group($_POST["name"], $_POST["description"],$_FILES['file']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Create Group | MrBook
    </title>
    <link rel="stylesheet" href="../style/group.css">
</head>
<body>
    <!-- top profile bar -->
    <?php
        include ("../supbage/header.php");
    ?>
    <div class="create_group">
        <h1>create group</h1>
        <br>
        <br>
        <form method="post" enctype="multipart/form-data">
            <input value="" type="text" class="text" placeholder="Group Name" name = "name">
            <br>
            <br>
            <input value="" type="text" class="text" placeholder="Group description" name="description">
            <br>
            <br>
            <img id="image-preview" class="image-preview" src="#" alt="Image Preview" style="display: none;">
            <br>
            <br>
            <div class="boutooms">
                <input type="file" name="file" id="file" class="file" onchange="previewImage(event)">
                <label for="file" class="file-label">Choose Image</label>
                <input type="submit" class="create_button" value="Create">
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('image-preview');
                output.src = dataURL;
                output.style.display = 'block';
                output.style.maxHeight = '250px';
                output.style.maxWidth = '250px';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
</body>
</html>