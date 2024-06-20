<?php 

    include_once("../classes/autoloder.php");
    $flters = new Flter();

    // check method post 
    $email = "";
    $password = "";

    if($_SERVER['REQUEST_METHOD']=='POST'){

        // Filter the data and check
        $email = $flters->is_email($_POST['email']);
        $password = $flters->check_password_it_ok($_POST["password"],$email);
        if($password){
            $login = new Login();
            // pass data to evaluate becous login
            $result = $login->evaluate($email , $password);
            header("Location: timeline.php");
            die;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrBook | Log in</title>
    <link rel="stylesheet" href="../style/signup.css">
    <link rel="stylesheet" href="../style/style.css">
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
        <h1>login MrBook</h1>
        <br>
        <br>
        <form method="post">
            <input value="<?php echo $email;?>" type="text" class="text" placeholder="Email" name = "email">
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