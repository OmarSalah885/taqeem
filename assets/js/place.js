document.addEventListener('DOMContentLoaded', function () {
    // --- Place Gallery Navigation ---
    const galleryItems = document.querySelector('.place_gallery--items');
    const leftButton = document.querySelector('.left-btn');
    const rightButton = document.querySelector('.right-btn');
    const items = document.querySelectorAll('.place_gallery--item');

    if (galleryItems && leftButton && rightButton && items.length) {
        let currentScroll = 0;
        const galleryWidth = galleryItems.scrollWidth;
        const visibleWidth = galleryItems.clientWidth;

        function getNextItemWidth() {
            for (let item of items) {
                if (item.offsetLeft > currentScroll) {
                    const style = getComputedStyle(item);
                    return item.clientWidth + parseFloat(style.marginRight);
                }
            }
            return 100;
        }

        function updateGallery() {
            galleryItems.style.transform = `translateX(${-currentScroll}px)`;
        }

        leftButton.addEventListener('click', function () {
            if (currentScroll > 0) {
                currentScroll -= getNextItemWidth();
                if (currentScroll < 0) currentScroll = 0;
            } else {
                currentScroll = galleryWidth - visibleWidth;
            }
            updateGallery();
        });

        rightButton.addEventListener('click', function () {
            if (currentScroll < galleryWidth - visibleWidth) {
                currentScroll += getNextItemWidth();
                if (currentScroll > galleryWidth - visibleWidth) {
                    currentScroll = galleryWidth - visibleWidth;
                }
            } else {
                currentScroll = 0;
            }
            updateGallery();
        });
    }

    // --- FAQ Toggle ---
    const faqItems = document.querySelectorAll(".faq-item");

    if (faqItems.length) {
        faqItems.forEach(item => {
            const question = item.querySelector(".faq-question");
            if (!question) return;

            question.addEventListener("click", () => {
                item.classList.toggle("active");
            });
        });
    }
});