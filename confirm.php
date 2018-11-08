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
    else {
        $user['confirm'] = 1;
        $user_id = $user['id'];
        $accessUser->updateById($user_id, array('confirm'=>1));
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
</html>

