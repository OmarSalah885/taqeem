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

    function clearFormsAndErrors() {
        loginForm?.reset();
        signupForm?.reset();
        document.querySelectorAll('.error-container').forEach(container => container.remove());
    }

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
        clearFormsAndErrors();
        showLogin();
    });

    signupLinkNavbar?.addEventListener("click", (e) => {
        e.preventDefault();
        clearFormsAndErrors();
        showSignup();
    });

    loginLinkNavbarM?.addEventListener("click", (e) => {
        e.preventDefault();
        clearFormsAndErrors();
        showLogin();
    });

    signupLinkNavbarM?.addEventListener("click", (e) => {
        e.preventDefault();
        clearFormsAndErrors();
        showSignup();
    });

    loginLinkOverlay?.addEventListener("click", (e) => {
        e.preventDefault();
        clearFormsAndErrors();
        showLogin();
    });

    signupLinkOverlay?.addEventListener("click", (e) => {
        e.preventDefault();
        clearFormsAndErrors();
        showSignup();
    });

    LogCloseBtn?.addEventListener("click", (e) => {
        e.preventDefault();
        logOverlay.classList.remove("show");
        sessionStorage.removeItem('isCommentTriggeredLogin');
        sessionStorage.removeItem('isReviewTriggeredLogin');
        clearFormsAndErrors();
    });
});