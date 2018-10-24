<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/3/18
 * Time: 8:52 PM
 */


?>

<header>
    <nav class="navbar">
        <ul class="nav">
            <li><a href="index.php" class="logo"><img style="width: 41px;" src="imgs/logo.png"></a></li>
            <li><a id="link-index" href="index.php">Home</a></li>
            <li><a id="link-menu" href="menu.php">Menu</a></li>
            <li><a id="link-promotions" href="promotions.php">Promotions</a></li>
            <li><a id="link-about" href="about.php">About</a></li>

            <li><a id="link-about" href="test.php" target="_blank">Testing</a></li>

            <li style="float: right">
<!--                <a id="link-account" href="account.php" class="logo">-->
                <a id="link-account" href="login.php" class="logo">
                    <img style="width: 41px;" src="imgs/user.png">
                </a>
            </li>
            <li style="float: right">
                <a id="link-cart" href="cart.php" class="logo">
                    <img style="width: 41px;" src="imgs/cart.png">
                    <span class="num-items" id="num_items">10</span>
                </a>
            </li>
        </ul>
    </nav>
</header>
