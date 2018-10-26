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
    <link rel="stylesheet" href="css/account.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

</head>

<?php

if ($user == null) {
    header("Location: 404.php");
}

include "header.php";


$accessMenu = new AccessMenu();
$accessOrders = new AccessOrders();
$accessAddress = new AccessAddress();
$accessCards = new AccessCreditCard();

if (isset($_POST['new_card'])) {
    $user_id = $user['id'];
    $data = array();
    foreach ($accessCards->allKeys as $key) {
        $data[$key] = $_POST[$key];
    }
    $data['user_id'] = $user_id;
    $accessCards->attrs = $data;
    if ($accessCards->insert()) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
    else {
        echo "<script> alert('Unable to add new card');</script>";
    }
}



$user = $GLOBALS['user'];
$all_menus = $accessMenu->getAll();
$user_carts = $accessOrders->getAllByConstraint("user_id={$user['id']}");
$credit_cards = $accessCards->getAllByConstraint("user_id={$user['id']}");
$address = $accessAddress->getAllByConstraint("user_id={$user['id']}");

$root_data = array(
    "user"=>$GLOBALS['user'],
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart'],
    "carts"=>$user_carts,
    "addresses"=>$address,
    "credit_cards"=>$credit_cards,
);
$json = json_encode($root_data);
echo "<script> var rootData = JSON.parse('". $json. "');</script>";
?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-account").classList.add("active")</script>


<div class="content">
    <div class="tab-wrapper">
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'info')" id="default-tab">User Profile</button>
            <button class="tablinks" onclick="openTab(event, 'credit_cards')">Credit Cards</button>
<!--            <button class="tablinks" onclick="openTab(event, 'carts')">Carts</button>-->
        </div>

        <div id="info" class="tabcontent">
            <div class="user-info-tab" id="user-tab-info">
<!--                <div class="info-row">-->
                <div class="info-panel profile">
                    <h2>Profile Setting - <?php echo $user['uname'];?></h2>
                    <form onsubmit="return false;">
                        <div class="row">
                            <label for="fname">First name</label>
                            <input type="text" id="fname" name="fname" placeholder="First name">
                        </div>
                        <div class="row">
                            <label for="lname">Last name</label>
                            <input type="text" id="lname" name="lname" placeholder="Last name">
                        </div>
                        <div class="row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="row">
                            <button class="button" id="update_user_info" name="update_user" onclick="updateUserInfo()">Update</button>
                        </div>
                    </form>
                </div>
                <div class="info-panel carts">
                    <h2>New Credit Card</h2>
                    <div class="cart-info">
                        <form action="account.php" method="post" onsubmit="return onSubmitNewCreditCard()">
                            <div class="row">
                                <label for="pay_name">Card Name</label>
                                <input type="text" id="pay_name" name="pay_name" placeholder="Card Name" required>
                            </div>
                            <div class="row">
                                <label for="pay_name">Card Number</label>
                                <input type="text" id="pay_card_num" name="pay_card_num" placeholder="Card Number" required>
                            </div>
                            <div class="row">
                                <label for="pay_card_expire">Expiry Date</label>
                                <input type="date" id="pay_card_expire" name="pay_card_expire" required>
                            </div>
                            <div class="row">
                                <button class="button" id="new_card" name="new_card">Add Credit Card</button>
                            </div>
                        </form>
<!--                        <button class="button" id="add_credit_card" name="update_user" onclick="updateUserInfo()">Update</button>-->
                    </div>
                </div>

            </div>
        </div>

        <div id="credit_cards" class="tabcontent">
            <div class="user-info-tab" id="user-tab-credit_cards">

            </div>
        </div>

<!--        <div id="carts" class="tabcontent">-->
<!--            <div class="user-info-tab" id="user-tab-carts">-->
<!---->
<!--            </div>-->
<!--        </div>-->


    </div>
</div>

<?php
include "footer.php"
?>

<!--JS-->
<script type="text/javascript" src="js/account.js"></script>
</html>
