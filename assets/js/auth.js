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
        // Clear session errors via AJAX
        fetch('clear_login_errors.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'clear_errors=true'
        }).catch(error => console.error('Error clearing login errors:', error));
        fetch('clear_signup_errors.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'clear_errors=true'
        }).catch(error => console.error('Error clearing signup errors:', error));
    }

    function updateUIAfterAuth(user) {
        window.isLoggedIn = true;
        logOverlay.classList.remove("show");

        // Update desktop navbar
        const navbarRight = document.querySelector(".navbar_container--menu-R");
        if (navbarRight) {
            // Remove login and signup links
            const loginLink = document.getElementById("login-nav");
            const signupLink = document.getElementById("signup-nav");
            loginLink?.remove();
            signupLink?.remove();

            // Create profile and logout links
            const profileLink = document.createElement("a");
            profileLink.href = `profile.php?user_id=${user.id}`;
            profileLink.className = "navbar_profile";
            // Robust default image fallback
            const profileImage = user.profile_image && user.profile_image.trim() ? user.profile_image : 'assets/images/profiles/pro_null.png';
            profileLink.innerHTML = `
                <img src="${profileImage}?v=${Date.now()}" alt="User Profile">
                <span>${user.first_name} ${user.last_name}</span>
            `;
            const logoutLink = document.createElement("a");
            logoutLink.href = "logout.php";
            logoutLink.className = "navbar_container--menu-R_links";
            logoutLink.textContent = "Log Out";

            // Insert links to match header.php order: Search -> Profile -> Log Out -> Add Place
            const searchBtn = document.getElementById("search-btn");
            const addPlaceBtn = navbarRight.querySelector(".btn__red--m[href='add-place.php']");
            if (searchBtn && addPlaceBtn) {
                // Insert profile after search button
                navbarRight.insertBefore(profileLink, searchBtn.nextElementSibling || addPlaceBtn);
                // Insert logout after profile
                navbarRight.insertBefore(logoutLink, profileLink.nextElementSibling || addPlaceBtn);
            } else {
                // Fallback: append to navbarRight in correct order
                navbarRight.appendChild(profileLink);
                navbarRight.appendChild(logoutLink);
            }
        }

        // Update mobile overlay
        const mobileOverlayLinks = document.querySelector(".mobile_overlay--content_links");
        if (mobileOverlayLinks) {
            // Remove login and signup links
            const loginLinkM = document.getElementById("login-nav_m");
            const signupLinkM = document.getElementById("signup-nav_m");
            loginLinkM?.remove();
            signupLinkM?.remove();

            // Add profile and logout links
            const profileLinkM = document.createElement("a");
            profileLinkM.href = `profile.php?user_id=${user.id}`;
            profileLinkM.className = "navbar_profile";
            // Robust default image fallback
            const profileImageM = user.profile_image && user.profile_image.trim() ? user.profile_image : 'assets/images/profiles/pro_null.png';
            profileLinkM.innerHTML = `
                <img src="${profileImageM}?v=${Date.now()}" alt="User Profile">
                <span>${user.first_name} ${user.last_name}</span>
            `;
            const logoutLinkM = document.createElement("a");
            logoutLinkM.href = "logout.php";
            logoutLinkM.textContent = "log out";

            // Insert at the top of the links
            mobileOverlayLinks.insertBefore(profileLinkM, mobileOverlayLinks.firstChild);
            mobileOverlayLinks.insertBefore(logoutLinkM, mobileOverlayLinks.children[1]);
        }

        // Handle comment or review form focus
        if (window.location.pathname.includes('single-blog.php') && sessionStorage.getItem('isCommentTriggeredLogin') === 'true') {
            const commentForm = document.querySelector('#comment_form');
            if (commentForm) {
                commentForm.querySelector('textarea[name="comment"]').focus();
            }
            sessionStorage.removeItem('isCommentTriggeredLogin');
        } else if (window.location.pathname.includes('single-place.php') && sessionStorage.getItem('isReviewTriggeredLogin') === 'true') {
            const reviewForm = document.querySelector('#reviewForm');
            if (reviewForm) {
                reviewForm.querySelector('textarea[name="review_text"]').focus();
            }
            sessionStorage.removeItem('isReviewTriggeredLogin');
        }
    }

    function displayErrors(form, errors) {
        const errorContainer = form.querySelector('.error-container') || document.createElement('div');
        errorContainer.className = 'error-container';
        errorContainer.innerHTML = Object.values(errors).map(err => `<p class="error">${err}</p>`).join('');
        if (!form.querySelector('.error-container')) {
            form.insertBefore(errorContainer, form.querySelector('button[type="submit"]'));
        }
        // Keep form visible
        logOverlay.classList.add("show");
        form.classList.add("show");
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (typeof hasLoginErrors !== 'undefined' && hasLoginErrors) {
        showLogin();
    } else if (typeof hasSignupErrors !== 'undefined' && hasSignupErrors) {
        showSignup();
    } else if (urlParams.get('timeout') === 'true') {
        showLogin();
    }

    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);
        const submitButton = loginForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Signing In...';

        try {
            const response = await fetch('login_handler.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();
            console.log('Login response:', result);
            if (result.success) {
                updateUIAfterAuth(result.user);
            } else {
                displayErrors(loginForm, result.errors || { general: result.message || 'Login failed. Please try again.' });
            }
        } catch (error) {
            console.error('Login error:', error);
            displayErrors(loginForm, { general: 'Network error: ' + error.message });
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Sign In';
        }
    });

    signupForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(signupForm);
        const submitButton = signupForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Signing Up...';

        try {
            const response = await fetch('signup_handler.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();
            console.log('Signup response:', result);
            if (result.success) {
                updateUIAfterAuth(result.user);
            } else {
                displayErrors(signupForm, result.errors || { general: result.message || 'Signup failed. Please try again.' });
            }
        } catch (error) {
            console.error('Signup error:', error);
            displayErrors(signupForm, { general: 'Network error: ' + error.message });
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Sign Up';
        }
    });

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