document.addEventListener('DOMContentLoaded', function () {
    // Gallery Navigation
    const galleryItems = document.querySelector('.place_gallery--items');
    const leftButton = document.querySelector('.left-btn');
    const rightButton = document.querySelector('.right-btn');
    const items = document.querySelectorAll('.place_gallery--item');

    if (galleryItems && leftButton && rightButton && items.length > 0) {
        let currentScroll = 0;

        const getGalleryWidth = () => galleryItems.scrollWidth;
        const getVisibleWidth = () => galleryItems.clientWidth;

        function getNextItemWidth() {
            for (let item of items) {
                if (item.offsetLeft > currentScroll) {
                    const style = getComputedStyle(item);
                    return item.clientWidth + parseFloat(style.marginRight || 0);
                }
            }
            return 100; // Fallback movement
        }

        function updateGallery() {
            galleryItems.style.transform = `translateX(${-currentScroll}px)`;
        }

        leftButton.addEventListener('click', () => {
            const galleryWidth = getGalleryWidth();
            const visibleWidth = getVisibleWidth();

            if (currentScroll > 0) {
                currentScroll -= getNextItemWidth();
                currentScroll = Math.max(0, currentScroll);
            } else {
                currentScroll = galleryWidth - visibleWidth; // Wrap to end
            }
            updateGallery();
        });

        rightButton.addEventListener('click', () => {
            const galleryWidth = getGalleryWidth();
            const visibleWidth = getVisibleWidth();

            if (currentScroll < galleryWidth - visibleWidth) {
                currentScroll += getNextItemWidth();
                currentScroll = Math.min(currentScroll, galleryWidth - visibleWidth);
            } else {
                currentScroll = 0; // Wrap to start
            }
            updateGallery();
        });
    }

    // FAQ Toggle
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        if (question) {
            question.addEventListener('click', () => {
                item.classList.toggle('active');
            });
        }
    });

    // Star Rating
    const stars = document.querySelectorAll('.addReview_stars i');
    let selectedRating = 0;

    function highlightStars(value) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-value'), 10);
            if (starValue <= value) {
                star.classList.add('hover');
            } else {
                star.classList.remove('hover');
            }
        });
    }

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const value = parseInt(star.getAttribute('data-value'), 10);
            highlightStars(value);
        });

        star.addEventListener('mouseout', () => {
            highlightStars(selectedRating);
        });

        star.addEventListener('click', () => {
            selectedRating = parseInt(star.getAttribute('data-value'), 10);
            highlightStars(selectedRating);
            console.log('Selected Rating:', selectedRating);
        });
    });
});
