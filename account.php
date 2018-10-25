<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/4/18
 * Time: 6:07 PM
 */

// include libraries
require_once "php/db_connect.php";
require_once "php/request.php";

session_start();
include "session_init.php";

?>

<html>
<head>
    <title>Pizzarino</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/account.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

</head>

<?php

include "session_init.php";
include "header.php";

$accessMenu = new AccessMenu();
$all_menus = $accessMenu->getAll();

$root_data = array(
    "user"=>$GLOBALS['user'],
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart']
);
$json = json_encode($root_data);
echo "<script> var rootData = JSON.parse('". $json. "');</script>";
?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-account").classList.add("active")</script>


<div class="content">
    Account works
</div>

<?php
include "footer.php"
?>

<!--JS-->
<script type="text/javascript" src="js/account.js"></script>
</html>
