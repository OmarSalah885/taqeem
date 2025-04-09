document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".carousel-item");
    const indicators = document.querySelectorAll(".indicator");
    const carouselInner = document.querySelector(".carousel-inner");

    let currentIndex = 0;

    function updateCarousel(index) {
        if (!carouselInner || items.length === 0 || indicators.length === 0) return;

        items.forEach((item, i) => {
            item.classList.toggle("active", i === index);
        });

        indicators.forEach((indicator, i) => {
            indicator.classList.toggle("active", i === index);
        });

        carouselInner.style.transform = `translateX(-${index * 100}%)`;
    }

    document.querySelector(".next")?.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % items.length;
        updateCarousel(currentIndex);
    });

    document.querySelector(".prev")?.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        updateCarousel(currentIndex);
    });

    indicators.forEach((indicator, i) => {
        indicator.addEventListener("click", () => {
            currentIndex = i;
            updateCarousel(currentIndex);
        });
    });
});
