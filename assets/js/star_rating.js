document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.addReview_stars').forEach(container => {
        const stars = container.querySelectorAll('i');
        let ratingInput;

        // Check if this is an edit form container
        const reviewId = container.getAttribute('data-review-id');
        if (reviewId) {
            // Edit form: Find the input with id="rating-<reviewId>"
            ratingInput = document.getElementById(`rating-${reviewId}`);
        } else {
            // Add form: Find the input within the container
            ratingInput = container.querySelector('input[name="rating"]');
        }

        if (!ratingInput) {
            console.warn('Rating input not found for container:', container);
            return; // Skip this container if input is not found
        }

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                stars.forEach(s => {
                    s.style.color = s.getAttribute('data-value') <= value ? '#A21111' : '#D0D0D0';
                });
            });
        });
    });
});