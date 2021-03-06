<?php

// include libraries
require_once "php/db_connect.php";
require_once "php/request.php";


session_start();

if (!isset($_POST['login'])) {
    session_unset();
    session_destroy();
}


$accessUser = new AccessUsers();

?>

<html>
<head>
    <title>Pizzarino</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="imgs/favicon.ico">

</head>

<?php

include "header.php";


$errors = array();

function validate($uname, $password)
{
    $errors = array();
    if (strlen($uname) < 4) {
        array_push($errors, "User name must be >= 4 character");
    }
    if (strlen($password) < 6) {
        array_push($errors, "Password must be >= 6");
    }
    return $errors;
}

$sucesss = false;
var_dump($_POST);
if (isset($_POST['login'])) {
    $uname = mysqli_real_escape_string($GLOBALS['conn'], $_POST['uname']);
    $password = mysqli_real_escape_string($GLOBALS['conn'], $_POST['password']);

    if (!get_magic_quotes_gpc()) {
        $uname = addslashes($uname);
        $password = addslashes($password);
    }
    echo "uname {$uname} - {$password}";

    $errors = validate($uname, $password);
    if (count($errors) == 0) {
        if ($accessUser->loginWithUnamePass($uname, $password)) {
            $success = true;
            header("Location: index.php");
            die();
        } else {
            $errors = array("Username or Password incorrect!: {$uname}, {$password}");
        }
    }
}


$root_data = array(//    "menu"=>$all_menus
);
$json = json_encode($root_data);

echo "<script> var rootData = JSON.parse('" . $json . "');</script>";

$error = implode(", ", $errors);

$template_login = '
<form action="login.php" method="post">
    <div class="row">
        <label for="uname">User Name</label>
        <input type="text" id="uname" name="uname" placeholder="User name" required onkeyup="validateLogin()">
    </div>
    <div class="row">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required  onkeyup="validateLogin()">
    </div>
    ' . $error . '
    <div class="row">
        <input type="submit" class="button" name="login" id="login_button" value="Login">
    </div>
</form>
';

?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-account").classList.add("active")</script>

<div class="content">

    <div class="wrapper">
        <div class="tab-wrapper">
            <div class="tab-up-banner">
                <div class="tab">
                    <a href="login.php" class="tablinks active">Login</a>
                    <a href="signup.php" class="tablinks">Sign up</a>
                </div>
            </div>

            <div class="tabcontent" id="tabcontent">
                <div class="banner" id="banner">
                    <?php
                    echo $template_login;
                    ?>
                </div
            </div>
        </div>

    </div>

</div>

<?php
include "footer.php"
?>

<!--JS-->
<script type="text/javascript" src="js/login.js"></script>
</html>

