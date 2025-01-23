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
                <a href="#apartments" class="navbar__links" id="services-page">Apartments</a>
            </li>

            <?php
            if (!isset($_SESSION['email'])) {
                ?>
                <li class="navbar__btn">
                    <a href="register.html" class="nav__button" id="signup">Sign Up</a>
                </li>
                <?php
            } else{
                ?>
                <li class="navbar__btn">
                    <a href="logout.php" class="nav__button" id="signOut">Sign Out</a>
                </li>
            <?php
            }
            ?>

        </ul>
    </div>
</nav>