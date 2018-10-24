<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/4/18
 * Time: 6:07 PM
 */

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
    <link rel="stylesheet" href="css/cart.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

    <script type="text/javascript" src="js/default.js"></script>
    <script type="text/javascript" src="js/globalParameter.js"></script>

    <script type="text/javascript" src="js/templates.js"></script>
</head>

<?php

include "header.php";

$accessMenu = new AccessMenu();
$all_menus = $accessMenu->getAll();

$root_data = array(
    "menu"=>$all_menus
);
$json = json_encode($root_data);
//echo $all_menus;
echo "<script> var rootData = JSON.parse('". $json. "');</script>";

?>
<script>document.getElementById("link-cart").classList.add("active")</script>


<div class="content">
    <div class="cart-wrapper">
        <div class="cart-summary" id="cart-summary">
            <div class="info" id="deliver">
                <h3>Delivery</h3>
                <form id="delivery" class="dev">
                    <div class="row">
                        <label for="dev_name">Name</label>
                        <input type="text" id="dev_name" name="dev_name" placeholder="Your name">
                    </div>
                    <div class="row">
                        <label for="dev_phone">Phone</label>
                        <input type="number" id="dev_phone" name="dev_phone" placeholder="e.g: 12345678">
                    </div>
                    <div class="row">
                        <label for="dev_address">Address</label>
                        <input type="text" id="dev_address" name="dev_address" placeholder="e.g: Block 39, NTU">
                    </div>
                    <div class="row">
                        <label for="postal">Postal</label>
                        <input type="text" id="postal" name="postal" placeholder="e.g: 637717">
                    </div>
                </form>

            </div>
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
        <div class="cart-content" id="cart-content-wrapper">
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
