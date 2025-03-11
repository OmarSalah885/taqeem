document.addEventListener('DOMContentLoaded', function () {
    const galleryItems = document.querySelector('.place_gallery--items');
    const leftButton = document.querySelector('.left-btn');
    const rightButton = document.querySelector('.right-btn');
    const items = document.querySelectorAll('.place_gallery--item');

    let currentScroll = 0;
    const galleryWidth = galleryItems.scrollWidth; // Total width of all items
    const visibleWidth = galleryItems.clientWidth; // Width of the visible container

    // Function to find the width of the next item dynamically
    function getNextItemWidth() {
        for (let item of items) {
            const itemLeft = item.offsetLeft;
            if (itemLeft > currentScroll) {
                return item.clientWidth + parseFloat(getComputedStyle(item).marginRight);
            }
        }
        return 100; // Default small movement if all else fails
    }

    // Function to update the gallery position
    function updateGallery() {
        galleryItems.style.transform = `translateX(${-currentScroll}px)`;
    }

    // Event listener for the left button
    leftButton.addEventListener('click', function () {
        if (currentScroll > 0) {
            currentScroll -= getNextItemWidth(); // Move by the next item’s width
            if (currentScroll < 0) currentScroll = 0; // Prevent overscrolling
        } else {
            currentScroll = galleryWidth - visibleWidth; // Wrap to the end
        }
        updateGallery();
    });

    // Event listener for the right button
    rightButton.addEventListener('click', function () {
        if (currentScroll < galleryWidth - visibleWidth) {
            currentScroll += getNextItemWidth(); // Move by the next item’s width
            if (currentScroll > galleryWidth - visibleWidth) {
                currentScroll = galleryWidth - visibleWidth; // Prevent overscrolling
            }
        } else {
            currentScroll = 0; // Wrap to the beginning
        }
        updateGallery();
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const faqItems = document.querySelectorAll(".faq-item");

    faqItems.forEach((item) => {
        const question = item.querySelector(".faq-question");

        question.addEventListener("click", () => {
            item.classList.toggle("active");
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".addReview_stars i");
    let selectedRating = 0;

    stars.forEach(star => {
        // Hover effect
        star.addEventListener("mouseover", function () {
            const value = this.getAttribute("data-value");
            highlightStars(value);
        });

        // Remove hover effect when mouse leaves
        star.addEventListener("mouseout", function () {
            highlightStars(selectedRating); // Restore selected rating
        });

        // Click to select a rating
        star.addEventListener("click", function () {
            selectedRating = this.getAttribute("data-value");
            highlightStars(selectedRating);
            console.log("Selected Rating:", selectedRating);
        });
    });

    // Function to highlight stars
    function highlightStars(value) {
        stars.forEach(star => {
            if (star.getAttribute("data-value") <= value) {
                star.classList.add("hover");
            } else {
                star.classList.remove("hover");
            }
        });
    }
});
