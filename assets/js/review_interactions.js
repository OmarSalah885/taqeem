document.addEventListener("DOMContentLoaded", function () {
    function toggleLike(event, reviewId) {
        event.preventDefault();

        // Check if the user is logged in
        if (!isLoggedIn) {
            // Redirect to login overlay
            const loginOverlay = document.getElementById("loginOverlay");
            if (loginOverlay) {
                loginOverlay.style.display = "block";
            } else {
                alert("You must be logged in to like a review.");
            }
            return;
        }

        // Send AJAX request to toggle like
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "toggle_like.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Update the icon based on the new like state
                    const icon = event.target.tagName === "I" ? event.target : event.target.querySelector("i");
                    icon.className = response.is_liked ? "fa-solid fa-heart" : "fa-regular fa-heart";
                } else {
                    alert(response.message);
                }
            }
        };

        xhr.send("review_id=" + reviewId);
    }

    // Expose the function globally
    window.toggleLike = toggleLike;
});