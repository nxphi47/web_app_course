<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/3/18
 * Time: 9:32 PM
 */
session_start();


$GLOBALS['response'] = new stdClass();
$GLOBALS['response']->isSuccess = true;
$GLOBALS['response']->message = "";
$GLOBALS['response']->data = new stdClass(); // this will contain all data response

function errorResponse($mess)
{
    $GLOBALS['response']->isSuccess = false;
    $GLOBALS['response']->message = $GLOBALS['response']->message . "||<error>" . $mess . "\n ";
}

function appendResponse($mess)
{
    if (is_array($mess)) {
        $mess = json_encode($mess);
    }
    $GLOBALS['response']->message = $GLOBALS['response']->message . "||<info>" . $mess . "\n ";
}

function addDataResponse($data)
{
    $GLOBALS['response']->data = $data;
}


function outputResponseJSON()
{
    //for testing
//	print_r($GLOBALS['response']);
    echo json_encode($GLOBALS['response']);
}

function finishRequest($resData)
{
    addDataResponse($resData);
    outputResponseJSON();
    exit(1);
}


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
    }

} else {
    errorResponse("JSON request has nothing");
    addDataResponse($jsonPost);
    outputResponseJSON();
    exit(1);
}

?>