document.addEventListener('DOMContentLoaded', function () {
    let multipleCardCarousel = document.querySelector("#carouselExampleControls");

    if (window.matchMedia("(min-width: 768px)").matches) {
        let carousel = new bootstrap.Carousel(multipleCardCarousel, {
            interval: false, // Disable automatic sliding
            wrap: true, // Permite que o carrossel "dê a volta" ao chegar ao fim
        });

        let carouselWidth = document.querySelector(".carousel-inner").scrollWidth;
        let cardWidth = document.querySelector(".carousel-item").offsetWidth;
        let scrollPosition = 0;

        // Navegação para o próximo item
        document.querySelector("#carouselExampleControls .carousel-control-next").addEventListener("click", function () {
            if (scrollPosition < carouselWidth - cardWidth * 4) {
                scrollPosition += cardWidth;
                document.querySelector("#carouselExampleControls .carousel-inner").scroll({ left: scrollPosition, behavior: 'smooth' });
            } else {
                // Voltar ao início quando chegar no fim
                scrollPosition = 0;
                document.querySelector("#carouselExampleControls .carousel-inner").scroll({ left: scrollPosition, behavior: 'smooth' });
            }
        });

        // Navegação para o item anterior
        document.querySelector("#carouselExampleControls .carousel-control-prev").addEventListener("click", function () {
            if (scrollPosition > 0) {
                scrollPosition -= cardWidth;
                document.querySelector("#carouselExampleControls .carousel-inner").scroll({ left: scrollPosition, behavior: 'smooth' });
            } else {
                // Voltar ao final quando estiver no início
                scrollPosition = carouselWidth - cardWidth * 4;
                document.querySelector("#carouselExampleControls .carousel-inner").scroll({ left: scrollPosition, behavior: 'smooth' });
            }
        });
    } else {
        multipleCardCarousel.classList.add("slide");
    }
});
