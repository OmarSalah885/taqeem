document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".carousel-item");
    const indicators = document.querySelectorAll(".indicator");
    const carouselInner = document.querySelector(".carousel-inner");
    const nextBtn = document.querySelector(".next");
    const prevBtn = document.querySelector(".prev");

    let currentIndex = 0;
    let interval;
    AOS.init({
        // Global settings:
        offset: 120, // offset (in px) from the original trigger point
        delay: 0, // values from 0 to 3000, with step 50ms
        duration: 400, // values from 0 to 3000, with step 50ms
        easing: 'ease', // default easing for AOS animations
        once: true, // whether animation should happen only once while scrolling down
        mirror: false, // whether elements should animate out while scrolling past them
    });
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
            AOS.refresh();  // <-- refresh AOS here too for auto loop
        }, 6000); // change every 6 seconds
    }

    function resetAutoLoop() {
        clearInterval(interval);
        startAutoLoop();
    }

    nextBtn?.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % items.length;
        updateCarousel(currentIndex);
        AOS.refresh(); // <-- refresh AOS after manual next click
        resetAutoLoop();
    });

    prevBtn?.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        updateCarousel(currentIndex);
        AOS.refresh(); // <-- refresh AOS after manual prev click
        resetAutoLoop();
    });

    indicators.forEach((indicator, i) => {
        indicator.addEventListener("click", () => {
            currentIndex = i;
            updateCarousel(currentIndex);
            AOS.refresh(); // <-- refresh AOS after clicking indicator
            resetAutoLoop();
        });
    });

    // Start auto loop
    startAutoLoop();
});
