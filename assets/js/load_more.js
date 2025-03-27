document.addEventListener("DOMContentLoaded", function () {
    let offset = 8; // Start loading from 8 since 8 are already displayed
    const loadMoreBtn = document.getElementById("loadMore");
    const activityGrid = document.getElementById("activity_grid");

    loadMoreBtn.addEventListener("click", function () {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "load_reviews.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response = xhr.responseText.trim();
                if (response !== "") {
                    activityGrid.innerHTML += response;
                    offset += 8;
                } else {
                    loadMoreBtn.style.display = "none"; // Hide button if no more reviews
                }
            }
        };

        xhr.send("offset=" + offset);
    });
});
