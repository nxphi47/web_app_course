<?php

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
    <link rel="stylesheet" href="css/cart.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

</head>

<?php


include "header.php";

$accessMenu = new AccessMenu();
$accessCreditCards = new AccessCreditCard();
$accessAddress = new AccessAddress();


$all_menus = $accessMenu->getAll();
$user = $GLOBALS['user'];
$credit_cards = $accessCreditCards->getAllByConstraint("user_id={$user['id']}");
$addresses = $accessAddress->getAllByConstraint("user_id={$user['id']}");


$root_data = array(
    "user"=>$GLOBALS['user'],
    "credit_cards"=>$credit_cards,
    "addresses"=>$addresses,
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart']
);
$json = json_encode($root_data);
echo "<script> var rootData = JSON.parse('". $json. "');</script>";

?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-cart").classList.add("active")</script>


<div class="content">
    <div class="cart-wrapper">
        <div class="cart-content" id="cart-content-wrapper"></div>
        <div class="cart-summary" id="cart-summary">
            <div class="info" id="order">
                <h3>Order Summary</h3>
                <table>
                    <tr>
                        <td>Items</td>
                        <td id="orders_item"></td>
                    </tr>
                    <tr>
                        <td>Orders</td>
                        <td id="orders_subtotal"></td>
                    </tr>
                    <tr>
                        <td>Delivery</td>
                        <td id="delivery_subtotal"></td>
                    </tr>
                    <tr class="total">
                        <td>Total</td>
                        <td id="order_total"></td>
                    </tr>
                </table>
                <button class="button" id="checkout">Checkout</button>
            </div>

        </div>

    </div>

    <div id="modal-wrapper"></div>
    <div class="item-slideshow-wrapper" id="item-slideshow-wrapper"></div>
</div>

<?php
include "footer.php"
?>

<!--JS-->
<script type="text/javascript" src="js/cart.js"></script>
</html>
