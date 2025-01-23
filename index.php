<?php
session_start();

if (!isset($_SESSION['email']) && !isset($_SESSION['step'])) {
    header('Location: login.php');
}

if (isset($_SESSION['email']) && isset($_SESSION['step'])) {
    header('Location: verifyEmail.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shengjini Apartments</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous"/>
</head>
<body>

<div id="web">

<!-- Navbar Section -->
<?php include 'includes/navbar.php'; ?>

<!-- Home Page -->
<section id="home" class="main">
    <div class="main__container">
        <div class="main__content">
            <h1>Welcome to Shengjini Apartments!</h1>
            <h2>Scroll down to find your perfect holiday apartment :)</h2>
        </div>
    </div>
</section>


<!-- About Us Section -->
<section id="about" class="about__section">
    <div class="about__content">
        <div class="about__img__wrapper">
            <img src="assets/aboutus_img.jpg" alt="About" class="about__image">
        </div>
        <div class="about__details">
            <h2 class="about__title">About us</h2>
            <p class="text">Looking for the perfect seaside getaway? Shengjini Apartments has been providing
                top-quality apartments with stunning sea views for over 10 years.
                Our modern, comfortable spaces and exceptional service have delighted countless happy customers.
                Book your dream stay today and experience the best of Shëngjin!</p>
            <div class="social__link__list">
                <a class="social__link" href="https://www.instagram.com/shengjini_apartments/">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.facebook.com/shengjini_apartments/" class="social__link">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://www.tiktok.com/@shengjini_apartments" class="social__link">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Apartments Listing Section -->
<section id="apartments" class="apartments__section">
    <div class="apartments__container">
        <h2 class="apartments__title">Our Apartments</h2>
        <div class="apartments__cards">
            <div class="apartment__card apartment__card--sea-view">
                <div class="apartment__text">
                    <h3 class="apartment__name">Sea View Deluxe</h3>
                    <p class="apartment__description">Spacious 2-bedroom apartment with a stunning sea view. Fully furnished and perfect for families.</p>
                    <a href="apartment.php?id=1" class="apartment__button">Book Now</a>
                </div>
            </div>
            <div class="apartment__card apartment__card--cozy-beachfront">
                <div class="apartment__text">
                    <h3 class="apartment__name">Cozy Beachfront Studio</h3>
                    <p class="apartment__description">Modern studio apartment steps away from the beach. Ideal for couples or solo travelers.</p>
                    <a href="apartment.php?id=2" class="apartment__button">Book Now</a>
                </div>
            </div>
            <div class="apartment__card apartment__card--One-room-apartment">
                <div class="apartment__text">
                    <h3 class="apartment__name">One room apartment</h3>
                    <p class="apartment__description">Perfect view and commodity for a lovely couple.</p>
                    <a href="apartment.php?id=3" class="apartment__button">Book Now</a>
                </div>
            </div>
            <div class="apartment__card apartment__card--Lovebirds-apartment">
                <div class="apartment__text">
                    <h3 class="apartment__name">Lovebirds apartment</h3>
                    <p class="apartment__description">An apartment with everything that you need to make your stay comfortable and enjoyable.</p>
                    <a href="apartment.php?id=4" class="apartment__button">Book Now</a>
                </div>
            </div>
            <div class="apartment__card apartment__card--luxury-penthouse">
                <div class="apartment__text">
                    <h3 class="apartment__name">Luxury Penthouse</h3>
                    <p class="apartment__description">Top-floor penthouse with panoramic sea views and premium amenities. Perfect for a lavish stay.</p>
                    <a href="apartment.php?id=5" class="apartment__button" >Book Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer Section -->
<?php include 'includes/footer.php'; ?>
</div>
<script src="app.js"></script>

</body>
</html>