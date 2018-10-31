<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/3/18
 * Time: 8:44 PM
 */

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
//$accessUser = new AccessUsers();

//$root_data = array(//    "menu"=>$all_menus
//);
//$json = json_encode($root_data);
//
////echo $all_menus;
//echo "<script> var rootData = JSON.parse('" . $json . "');</script>";

//function validate($data) {
//    $errors = [];
//    if (strlen($data['uname']) <= 4) {
//        array_push($errors, "Username must be >= 4 characters");
//    }
//    if (strlen($data['password']) <= 6) {
//        array_push($errors, "Password must be >= 6 characters");
//    }
//    return $errors;
//}

//$error = "";
//$user = null;
//$success = false;
//if (isset($_POST['signup'])) {
//
//    $data = array();
//    foreach ($_POST as $key=>$value) {
//        $data[$key] = mysqli_real_escape_string($GLOBALS['conn'], $value);
//    }
//
//    $val_errors = validate($data);
//
//    if (count($val_errors) == 0) {
//        // valid
//        $accessUser->attrs = $data;
//        if ($accessUser->insert()) {
//            $user = $accessUser->getAllById($accessUser->insertedID);
////            $accessUser->loginWithData($user);
//            sendSignupConfirmEmail($user);
//            $success = true;
//            header("Location: {$_SERVER['PHP_SELF']}?success=1");
//            exit();
//        }
//        else {
//            // server error!
//            $error = "Internal Server Error.";
//        }
//    }
//    else {
//        $error = implode(", ", $val_errors);
//    }
//
//}
//else {
//    session_reset();
//}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $uname = $_GET['uname'];
    $email = $_GET['email'];
    $user = $accessUser->getAllById($user_id);
    $success = true;
    $success = $success && ($user != null);
    $success = $success && (md5($user['uname']) == $uname);
    $success = $success && (md5($user['email']) == $email);
    if (!$success) {
        header("Location: 404.php");
    }
}
else {
    header("Location: 404.php");
}


?>
<script>document.getElementById("link-account").classList.add("active")</script>

<div class="content">
    <span class="noti">
        Thank you for confirmation of your, now you can login.
    </span>
</div>

<?php
include "footer.php"
?>
<!--JS-->
<!--<script type="text/javascript" src="js/login.js"></script>-->
</html>

