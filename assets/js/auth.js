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

    // Store callbacks for post-login actions
    let loginSuccessCallback = null;

    function showLogin(callback = null) {
        if (!logOverlay || !loginForm || !signupForm || !loginLinkOverlayDiv || !signupLinkOverlayDiv) {
            console.error('Login overlay elements not found');
            return;
        }
        loginSuccessCallback = callback;
        logOverlay.classList.add("show");
        loginForm.classList.add("show");
        signupForm.classList.remove("show");
        loginLinkOverlayDiv.classList.add("active");
        signupLinkOverlayDiv.classList.remove("active");
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

    // Expose showLogin globally
    window.showLogin = showLogin;
    window.showSignup = showSignup;

    // Handle login form submission
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            try {
                const response = await fetch(loginForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                });
                const data = await response.json();
                if (data.success) {
                    console.log('Login successful, updating session state');
                    logOverlay.classList.remove("show");
                    clearFormsAndErrors();
                    // Update client-side login state
                    window.isLoggedIn = true;
                    // Trigger callback without redirect
                    if (loginSuccessCallback) {
                        loginSuccessCallback();
                        loginSuccessCallback = null;
                    }
                } else {
                    alert('Login failed: ' + (data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Login error:', error);
                alert('Error during login: ' + error.message);
            }
        });
    }

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
        loginSuccessCallback = null;
    });
});