<?php 
    include_once("../classes/autoloder.php");

    $flters = new Flter();

    // check method post 
    $first_name = "";
    $last_name = "";
    $gender ="";
    $email ="";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        // add data in databaes
        $signup = new Signup();

        $data = $signup->check_data($_POST);
        $signup->create_user($data);
        if ($result != "") {
            echo "<script>alert('$result')</script>";

        } else {
            header("Location: login.php");
            die;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrBook | Signup</title>
    <link rel="stylesheet" href="../style/signup.css">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <div class="login_bar">
        <h1>Signup MrBook</h1>
        <form action="signup.php" method="post">
            <input value="<?php echo $first_name ?>" name="first_name" type="text" class="text" placeholder="First name">
            <br>
            <br>
            <input value="<?php echo $last_name ?>" name="last_name" type="text" class="text" placeholder="Last name">
            <br>
            <br>
            <select name="gender" class="text" >
                <option value="Male" <?php if($gender == "Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if($gender == "Female") echo "selected"; ?>>Female</option>
            </select>
            <br>
            <br>
            <input value="<?php echo $email ?>" type="email" class="text" placeholder="Email" name="email">
            <br>
            <br>
            <input type="password" class="text" placeholder="Password" name="password">
            <br>
            <br>
            <input type="password" class="text" placeholder="Retype Password" name="retype_password">
            <br>
            <br>
            <input type="submit" class="login_button" value="Signup">
            <div class="signup_button">
                <b>You have account ?</b>
                <a href="login.php" style="text-decoration: none;"> Login</a>
            </div>
        </form>
    </div>
</body>

</html>
