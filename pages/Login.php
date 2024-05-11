<?php 
session_start();
    include ("../classes/Connect.php");
    include ("../classes/Login.php");

    // check method post 
    $email = "";
    $password = "";

    if($_SERVER['REQUEST_METHOD']=='POST'){

        // Filter the data before passing it to the evaluate method
        $filtered_data = array_map('strip_tags', $_POST);
        // Create new object with the Signup class from signup.php file 
        $login = new Login();
        $result = $login->evaluate($filtered_data);
        if ($result != "") {
            echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
            echo $result;
            echo "</div>";
        } else {
            header("Location: profile.php");
            die;
        }
        
        $email = $filtered_data['email'];
        $password = $filtered_data['password'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrBook | Log in</title>
    <link rel="stylesheet" href="../style/signup.css">
</head>

<body>
    <div class="bar">
        <div class="mrbook">MyBook </div>
        <div class="signup_button">
            <a href="signup.php" style="text-decoration: none; ">  
                Signup 
            </a>
        </div>
    </div>
    <div class="login_bar">
        login MrBook
        <br>
        <br>
        <form method="post">
            <input value="<?php echo $email;?>" type="email" class="text" placeholder="Email" name = "email">
            <br>
            <br>
            <input value="<?php echo $password;?>" type="password" class="text" placeholder="Password" name="password">
            <br>
            <br>
            <input type="submit" class="login_button" value="login">
        </form>
    </div>
</body>

</html>