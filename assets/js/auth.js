document.addEventListener("DOMContentLoaded", function () {
    const logOverlay = document.querySelector(".LogOverlay");
    const loginLinkNavbar = document.getElementById("login-nav");
    const signupLinkNavbar = document.getElementById("signup-nav");
    const loginLinkNavbarM = document.getElementById("login-nav_m");
    const signupLinkNavbarM = document.getElementById("signup-nav_m");
    const LogCloseBtn = document.querySelector(".LogOverlay__content--links_close");
    const loginLinkOverlay = document.getElementById("login-overlay");
    const signupLinkOverlay = document.getElementById("signup-overlay");
    const loginLinkOverlayDiv = document.getElementById("login-overlay__div");
    const signupLinkOverlayDiv = document.getElementById("signup-overlay__div");
    const loginForm = document.querySelector(".LogOverlay__content--login");
    const signupForm = document.querySelector(".LogOverlay__content--signup");

    function showLogin() {
        logOverlay.classList.add("show");
        loginForm.classList.add("show");
        signupForm.classList.remove("show");
        loginLinkOverlayDiv.classList.add("active");
        signupLinkOverlayDiv.classList.remove("active");
    }

    function showSignup() {
        logOverlay.classList.add("show");
        signupForm.classList.add("show");
        loginForm.classList.remove("show");
        signupLinkOverlayDiv.classList.add("active");
        loginLinkOverlayDiv.classList.remove("active");
    }

    // Check for login errors, signup errors, or session timeout on page load
    const urlParams = new URLSearchParams(window.location.search);
    if (typeof hasLoginErrors !== 'undefined' && hasLoginErrors) {
        showLogin();
    } else if (typeof hasSignupErrors !== 'undefined' && hasSignupErrors) {
        showSignup();
    } else if (urlParams.get('timeout') === 'true') {
        showLogin();
    }

    loginLinkNavbar?.addEventListener("click", (e) => {
        e.preventDefault();
        showLogin();
    });

    signupLinkNavbar?.addEventListener("click", (e) => {
        e.preventDefault();
        showSignup();
    });

    loginLinkNavbarM?.addEventListener("click", (e) => {
        e.preventDefault();
        showLogin();
    });

    signupLinkNavbarM?.addEventListener("click", (e) => {
        e.preventDefault();
        showSignup();
    });

    loginLinkOverlay?.addEventListener("click", (e) => {
        e.preventDefault();
        showLogin();
    });

    signupLinkOverlay?.addEventListener("click", (e) => {
        e.preventDefault();
        showSignup();
    });

    LogCloseBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        logOverlay.classList.remove("show");
        // Clear both login and signup session errors when closing the overlay
        fetch('clear_login_errors.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'clear_errors=true'
        }).catch(error => console.error('Error clearing login session:', error));
        fetch('clear_signup_errors.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'clear_errors=true'
        }).catch(error => console.error('Error clearing signup session:', error));
    });
});