<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shengjini Apartments</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" /></head>
<body>
<!-- Navbar Section -->

<nav class="navbar">
    <div class="navbar__container">
        <img  src="assets/logo2.jpg"  alt="Your Logo">
        <a href="#home" id="navbar__logo">Shengjini apartments</a>
        <div class="navbar__toggle" id="mobile-menu">
            <span class="bar"></span> <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="#home" class="navbar__links" id="home-page">Home</a>
            </li>
            <li class="navbar__item">
                <a href="#about" class="navbar__links" id="about-page">About us</a>
            </li>
            <li class="navbar__item">
                <a href="#services" class="navbar__links" id="services-page">Apartments</a>
            </li>
            <li class="navbar__btn">
                <a href="#sign-up" class="button" id="signup">Sign Up</a>
            </li>
        </ul>
    </div>
</nav>

<!--home page-->
<section class="main">
    <div class="main__container">
        <div class="main__content">
            <h1>Welcome to Shengjini Apartments!</h1>
            <h2>Scroll down to find your perfect holiday apartment :)</h2>
        </div>
    </div>

</section>

<!--About us Section-->
<section class="about__section">
    <div class="about__content">
        <div class="about__img__wrapper">
            <img src="assets/aboutus_img.jpg" alt="About" class="about__image">
        </div>
        <div class="about__details">
            <h2 class="about__title">About us</h2>
            <p class="text">Looking for the perfect seaside getaway? Shengjini Apartments has been providing
                top-quality apartments with stunning sea views for over 10 years.
                Our modern, comfortable spaces and exceptional service have delighted countless happy customers.
                Book your dream stay today and experience the best of Shëngjin!
            </p>
            <div class="social__link__list">
                <a class="social__link" href="https://www.instagram.com/shengjini_apartments/" >
                    <i class="fab fa-instagram" ></i>
                </a>
                <a href="https://www.facebook.com/shengjini_apartments/" class="social__link">
                    <i class="fab fa-facebook" ></i>
                </a>
                <a href="https://www.tiktok.com/@shengjini_apartments" class="social__link">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>
    </div>
</section>


<script src="app.js"></script>
</body>
</html>