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
    <li class="nav-link link-right">
        <a id="link-logout" href="logout.php">Logout</a>
    </li>
    <li class="nav-link link-right">
        <a id="link-account" href="account.php" class="logo">
            <img style="width: 41px;" src="imgs/user.png">
            <div class="acc-info">
                <span class="acc-info">' . $user['uname'] . '</span>
            </div>
            
        </a>
    </li>
    ';

    $template_admin = '<li class="nav-link"><a id="link-admin" href="admin.php">Admin</a></li>';
} else {
    $template = '
    <li class="nav-link link-right">
        <a id="link-account" href="login.php" class="logo">
            <img style="width: 41px;" src="imgs/user.png">
            <span class="acc-info">Login/Signup</span>
        </a>
    </li>
    ';
    $template_admin = '';
}

?>

<header>
    <nav class="navbar" id="navbar">
        <ul class="nav">
            <li class="nav-link"><a href="index.php" class="logo"><img style="width: 41px;" src="imgs/logo.png"></a></li>
            <li class="nav-link"><a id="link-index" href="index.php">Home</a></li>
            <li class="nav-link"><a id="link-menu" href="menu.php">Menu</a></li>
            <li class="nav-link"><a id="link-promotions" href="promotions.php">Promotions</a></li>
            <li class="nav-link"><a id="link-about" href="about.php">About</a></li>



            <?php echo $template_admin ?>
            <?php echo $template ?>
            <li class="nav-link link-right">
                <a id="link-cart" href="cart.php" class="logo">
                    <img style="width: 41px;" src="imgs/cart.png">
                    <div class="cart-label-info">
                        <span class="num-items" id="num_items"></span> &nbsp;|&nbsp;
                        <span class="total-price" id="total_price">$0</span>
                    </div>

                </a>
            </li>

            <li class="icon">
                <a href="javascript:void(0);" class="icon" onclick="responsiveNavBar()">
                    <!--                    <i class="fa fa-bars"></i>-->
                    <img style="width: 41px;" src="imgs/bars.png">
                </a>
            </li>

        </ul>
    </nav>
</header>

<script>
    function responsiveNavBar() {
        var x = document.getElementById("navbar");
        if (x.className === "navbar") {
            x.className += " nav-responsive";
        } else {
            x.className = "navbar";
        }
        console.log(x);
        console.log(x.className);
    }
</script>
