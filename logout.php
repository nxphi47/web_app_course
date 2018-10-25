<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/25/18
 * Time: 12:49 PM
 */


// include libraries
require_once "php/db_connect.php";
require_once "php/request.php";

session_start();

session_unset();

$accessUser = new AccessUsers();

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;

?>