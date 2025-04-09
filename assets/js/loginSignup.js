document.addEventListener("DOMContentLoaded", function () {
    const loginLinkOverlay = document.getElementById("login-overlay");
    const signupLinkOverlay = document.getElementById("signup-overlay");
    const loginLinkOverlayDiv = document.getElementById("login-overlay__div");
    const signupLinkOverlayDiv = document.getElementById("signup-overlay__div");

    const loginLinks = [
        document.getElementById("login-nav"),
        document.getElementById("login-nav_m"),
    ].filter(link => link !== null);

    const signupLinks = [
        document.getElementById("signup-nav"),
        document.getElementById("signup-nav_m"),
    ].filter(link => link !== null);

    // === Login/Signup Toggle Logic ===
    function showLoginForm() {
        if (!loginLinkOverlay || !loginLinkOverlayDiv || !signupLinkOverlayDiv) return;
        loginLinkOverlay.classList.add("show");
        loginLinkOverlayDiv.classList.add("active");
        signupLinkOverlayDiv.classList.remove("active");
    }

    function showSignupForm() {
        if (!loginLinkOverlay || !loginLinkOverlayDiv || !signupLinkOverlayDiv) return;
        signupLinkOverlay.classList.add("show");
        signupLinkOverlayDiv.classList.add("active");
        loginLinkOverlayDiv.classList.remove("active");
    }

    loginLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            showLoginForm();
        });
    });

    signupLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            showSignupForm();
        });
    });

    loginLinkOverlay?.addEventListener("click", (e) => {
        e.preventDefault();
        showLoginForm();
    });

    signupLinkOverlay?.addEventListener("click", (e) => {
        e.preventDefault();
        showSignupForm();
    });
});
