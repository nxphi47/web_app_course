<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/25/18
 * Time: 12:57 PM
 */

// include libraries
require_once "php/db_connect.php";
require_once "php/request.php";

//session_start();

$accessUser = new AccessUsers();
$accessOrders = new AccessOrders();
$user = $accessUser->autoLogin();

$GLOBALS['user'] = $user;

$user_id = ($user != null) ? $user['id'] : 0;

//if ($user_id != 0) {
//    $_SESSION['cart'] = $accessOrders->getUnpaidCartByUser($user_id);
//}
////else {
//if (isset($_SESSION['cart'])) {
////        $cart_id = $_SESSION['cart']['cart_id'];
////        $cart = $accessOrders->getAllById($cart_id);
//}
//else {
////        $cart = $accessOrders->getUnpaidCartByUser($user_id);
//    $cart = $accessOrders->createNew(0);
//    $cart['user_id'] = $user_id;
//    $_SESSION['cart'] = $cart;
//}
//}

if (!isset($_SESSION['cart'])) {
    $cart = $accessOrders->createNew($user_id);
    $_SESSION['cart'] = $cart;
}

$GLOBALS['cart'] = $_SESSION['cart'];
?>




