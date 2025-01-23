document.addEventListener("DOMContentLoaded", () => {

    const menu = document.querySelector('#mobile-menu');
    const menuLinks = document.querySelector('.navbar__menu');
    const navLogo = document.querySelector('#navbar__logo');

// Display Mobile Menu
    const mobileMenu = () => {
        menu.classList.toggle('is-active');
        menuLinks.classList.toggle('active');
    };

    menu.addEventListener('click', mobileMenu);

    const carouselInner = document.querySelector(".carousel__inner");
    const images = document.querySelectorAll(".carousel__image");
    const prevButton = document.querySelector(".carousel__button--prev");
    const nextButton = document.querySelector(".carousel__button--next");

    let currentIndex = 0;

    function updateCarousel() {
        const offset = -currentIndex * images[0].clientWidth;
        carouselInner.style.transform = `translateX(${offset}px)`;
    }

    prevButton.addEventListener("click", () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
        updateCarousel();
    });

    nextButton.addEventListener("click", () => {
        currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
        updateCarousel();
    });

    // Adjust the carousel on window resize
    window.addEventListener("resize", updateCarousel);
})

