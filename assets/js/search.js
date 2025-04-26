document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.getElementById("search-btn");
    const closeBtn = document.getElementById("close-btn");
    const searchOverlay = document.getElementById("search-overlay");

    if (searchBtn && closeBtn && searchOverlay) {
        searchBtn.addEventListener("click", function (event) {
            event.preventDefault();
            searchOverlay.classList.add("show");
        });

        closeBtn.addEventListener("click", function (event) {
            event.preventDefault();
            searchOverlay.classList.remove("show");
        });
    }
});
