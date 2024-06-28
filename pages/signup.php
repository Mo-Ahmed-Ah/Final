<?php 
    include_once("../classes/autoloder.php");

    $flters = new Flter();
    if($_SERVER['REQUEST_METHOD']=='POST'){
        // add data in databaes
        $signup = new Signup();

        $data = $signup->check_data($_POST);
        $signup->create_user($data);
        
        header("Location: login.php");
        die;
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
            <input  name="first_name" type="text" class="text" placeholder="First name" required >
            <br>
            <br>
            <input  name="last_name" type="text" class="text" placeholder="Last name" required>
            <br>
            <br>
            <select name="gender" class="text" required >
                <option value="Male" >Male</option>
                <option value="Female" >Female</option>
            </select>
            <br>
            <br>
            <input  type="email" class="text" placeholder="Email" name="email" required>
            <br>
            <br>
            <input type="password" class="text" placeholder="Password" name="password" required>
            <br>
            <br>
            <input type="password" class="text" placeholder="Retype Password" name="retype_password" required>
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
