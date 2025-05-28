document.addEventListener("DOMContentLoaded", function () {
    function toggleLike(event, reviewId) {
        event.preventDefault(); // Prevent default link behavior

        // Send AJAX request to toggle_like.php
        fetch('toggle_like.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `review_id=${encodeURIComponent(reviewId)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update all heart icons for this review_id on the page
                document.querySelectorAll(`a.activity_grid--item_img_like[onclick="toggleLike(event, ${reviewId})"] i`).forEach(icon => {
                    icon.classList.remove('fa-solid', 'fa-regular', 'fa-heart');
                    icon.classList.add(data.is_liked ? 'fa-solid' : 'fa-regular', 'fa-heart');
                });
            } else {
                if (data.message === 'You must be logged in to like a review.') {
                    // Show login overlay if user is not logged in
                    if (typeof window.showLogin === 'function') {
                        window.showLogin(null, window.location.href);
                    } else {
                        console.error('showLogin function not found');
                        alert('Please log in to like a review.');
                    }
                } else {
                    console.error('Error:', data.message);
                    alert('Error: ' + data.message);
                }
            }
        })
        .catch(error => {
            console.error('AJAX error:', error);
            alert('An error occurred while processing your request.');
        });
    }

    // Expose the function globally
    window.toggleLike = toggleLike;
});