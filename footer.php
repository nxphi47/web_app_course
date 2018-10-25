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
    <hr>
<!--    <br>-->
<!--    <br>-->
    <br>
    © Pizzarino<br>

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