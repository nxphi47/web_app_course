<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/3/18
 * Time: 8:53 PM
 */
?>

<button onclick="topFunction()" class="button to-top" id="toTop" title="Go to top">
    <img src="imgs/up.png" alt="Top" width="30">
</button>
<footer>
    <div class="footer-list info">
        <h4 class="info">Pizzarino</h4>
        <p class="info">
            We serve the best pizzas locally. Come try our dishes a la carte or as a set. Do check out our promotions for some great deals!
        </p>
        <div class="contact-info-wrapper">
            <div class="contact-info">
                <img src="imgs/geo.png" alt="" height="30" width="30">
                <p><span>50 Nanyang Avenue, Singapore 123456</span></p>
            </div>
            <div class="contact-info">
                <img src="imgs/phone.png" alt="" height="30" width="30">
                <p><span>12345678</span></p>
            </div>
            <div class="contact-info">
                <img src="imgs/mail.png" alt="" height="30" width="30">
                <p><span><a href="mailto:f38ee@localhost">f38ee@localhost</a></span></p>
            </div>


        </div>
    </div>
    <ul class="footer-list">
        <li><h4>About</h4></li>
        <li><a class="generic-anchor footer-list-anchor" href="about.php">About us</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="about.php?tab=faq">FAQ</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="about.php?tab=careers">Careers</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="about.php?tab=contact">Contact</a></li>
    </ul>
    <ul class="footer-list">
        <li><h4>Menu</h4></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php">All</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php?tab=pizza">Pizza</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php?tab=pasta">Pasta</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php?tab=beverage">Beverage</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php?tab=promotion">Promotions</a></li>
    </ul>
    <ul class="footer-list">
        <li><h4>Account</h4></li>
        <?php
        if ($GLOBALS['user'] != null) {
            echo "<li><a class=\"generic-anchor footer-list-anchor\" href=\"account.php\">Account</a></li>";
            echo "<li><a class=\"generic-anchor footer-list-anchor\" href=\"login.php\">Sign out</a></li>";
        }
        else {
            echo "<li><a class=\"generic-anchor footer-list-anchor\" href=\"login.php\">Sign in / Sign Up</a></li>";
        }
        ?>
        <li><a class="generic-anchor footer-list-anchor" href="cart.php">Cart</a></li>
    </ul>
</footer>


<script>
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("toTop").style.display = "block";
        } else {
            document.getElementById("toTop").style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>