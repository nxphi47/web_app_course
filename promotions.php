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

?>

<script>document.getElementById("link-promotions").classList.add("active")</script>

<div class="content">


</div>

<?php
include "footer.php"
?>
<!--JS-->
<!--<script type="text/javascript" src="js/index.js"></script>-->
</html>
