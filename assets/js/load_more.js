document.addEventListener("DOMContentLoaded", function () {
    const loadMoreBtn = document.getElementById("loadMore");
    const activityGrid = document.getElementById("activity_grid");

    loadMoreBtn.addEventListener("click", function (event) {
        event.preventDefault();
        loadMoreBtn.classList.add('loading');
        loadMoreBtn.textContent = 'Loading...';

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "load_reviews.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = xhr.responseText.trim();
                loadMoreBtn.classList.remove('loading');
                loadMoreBtn.textContent = 'Load more';

                if (response !== "") {
                    activityGrid.insertAdjacentHTML('beforeend', response);

                    // Update displayedReviewIds
                    const newReviewItems = activityGrid.querySelectorAll('.activity_grid--item:not([data-processed])');
                    newReviewItems.forEach(item => {
                        const reviewId = parseInt(item.querySelector('a[href*="#review_"]').getAttribute('href').match(/#review_(\d+)/)[1]);
                        displayedReviewIds.push(reviewId);
                        item.setAttribute('data-processed', 'true');
                    });
                } else {
                    loadMoreBtn.style.display = "none"; // Hide button if no more reviews
                }
            }
        };

        xhr.send("exclude_ids=" + encodeURIComponent(JSON.stringify(displayedReviewIds)));
    });
});