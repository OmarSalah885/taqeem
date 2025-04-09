document.addEventListener("DOMContentLoaded", function () {
    const searchBtn = document.getElementById("search-btn");
    const closeBtn = document.getElementById("close-btn");
    const searchOverlay = document.getElementById("search-overlay");

    const logOverlay = document.querySelector(".LogOverlay");
    const LogCloseBtn = document.querySelector(".LogOverlay__content--links_close");

    const openMobileMenu = document.getElementById("mobile_emnu-open");
    const closeMobileMenu = document.getElementById("mobile_emnu-close");
    const mobileOverlay = document.getElementById("mobile_overlay");

    // === Overlay Toggles ===
    searchBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        searchOverlay?.classList.add("show");
    });

    closeBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        searchOverlay?.classList.remove("show");
    });

    LogCloseBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        logOverlay?.classList.remove("show");
    });

    openMobileMenu?.addEventListener("click", (e) => {
        e.preventDefault();
        mobileOverlay?.classList.add("show");
    });

    closeMobileMenu?.addEventListener("click", (e) => {
        e.preventDefault();
        mobileOverlay?.classList.remove("show");
    });
});
