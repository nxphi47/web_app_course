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

$update_item_ok = true;
if (isset($_POST['change_item'])) {
    $data = $_POST;
    $item_id = $_POST['id'];
    $new_item = array(
            "title"=>$data['title'],
            "type"=>$data['type'],
            "price"=>$data['price'],
            "promoted_price"=>$data['promoted_price'],
            "desc"=>$data['desc'],
    );
    $update_item_ok = $accessMenu->updateById($item_id, $new_item);
    if ($update_item_ok) {
        header("Location: {$_SERVER['PHP_SELF']}");
        die();
    }
}


$all_menus = $accessMenu->getAll();
$all_carts = $accessOrders->getAll();


// get all order items
$accessOrderItem = new AccessOrderItems();
$results = $accessOrderItem->getAllByConstraintWithItem("1");
$report = $accessOrderItem->reportOnSales();

$root_data = array(
    "user"=>$GLOBALS['user'],
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart'],
    "carts"=>$all_carts,
    'report'=>$report,
);
$json = json_encode($root_data);
echo "<script> var rootData = JSON.parse('". $json. "');</script>";

if (!$update_item_ok) {
    $info = json_encode($new_item);
    echo "<script> alert('Update menu item failed!: {$info}'); </script>";
}
?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-admin").classList.add("active")</script>


<div class="content">
    <div class="tab-wrapper">
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'sales')" id="default-tab">Sales</button>
            <button class="tablinks" onclick="openTab(event, 'menu')" id="menu-tab">Menu</button>
            <button class="tablinks" onclick="openTab(event, 'carts')" id="carts-tab">Carts</button>
        </div>

        <div id="sales" class="tabcontent">
            <div class="admin-tab" id="admin-tab-sales">
                <ul class="admin-reports">
                    <li class="report">
                        <h3>Sales by Types</h3>
                        <table>
                            <tr>
                                <th>Food Type</th>
                                <th>Quantity</th>
                                <th>Sales ($) (Descending)</th>
                            </tr>
                            <?php
                            foreach ($report['type_report'] as $order) {
                                echo "
                                <tr>
                                    <td>{$order['type']}</td>                           
                                    <td>{$order['item_count']}</td>                           
                                    <td>{$order['sale']}</td>                           
                                </tr>
                                ";
                            }
                            echo "
                                <tr class=\"total\">
                                    <td>All types</td>                           
                                    <td>{$report['total_report'][0]['item_count']}</td>                           
                                    <td>{$report['total_report'][0]['sale']}</td>                           
                                </tr>
                                ";
                            ?>
                        </table>
                    </li>
                    <li class="report">
                        <h3>Sales by Products</h3>
                        <table>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Sales ($) (Descending)</th>
                            </tr>
                            <?php
                            foreach ($report['product_report'] as $order) {
                                echo "
                                <tr id=\"product-{$order['id']}\">
                                    <td>{$order['title']}</td>                           
                                    <td>{$order['type']}</td>                           
                                    <td>{$order['item_count']}</td>                           
                                    <td>{$order['sale']}</td>                           
                                </tr>
                                ";
                            }
                            ?>
                        </table>
                    </li>
                </ul>

            </div>
        </div>

        <div id="menu" class="tabcontent">
            <div class="admin-tab" id="admin-tab-menu">
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Price ($)</th>
                        <th>Promoted Price ($)</th>
                        <th>Description</th>
                        <th>Update</th>
                    </tr>
                    <?php
                    foreach ($all_menus as $order) {
                        echo "
                        <tr id=\"form-item-{$order['id']}\">
                            <form action='admin.php?tab=menu' method='post'>
                                <input type='hidden' value=\"{$order['id']}\" name='id'>
                                <td><input type='text' id=\"title-{$order['id']}\" name='title' value=\"{$order['title']}\"></td>
                                <td><input type='text' id=\"type-{$order['id']}\" name='type' value=\"{$order['type']}\"></td>
                                <td><input type='number' id=\"price-{$order['id']}\" name='price' value=\"{$order['price']}\"></td>
                                <td><input type='number' id=\"promoted_price-{$order['id']}\" name='promoted_price' value=\"{$order['promoted_price']}\"></td>
                                <td><textarea id=\"desc-{$order['id']}\" name='desc'>{$order['desc']}</textarea></td>
                                <td><input type='submit' class='button' name='change_item' value='Update' onclick=\"onsubmitItemChange({$order['id']})\"></td>
                            </form>
                        </tr>
                        ";
                    }
                    ?>
                </table>
            </div>
        </div>

        <div class="tabcontent" id="carts">
            <div class="admin-tab" id="admin-tab-menu">
                <table>
                    <tr>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total ($)</th>
                        <th>Address</th>
                        <th>Phone</th>
                    </tr>
                    <?php
                    foreach ($all_carts as $cart) {
                        $items_templates = array();
                        foreach ($cart['order_items'] as $order) {
                            array_push($items_templates, "
                            <tr>
                                <td>{$order['item']['title']}</td>
                                <td>{$order['quantity']}</td>
                                <td>{$order['comment']}</td>
                            </tr>
                            ");
                        }
                        $all_items_template = implode(" ", $items_templates);
                        $template = "
                        <tr>
                            <td>{$cart['pay_name']}</td>
                            <td>
                                <table class='admin-order-items'>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Comment</th>
                                    </tr>
                                    {$all_items_template}
                                </table>
                            </td>
                            <td>{$cart['total']}</td>
                            <td>{$cart['dev_address']}</td>
                            <td>{$cart['dev_phone']}</td>
                        </tr>
                        ";
                        echo $template;
                    }
                    ?>
                </table>
            </div>
        </div>

    </div>
</div>

<?php
include "footer.php"
?>

<!--JS-->
<script type="text/javascript" src="js/admin.js"></script>

<?php
if (isset($_GET['tab']) && in_array($_GET['tab'], ['default', 'menu', 'carts'])) {
    echo "<script>document.getElementById(\"{$_GET['tab']}-tab\").click();</script>";
}
?>


</html>
