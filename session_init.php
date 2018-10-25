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
$user = $accessUser->autoLogin();


$GLOBALS['user'] = $user;

if (isset($_SESSION['cart'])) {
    $GLOBALS['cart'] = $_SESSION['cart'];
}



?>




