document.addEventListener("DOMContentLoaded", function () {
    const openMobileMenu = document.getElementById("mobile_emnu-open");
    const closeMobileMenu = document.getElementById("mobile_emnu-close");
    const mobileOverlay = document.getElementById("mobile_overlay");

    openMobileMenu?.addEventListener("click", function (e) {
        e.preventDefault();
        mobileOverlay.classList.add("show");
    });

    closeMobileMenu?.addEventListener("click", function (e) {
        e.preventDefault();
        mobileOverlay.classList.remove("show");
    });
});
