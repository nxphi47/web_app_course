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
    <link rel="stylesheet" href="css/menu.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

</head>

<?php

include "header.php";


// get user information

// load all menu here
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

<script>document.getElementById("link-menu").classList.add("active")</script>

<div class="content">

    <div class="tab-wrapper">
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'all')" id="default-tab">All</button>
            <button class="tablinks" onclick="openTab(event, 'pizza')">Pizza</button>
            <button class="tablinks" onclick="openTab(event, 'pasta')">Pasta</button>
            <button class="tablinks" onclick="openTab(event, 'beverage')">Beverage</button>

            <form class="search" onsubmit="return false;">
                <input type="text" id="search_input" placeholder="Search.." name="search"
                       onkeyup="onSearch()"
                >
                <button type="button" class="button" onclick="onSearch()">
                    <img src="imgs/search.png" alt="Search" width="20">
                </button>
            </form>
        </div>

        <div id="all" class="tabcontent">
            <div class="item-list-wrapper" id="item-list-wrapper-all"></div>
        </div>

        <div id="pizza" class="tabcontent">
            <div class="item-list-wrapper" id="item-list-wrapper-pizza"></div>
        </div>

        <div id="pasta" class="tabcontent">
            <div class="item-list-wrapper" id="item-list-wrapper-pasta"></div>
        </div>

        <div id="beverage" class="tabcontent">
            <div class="item-list-wrapper" id="item-list-wrapper-beverage"></div>
        </div>

    </div>


</div>

<?php
include "footer.php"
?>
<!--JS-->
<script type="text/javascript" src="js/menu.js"></script>
</html>
