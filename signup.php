<?php

// include libraries
require_once "php/db_connect.php";
require_once "php/request.php";

session_start();
$accessUser = new AccessUsers();
session_destroy();

include "session_init.php";
?>

<html>
<head>
    <title>Pizzarino</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/login.css">


    <link rel="shortcut icon" href="imgs/favicon.ico">

    <script type="text/javascript" src="js/default.js"></script>
    <script type="text/javascript" src="js/globalParameter.js"></script>

    <script type="text/javascript" src="js/templates.js"></script>
</head>

<?php

include "header.php";

$root_data = array();
$json = json_encode($root_data);

echo "<script> var rootData = JSON.parse('" . $json . "');</script>";

function validate($data) {
    $errors = [];
    if (strlen($data['uname']) <= 4) {
        array_push($errors, "Username must be >= 4 characters");
    }
    if (strlen($data['password']) <= 6) {
        array_push($errors, "Password must be >= 6 characters");
    }
    return $errors;
}

$error = "";
$user = null;
$success = false;
if (isset($_POST['signup'])) {

    $data = array();
    foreach ($_POST as $key=>$value) {
        $data[$key] = mysqli_real_escape_string($GLOBALS['conn'], $value);
    }

    $val_errors = validate($data);

    if (count($val_errors) == 0) {
        // valid
        $accessUser->attrs = $data;
        if ($accessUser->insert()) {
            $user = $accessUser->getAllById($accessUser->insertedID);
            sendSignupConfirmEmail($user);
            $success = true;
            header("Location: {$_SERVER['PHP_SELF']}?success=1");
            exit();
        }
        else {
            // server error!
            $error = "Internal Server Error.";
        }
    }
    else {
        $error = implode(", ", $val_errors);
    }

}

if (isset($_GET['success'])) {
    $success = true;
}
else {
    $success = false;
}

$template_success = '

<div class="noti">
    Sign-up success. <br>
    Please confirm your sign up in your email box!. <br>
    Redirect to login page in 3 seconds....
    <script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 3000);
    </script>
</div>>
';


//'.$error.'
$template_signup = '
<form action="signup.php" method="post">
    <div class="row">
        <label for="fname">First name</label>
        <input type="text" id="fname" name="fname" placeholder="First name" required onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="lname">Last name</label>
        <input type="text" id="lname" name="lname" placeholder="Last name" required onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="uname">User name</label>
        <input type="text" id="uname" name="uname" placeholder="User name" required onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="pay_name">Credit Card Name</label>
        <input type="text" id="pay_name" name="pay_name" placeholder="Credit Card Name"  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="pay_card_num">Card Number</label>
        <input type="text" id="pay_card_num" name="pay_card_num" placeholder="Credit Card Number"  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="pay_card_expire">Credit Card Expiry</label>
        <input type="date" id="pay_card_expire" name="pay_card_expire" placeholder="Credit Card Expiry"  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="dev_name">Delivery Name</label>
        <input type="text" id="dev_name" name="dev_name" placeholder="Name for delivery"  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="dev_phone">Phone</label>
        <input type="number" id="dev_phone" name="dev_phone" placeholder="Phone"  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="dev_address">Address</label>
        <input type="text" id="dev_address" name="dev_address" placeholder="Address"  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <label for="postal">Postal Code</label>
        <input type="number" id="postal" name="postal" placeholder="postal code"  onkeyup="validateSignup()">
    </div>
    <div class="row">
        <button class="button" id="signup_button" name="signup" disabled>Sign up</button>
    </div>
</form>
'.$error;

$template = ($success ? $template_success : $template_signup);


?>
<script>document.getElementById("link-account").classList.add("active")</script>

<div class="content">

    <div class="wrapper">
        <div class="tab-wrapper">
            <div class="tab-up-banner">
                <div class="tab">
                    <a href="login.php" class="tablinks">Login</a>
                    <a href="signup.php" class="tablinks active" >Sign up</a>
                </div>
            </div>

            <div class="tabcontent" id="tabcontent">
                <div class="banner" id="banner">
                    <?php
                    echo $template;
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

