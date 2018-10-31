<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/3/18
 * Time: 8:44 PM
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
    <link rel="stylesheet" href="css/about.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

</head>

<?php

include "header.php";


if (isset($_POST['career'])) {
    $data = $_POST;
    $accessJob = new AccessJobApp();
    $accessJob->attrs = $data;
    $job_ok = $accessJob->insert();
    if ($job_ok) {
        echo "<script>
            alert('Thank you for your job application! Our recruiters will reach you soon.');
            window.location.href = '{$_SERVER['PHP_SELF']}';
        </script>";
    }
    else {
        echo "<script>
            alert('Sorry! There was an error from the system.');
        </script>";
    }
}
else if (isset($_POST['contact'])) {
    $data = $_POST;
    $accessQuestion = new AccessQuestions();
    $accessQuestion->attrs = $data;
    $q_ok = $accessQuestion->insert();
    if ($q_ok) {
        echo "<script>
            alert('Thank you for your questions! We will response to you soon.');
            window.location.href = '{$_SERVER['PHP_SELF']}';
        </script>";
    }
    else {
        echo "<script>
            alert('Sorry! There was an error from the system.');
        </script>";
    }
}


$accessMenu = new AccessMenu();
$all_menus = $accessMenu->getAll();

$root_data = array(
    "menu"=>$all_menus,
    "cart"=>$GLOBALS['cart']
);
$json = json_encode($root_data);
echo "<script> var rootData = JSON.parse('". $json. "');</script>";
?>

<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="js/globalParameter.js"></script>
<script type="text/javascript" src="js/templates.js"></script>

<script>document.getElementById("link-about").classList.add("active")</script>

<div class="content">

    <div class="tab-wrapper">
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'about_us')" id="default-tab">About Us</button>
            <button class="tablinks" onclick="openTab(event, 'faq')" id="faq-tab">FAQ</button>
            <button class="tablinks" onclick="openTab(event, 'careers')" id="careers-tab">Careers</button>
            <button class="tablinks" onclick="openTab(event, 'contact')" id="contact-tab">Contact</button>
        </div>

        <div id="about_us" class="tabcontent">
<!--            <div class="item-list-wrapper" id="item-list-wrapper-all"></div>-->
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

        </div>

        <div id="faq" class="tabcontent">
<!--            <div class="item-list-wrapper" id="item-list-wrapper-pizza"></div>-->
            FAQ here
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>

        <div id="careers" class="tabcontent">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validateCareer();">
                <div class="row">
                    <label for="fname">First name</label>
                    <input type="text" id="fname" name="fname" placeholder="First name" required>
                </div>
                <div class="row">
                    <label for="lname">Last name</label>
                    <input type="text" id="lname" name="lname" placeholder="Last name" required>
                </div>
                <div class="row">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="row">
                    <label for="ic">NRIC/FIN</label>
                    <input type="text" id="ic" name="ic" placeholder="e.g: G123456W" required>
                </div>
                <div class="row">
                    <label for="phone">Phone Number</label>
                    <input type="number" id="phone" name="phone" placeholder="e.g: 12345678 (8 digits)" required>
                </div>
                <div class="row">
                    <label for="experience">Experience</label>
                    <textarea id="experience" name="experience" placeholder="e.g: Must write your past experience"></textarea>
                </div>

                <div class="row">
                    <button class="button" type="submit" id="career" name="career">Submit Application</button>
                </div>
            </form>
        </div>

        <div id="contact" class="tabcontent">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validateContact();">
                <div class="row">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="row">
                    <label for="user_email">Email</label>
                    <input type="email" id="user_email" name="user_email" placeholder="Email" required>
                </div>
                <div class="row">
                    <label for="question">Questions</label>
                    <textarea id="question" name="question" placeholder="e.g: your questions"></textarea>
                </div>

                <div class="row">
                    <button class="button" type="submit" id="contact" name="career">Submit Question</button>
                </div>
            </form>
        </div>

    </div>


</div>

<?php
include "footer.php"
?>
<!--JS-->
<script type="text/javascript" src="js/about.js"></script>

<?php
if (isset($_GET['tab']) && in_array($_GET['tab'], ['default', 'faq', 'careers', 'contact'])) {
    echo "<script>document.getElementById(\"{$_GET['tab']}-tab\").click();</script>";
}
?>

</html>
