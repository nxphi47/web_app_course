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
    <link rel="stylesheet" href="css/admin.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">
</head>

<?php

$user = $GLOBALS['user'];

if ($user == null || $user['admin'] != 1) {
    header("Location: 404.php");
}

include "header.php";


$accessMenu = new AccessMenu();
$accessOrders = new AccessOrders();
$accessAddress = new AccessAddress();
$accessCards = new AccessCreditCard();





$all_menus = $accessMenu->getAll();
$all_carts = $accessOrders->getAll();


$root_data = array(
    "user"=>$GLOBALS['user'],
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart'],
    "carts"=>$all_carts,
);
$json = json_encode($root_data);
echo "<script> var rootData = JSON.parse('". $json. "');</script>";
?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-admin").classList.add("active")</script>


<div class="content">
    <div class="tab-wrapper">
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'sales')" id="default-tab">Sales</button>
            <button class="tablinks" onclick="openTab(event, 'menu')">Menu</button>
        </div>

        <div id="sales" class="tabcontent">
            <div class="admin-tab" id="admin-tab-sales">
                sale..
            </div>
        </div>

        <div id="menu" class="tabcontent">
            <div class="admin-tab" id="admin-tab-menu">
                menu..
            </div>
        </div>


    </div>
</div>

<?php
include "footer.php"
?>

<!--JS-->
<script type="text/javascript" src="js/admin.js"></script>
</html>
