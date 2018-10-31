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
//    <input type='hidden' value=\"{$item['id']}\" name='id'>
//    <td><input type='text' id=\"title-{$item['id']}\" name='title' value=\"{$item['title']}\"></td>
//    <td><input type='text' id=\"type-{$item['id']}\" name='type' value=\"{$item['type']}\"></td>
//    <td><input type='number' id=\"price-{$item['id']}\" name='price' value=\"{$item['price']}\"></td>
//    <td><input type='number' id=\"promoted_price-{$item['id']}\" name='promoted_price' value=\"{$item['promoted_price']}\"></td>
//    <td><input type='text' id=\"desc-{$item['id']}\" name='desc' value=\"{$item['desc']}\"></td>
//    <td><input type='submit' class='button' value='change_item' onclick=\"onsubmitItemChange({$item['id']})\"></td>
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
                            foreach ($report['type_report'] as $item) {
                                echo "
                                <tr>
                                    <td>{$item['type']}</td>                           
                                    <td>{$item['item_count']}</td>                           
                                    <td>{$item['sale']}</td>                           
                                </tr>
                                ";
                            }
                            echo "
                                <tr>
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
                            foreach ($report['product_report'] as $item) {
                                echo "
                                <tr id=\"product-{$item['id']}\">
                                    <td>{$item['title']}</td>                           
                                    <td>{$item['type']}</td>                           
                                    <td>{$item['item_count']}</td>                           
                                    <td>{$item['sale']}</td>                           
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
<!--                    <caption>Menu changes</caption>-->
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Price ($)</th>
                        <th>Promoted Price ($)</th>
                        <th>Description</th>
                        <th>Update</th>
                    </tr>
                    <?php
                    foreach ($all_menus as $item) {
                        echo "
                        <tr id=\"form-item-{$item['id']}\">
                            <form action='admin.php?tab=menu' method='post'>
                                <input type='hidden' value=\"{$item['id']}\" name='id'>
                                <td><input type='text' id=\"title-{$item['id']}\" name='title' value=\"{$item['title']}\"></td>
                                <td><input type='text' id=\"type-{$item['id']}\" name='type' value=\"{$item['type']}\"></td>
                                <td><input type='number' id=\"price-{$item['id']}\" name='price' value=\"{$item['price']}\"></td>
                                <td><input type='number' id=\"promoted_price-{$item['id']}\" name='promoted_price' value=\"{$item['promoted_price']}\"></td>
                                <td><textarea id=\"desc-{$item['id']}\" name='desc'>{$item['desc']}</textarea></td>
                                <td><input type='submit' class='button' name='change_item' value='Update' onclick=\"onsubmitItemChange({$item['id']})\"></td>
                            </form>
                        </tr>
                        ";
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
if (isset($_GET['tab']) && in_array($_GET['tab'], ['default', 'menu'])) {
    echo "<script>document.getElementById(\"{$_GET['tab']}-tab\").click();</script>";
}
?>


</html>
