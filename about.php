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
include "session_init.php";

?>

<html>
<head>
    <title>Pizzarino</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/about.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

</head>

<?php

include "header.php";
$accessMenu = new AccessMenu();
$all_menus = $accessMenu->getAll();

$root_data = array(
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart']
);
$json = json_encode($root_data);
echo "<script> var rootData = JSON.parse('". $json. "');</script>";
?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-about").classList.add("active")</script>

<div class="content">

    <div class="tab-wrapper">
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'about_us')" id="default-tab">About Us</button>
            <button class="tablinks" onclick="openTab(event, 'faq')">FAQ</button>
            <button class="tablinks" onclick="openTab(event, 'careers')">Careers</button>
            <button class="tablinks" onclick="openTab(event, 'contact')">Contact</button>
        </div>

        <div id="about_us" class="tabcontent">
<!--            <div class="item-list-wrapper" id="item-list-wrapper-all"></div>-->
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

        </div>

        <div id="faq" class="tabcontent">
<!--            <div class="item-list-wrapper" id="item-list-wrapper-pizza"></div>-->
            FAQ here
        </div>

        <div id="careers" class="tabcontent">
<!--            <div class="item-list-wrapper" id="item-list-wrapper-pasta"></div>-->
            CARREER HERE
        </div>

        <div id="contact" class="tabcontent">
<!--            <div class="item-list-wrapper" id="item-list-wrapper-beverage"></div>-->
            contact here
        </div>

    </div>


</div>

<?php
include "footer.php"
?>
<!--JS-->
<script type="text/javascript" src="js/about.js"></script>
</html>
