<?php 
    include ("../clsses/Connect.php");
    include ("../clsses/Signup.php");
    // check method post 
    $first_name = "";
    $last_name = "";
    $gender ="";
    $email ="";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        // Filter the data before passing it to the evaluate method
        $filtered_data = array_map('strip_tags', $_POST);
        // Create new object with the Signup class from signup.php file 
        $signup = new Signup();
        $result = $signup->evaluate($filtered_data);
        if ($result != "") {
            echo '<div style = "text-align: center;font-size: 12px;color: white;background-color: gray;">';
            echo $result;
            echo "</div>";
        } else {
            header("Location: login.php");
            die;
        }
        $first_name = $filtered_data['first_name'];
        $last_name = $filtered_data['last_name'];
        $gender = $filtered_data['gender'];
        $email = $filtered_data['email'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrBook | Signup</title>
    <link rel="stylesheet" href="../style/signup.css">
        <link rel="stylesheet" href="../style/link.css">

</head>

<body>
    <div class="bar">
        <div class="mrbook">MyBook </div>
        <div class="signup_button">
            <a href="login.php" style="text-decoration: none;">
                Login
            </a>
        </div>
    </div>
    <div class="login_bar">
        Signup MrBook
        <br>
        <br>
        <form action="signup.php" method="post">
            <input value="<?php echo $first_name?>" name="first_name" type="text" class="text" placeholder="First name">
            <br>
            <br>
            <input value="<?php echo $last_name?>" name="last_name" type="text" class="text" placeholder="Last name">
            <br>
            <br>
            <span>
                Gender :
            </span>
            <br>
            <select name="gender" class="text">
                <option value="Male" <?php if($gender == "Male") echo "selected"; ?>>Male</option>
                <option value="Female" <?php if($gender == "Female") echo "selected"; ?>>Female</option>
            </select>
            <br>
            <br>
            <input value="<?php echo $email?>" type="email" class="text" placeholder="Email" name="email">
            <br>
            <br>
            <input type="password" class="text" placeholder="Password" name="password">
            <br>
            <br>
            <input type="password" class="text" placeholder="Retype Password" name="retype_password">
            <br>
            <br>
            <input type="submit" class="login_button" value="Signup">
        </form>
    </div>
</body>

</html>
