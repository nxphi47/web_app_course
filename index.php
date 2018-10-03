<?php
/**
 * Created by PhpStorm.
 * User: nxphi47
 * Date: 10/3/18
 * Time: 8:44 PM
 */

// include libraries

session_start()

?>

<html>
<head>
    <title>Amino Pizza</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/default.css">

    <link rel="shortcut icon" href="imgs/favicon.ico">

    <script type="text/javascript" src="js/default.js"></script>
    <script type="text/javascript" src="js/globalParameter.js"></script>

    <script type="text/javascript" src="js/templates.js"></script>
</head>

<?php

include "header.php"
?>
<script>document.getElementById("link-index").classList.add("active")</script>

<div class="content">

    <div class="slideshow-wrapper" id="slideshow-wrapper">
        <div class="slideshow">
            <div class="slide fade">
                <div class="number-text">1 / 3</div>
                <img class="slide-img" src="imgs/pizza_test.jpg">
                <div class="caption">Caption Text 1</div>
            </div>

            <div class="slide fade">
                <div class="number-text">2 / 3</div>
                <img class="slide-img" src="imgs/pizza_test_2.jpeg">
                <div class="caption">Caption Text 2</div>
            </div>

            <div class="slide fade">
                <div class="number-text">3 / 3</div>
                <img class="slide-img" src="imgs/pizza_test.jpg">
                <div class="caption">Caption Text 3</div>
            </div>

            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>

    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("slide");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }
    </script>

    <div class="item-list-wrapper" id="item-list-wrapper"></div>

    <br>

</div>

<?php
include "footer.php"
?>
<!--JS-->
<script type="text/javascript" src="js/index.js"></script>
</html>
