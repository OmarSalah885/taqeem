document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".carousel-item");
    const indicators = document.querySelectorAll(".indicator");
    const carouselInner = document.querySelector(".carousel-inner");
    const nextBtn = document.querySelector(".next");
    const prevBtn = document.querySelector(".prev");

    let currentIndex = 0;
    let interval;

    function updateCarousel(index) {
        items.forEach((item, i) => {
            item.classList.toggle("active", i === index);
        });

        indicators.forEach((indicator, i) => {
            indicator.classList.toggle("active", i === index);
        });

        if (carouselInner) {
            carouselInner.style.transform = `translateX(-${index * 100}%)`;
        }
    }

    function startAutoLoop() {
        interval = setInterval(() => {
            currentIndex = (currentIndex + 1) % items.length;
            updateCarousel(currentIndex);
        }, 6000); // change every 4 seconds
    }

    function resetAutoLoop() {
        clearInterval(interval);
        startAutoLoop();
    }

    nextBtn?.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % items.length;
        updateCarousel(currentIndex);
        resetAutoLoop();
    });

    prevBtn?.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        updateCarousel(currentIndex);
        resetAutoLoop();
    });

    indicators.forEach((indicator, i) => {
        indicator.addEventListener("click", () => {
            currentIndex = i;
            updateCarousel(currentIndex);
            resetAutoLoop();
        });
    });

    // Start auto loop
    startAutoLoop();
});
