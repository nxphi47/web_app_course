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
    <link rel="shortcut icon" href="imgs/favicon.ico">


</head>

<?php

include "header.php";

$accessMenu = new AccessMenu();
$accessFeedbacks = new AccessFeedbacks();
$all_menus = $accessMenu->getAll();
$all_feedbacks = $accessFeedbacks->getAll();

$root_data = array(
    "user"=>$GLOBALS['user'],
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart'],
    "feedback"=>$all_feedbacks
);
$json = json_encode($root_data);

//$all_menus['wwwwwww'] = 10;
//var_dump($all_menus);
echo "
<script>
    var rootData = JSON.parse('{$json}');
    var rootStr = '{$json}';
</script>";

?>
<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>


<script>document.getElementById("link-index").classList.add("active")</script>

<div class="content">

    <div class="slideshow-wrapper" id="slideshow-wrapper"></div>


    <div class="quote-slideshow-wrapper" id="quote-slideshow-wrapper"></div>

    <div class="item-slideshow-wrapper" id="item-slideshow-wrapper"></div>

</div>

<?php
include "footer.php"
?>
<!--JS-->
<script type="text/javascript" src="js/index.js"></script>
</html>
