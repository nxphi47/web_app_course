<?php

require_once "db_connect.php";
require_once "request.php";

session_start();

require_once "../session_init.php";



// ----- JSON POST REQUEST --------

$jsonStr = file_get_contents("php://input");
$jsonStr = str_replace('\n', ' ', $jsonStr);
$jsonStr = str_replace('\r', ' ', $jsonStr);
$jsonPost = json_decode($jsonStr, true);


if (is_array($jsonPost) && array_key_exists("request", $jsonPost)) {
    $request = $jsonPost['request'];
    $data = $jsonPost['data'];


    switch ($request) {
        case "default":
            finishRequest(['response' => "testing"]);
            break;
        case "get_user":
            finishRequest([
                ['id'=>1, 'name'=>'xuan phi'],
                ['id'=>2, 'name'=>'xuaasdasdasdn phi']]);
            break;
        case "add_to_cart":
            $accessOrder = new AccessOrders();
            $accessUser = new AccessUsers();
            $user = $accessUser->autoLogin();

            $cart = $accessOrder->updateCurrentCart($data, $user);
            $_SESSION['cart'] = $cart;
            finishRequest($cart);
            break;
        case "checkout":
            $accessOrder = new AccessOrders();
            $accessUser = new AccessUsers();
            $out = $accessOrder->checkout($data);
            if ($GLOBALS['response']->isSuccess) {
                unset($_SESSION['cart']);
            }
            finishRequest($out);
            break;
        case "update_user_info":
            $user = $accessUser->autoLogin();
            if ($user['id'] == $data['id']) {
                unset($data['id']);
                $accessUser->updateById($user['id'], $data);
                finishRequest($accessUser->getAllById($user['id']));
            }
            else {
                errorResponse("User info invalid");
                finishRequest(false);
            }
            break;
    }

} else {
    errorResponse("JSON request has nothing");
    addDataResponse($jsonPost);
    outputResponseJSON();
    exit(1);
}

?>