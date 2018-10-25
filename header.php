<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/3/18
 * Time: 8:52 PM
 */

$user = $GLOBALS['user'];

if ($user != null) {
    $template = '
    <li style="float: right">
        <a id="link-logout" href="logout.php">Logout</a>
    </li>
    <li style="float: right">
        <a id="link-account" href="account.php" class="logo">
            <img style="width: 41px;" src="imgs/user.png">
            <span class="acc-info">'.$user['uname'].'</span>
        </a>
    </li>
    ';
}
else {
    $template = '
    <li style="float: right">
        <a id="link-account" href="login.php" class="logo">
            <img style="width: 41px;" src="imgs/user.png">
            <span class="acc-info">Login/Signup</span>
        </a>
    </li>
    ';
}

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

            <?php echo $template ?>
            <li style="float: right">
                <a id="link-cart" href="cart.php" class="logo">
                    <img style="width: 41px;" src="imgs/cart.png">
                    <span class="num-items" id="num_items">10</span>
                </a>
            </li>
        </ul>
    </nav>
</header>
