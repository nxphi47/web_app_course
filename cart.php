<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/4/18
 * Time: 6:07 PM
 */
session_start()

?>

<html>
<head>
    <title>Amino Pizza</title>
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

include "header.php"
?>
<script>document.getElementById("link-cart").classList.add("active")</script>


<div class="content">
    <div class="cart-wrapper">
        <div class="cart-summary" id="cart-summary">
            <h4>Order Summary</h4>
            <table>
                <tr>
                    <td>Orders</td>
                    <td id="orders_subtotal"></td>
                </tr>
                <tr>
                    <td>Delivery</td>
                    <td id="delivery_subtotal"></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td id="order_total"></td>
                </tr>
            </table>
        </div>
        <div class="cart-content" id="cart-content-wrapper">
        </div>
    </div>
</div>

<?php
include "footer.php"
?>

<!--JS-->
<script type="text/javascript" src="js/cart.js"></script>
</html>
