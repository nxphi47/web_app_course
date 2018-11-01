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
<!--    <hr>-->
<!--    <br>-->
<!--    © Pizzarino<br>-->
    <div class="footer-list info">
        <h4 class="info">Pizzarino</h4>
        <p class="info">
            We are the best pizza store in the world asdmaf ask fklsa fasklf saklf aslk falsk fkl asklf as.
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
        <li><a class="generic-anchor footer-list-anchor" href="about.php?tab=career">Careers</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="about.php?tab=contact">Contact</a></li>
    </ul>
    <ul class="footer-list">
        <li><h4>Menu</h4></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php">All</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php?tab=pizza">Pizza</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php?tab=pasta">Pasta</a></li>
        <li><a class="generic-anchor footer-list-anchor" href="menu.php?tab=beverage">Beverage</a></li>
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
<!--<footer class="flex-rw">-->
<!---->
<!--    <ul class="footer-list-top">-->
<!--        <li>-->
<!--            <h4 class="footer-list-header">About Pavilion</h4></li>-->
<!--        <li><a href='/shop/about-mission' class="generic-anchor footer-list-anchor" itemprop="significantLink">GET TO KNOW US</a></li>-->
<!--        <li><a href='/promos.html' class="generic-anchor footer-list-anchor" itemprop="significantLink">PROMOS</a></li>-->
<!--        <li><a href='/retailers/new-retailers.html' class="generic-anchor footer-list-anchor" itemprop="significantLink">BECOME A RETAILER</a></li>-->
<!---->
<!--        <li><a href='/job-openings.html' itemprop="significantLink" class="generic-anchor footer-list-anchor">JOB OPENINGS</a></li>-->
<!---->
<!--        <li><a href='/shop/about-show-schedule' class="generic-anchor footer-list-anchor" itemprop="significantLink">EVENTS</a></li>-->
<!--    </ul>-->
<!--    <ul class="footer-list-top">-->
<!--        <li>-->
<!--            <h4 class="footer-list-header">The Gift Selection</h4></li>-->
<!---->
<!---->
<!--        <li><a href='/Angels/cat/id/70' class="generic-anchor footer-list-anchor">ANGEL FIGURINES</a></li>-->
<!--        <li><a href='/Home-Decor/cat/id/64' class="generic-anchor footer-list-anchor">HOME DECOR</a></li>-->
<!--        <li><a href='/Mugs/cat/id/32' class="generic-anchor footer-list-anchor">MUGS</a></li>-->
<!--        <li><a href='/Pet-Lover/cat/id/108' class="generic-anchor footer-list-anchor">PET LOVER</a></li>-->
<!--        <li><a href='/Ladies-Accessories/cat/id/117' class="generic-anchor footer-list-anchor" target="_blank">HANDBAGS & JEWELRY</a></li>-->
<!--    </ul>-->
<!--    <ul class="footer-list-top">-->
<!--        <li id='help'>-->
<!--            <h4 class="footer-list-header">Please Help Me</h4></li>-->
<!--        <li><a href='/shop/about-contact' class="generic-anchor footer-list-anchor" itemprop="significantLink">CONTACT</a></li>-->
<!--        <li><a href='/faq.html' class="generic-anchor footer-list-anchor" itemprop="significantLink">FAQ</a></li>-->
<!--        <li id='find-a-store'><a href='/shop/store-locator' class="generic-anchor footer-list-anchor" itemprop="significantLink">STORE LOCATOR</a></li>-->
<!--        <li id='user-registration'><a href='/shop/user-registration?URL=' class="generic-anchor footer-list-anchor" itemprop="significantLink">NEW USERS</a></li>-->
<!--        <li id='order-tracking'><a href='/shop/order-status' itemprop="significantLink" class="generic-anchor footer-list-anchor">ORDER STATUS</a></li>-->
<!--    </ul>-->
<!--    <section class="footer-social-section flex-rw">-->
<!--      <span class="footer-social-overlap footer-social-connect">-->
<!--      CONNECT <span class="footer-social-small">with</span> US-->
<!--      </span>-->
<!--        <span class="footer-social-overlap footer-social-icons-wrapper">-->
<!--      <a href="https://www.pinterest.com/paviliongift/" class="generic-anchor" target="_blank" title="Pinterest" itemprop="significantLink"><i class="fa fa-pinterest"></i></a>-->
<!--      <a href="https://www.facebook.com/paviliongift" class="generic-anchor" target="_blank" title="Facebook" itemprop="significantLink"><i class="fa fa-facebook"></i></a>-->
<!--      <a href="https://twitter.com/PavilionGiftCo" class="generic-anchor" target="_blank" title="Twitter" itemprop="significantLink"><i class="fa fa-twitter"></i></a>-->
<!--      <a href="http://instagram.com/paviliongiftcompany" class="generic-anchor" target="_blank" title="Instagram" itemprop="significantLink"><i class="fa fa-instagram"></i></a>-->
<!--      <a href="https://www.youtube.com/channel/UCYgUODvd0qXbu_LkUWpTVEg" class="generic-anchor" target="_blank" title="Youtube" itemprop="significantLink"><i class="fa fa-youtube"></i></a>-->
<!--      <a href="https://plus.google.com/+Paviliongift/posts" class="generic-anchor" target="_blank" title="Google Plus" itemprop="significantLink"><i class="fa fa-google-plus"></i></a>-->
<!--      </span>-->
<!--    </section>-->
<!--    <section class="footer-bottom-section flex-rw">-->
<!--        <div class="footer-bottom-wrapper">-->
<!--            <i class="fa fa-copyright" role="copyright">-->
<!---->
<!--            </i> 2015 Pavilion in <address class="footer-address" role="company address">Bergen, NY</address><span class="footer-bottom-rights"> - All Rights Reserved - </span>-->
<!--        </div>-->
<!--        <div class="footer-bottom-wrapper">-->
<!--            <a href="/terms-of-use.html" class="generic-anchor" rel="nofollow">Terms</a> | <a href="/privacy-policy.html" class="generic-anchor" rel="nofollow">Privacy</a>-->
<!--        </div>-->
<!--    </section>-->
<!--</footer>-->



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