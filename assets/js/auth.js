document.addEventListener("DOMContentLoaded", function () {
    console.log('auth.js loaded successfully');
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

    function showLogin(callback, redirectUrl = window.location.href, isReviewTriggered = false) {
        if (!logOverlay || !loginForm || !signupForm || !loginLinkOverlayDiv || !signupLinkOverlayDiv) {
            console.error('Login overlay elements not found');
            return;
        }
        logOverlay.classList.add("show");
        loginForm.classList.add("show");
        signupForm.classList.remove("show");
        loginLinkOverlayDiv.classList.add("active");
        signupLinkOverlayDiv.classList.remove("active");
        // Set redirect_url in login form
        const redirectInput = loginForm.querySelector('input[name="redirect_url"]');
        if (redirectInput) {
            redirectInput.value = redirectUrl;
        }
        // Add is_review_triggered input
        let reviewInput = loginForm.querySelector('input[name="is_review_triggered"]');
        if (!reviewInput) {
            reviewInput = document.createElement('input');
            reviewInput.type = 'hidden';
            reviewInput.name = 'is_review_triggered';
            loginForm.appendChild(reviewInput);
        }
        reviewInput.value = isReviewTriggered ? 'true' : 'false';
        if (callback) callback();
    }

    function showSignup() {
        if (!logOverlay || !loginForm || !signupForm || !loginLinkOverlayDiv || !signupLinkOverlayDiv) {
            console.error('Signup overlay elements not found');
            return;
        }
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

    // Expose showLogin and showSignup globally
    window.showLogin = showLogin;
    window.showSignup = showSignup;

    // Only show overlay on errors or timeout, not if already logged in
    const urlParams = new URLSearchParams(window.location.search);
    if (!isLoggedIn) {
        if (typeof hasLoginErrors !== 'undefined' && hasLoginErrors) {
            showLogin();
        } else if (typeof hasSignupErrors !== 'undefined' && hasSignupErrors) {
            showSignup();
        } else if (urlParams.get('timeout') === 'true') {
            showLogin();
        }
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