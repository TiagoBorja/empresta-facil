document.addEventListener('DOMContentLoaded', function () {
    const multipleCardCarousel = document.querySelector("#carouselExampleControls");
    const carouselInner = multipleCardCarousel.querySelector(".carousel-inner");
    const nextBtn = multipleCardCarousel.querySelector(".carousel-control-next");
    const prevBtn = multipleCardCarousel.querySelector(".carousel-control-prev");
    let carousel, scrollPosition = 0;
    let cardWidth, carouselWidth, maxScrollPosition;
    let totalItems = multipleCardCarousel.querySelectorAll(".carousel-item").length;
    const cardsVisible = 3; // quantos cards aparecem visíveis simultaneamente

    function updateSizes() {
        cardWidth = multipleCardCarousel.querySelector(".carousel-item").offsetWidth;
        carouselWidth = carouselInner.scrollWidth;
        maxScrollPosition = cardWidth * (totalItems - cardsVisible);
    }

    function initDesktopCarousel() {
        scrollPosition = 0;
        updateSizes();

        // Inicializa o Bootstrap Carousel com interval 0 para parar automatico
        carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: false,
            wrap: true
        });

        nextBtn.addEventListener("click", onNextClick);
        prevBtn.addEventListener("click", onPrevClick);
    }

    function onNextClick() {
        if (scrollPosition < maxScrollPosition) {
            scrollPosition += cardWidth;
        } else {
            scrollPosition = 0;
        }
        carouselInner.scroll({ left: scrollPosition, behavior: 'smooth' });
    }

    function onPrevClick() {
        if (scrollPosition > 0) {
            scrollPosition -= cardWidth;
        } else {
            scrollPosition = maxScrollPosition;
        }
        carouselInner.scroll({ left: scrollPosition, behavior: 'smooth' });
    }

    function initMobileCarousel() {
        // Remove event listeners desktop para evitar duplicidade (opcional)
        nextBtn.removeEventListener("click", onNextClick);
        prevBtn.removeEventListener("click", onPrevClick);

        // Ativa o slide padrão do Bootstrap com intervalo automático
        carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: 3000,
            wrap: true
        });
    }

    function checkViewport() {
        if (window.matchMedia("(min-width: 768px)").matches) {
            initDesktopCarousel();
        } else {
            initMobileCarousel();
        }
    }

    checkViewport();

    window.addEventListener('resize', function () {
        checkViewport();
        updateSizes();
    });
});
