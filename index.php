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

session_start()

?>

<html>
<head>
    <title>Pizzarino</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/default.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

    <script type="text/javascript" src="js/default.js"></script>
    <script type="text/javascript" src="js/globalParameter.js"></script>

    <script type="text/javascript" src="js/templates.js"></script>
</head>

<?php

include "session_init.php";
include "header.php";

$accessMenu = new AccessMenu();
$all_menus = $accessMenu->getAll();

$root_data = array(
    "menu" => $all_menus
);
$json = json_encode($root_data);

echo "
<script>
    var rootData = JSON.parse('{$json}');
</script>";

?>
<script>document.getElementById("link-index").classList.add("active")</script>

<div class="content">

    <div class="slideshow-wrapper" id="slideshow-wrapper"></div>

    <div class="quote-slideshow-wrapper" id="quote-slideshow-wrapper"></div>

    <div class="item-slideshow-wrapper" id="item-slideshow-wrapper"></div>

    <div class="item-list-wrapper" id="item-list-wrapper"></div>

</div>

<?php
include "footer.php"
?>
<!--JS-->
<script type="text/javascript" src="js/index.js"></script>
</html>
