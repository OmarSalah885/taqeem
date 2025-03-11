document.addEventListener("DOMContentLoaded", function () {
  const searchBtn = document.getElementById("search-btn");
  const closeBtn = document.getElementById("close-btn");
  const searchOverlay = document.getElementById("search-overlay");
  const logOverlay = document.querySelector(".LogOverlay");
  const loginLinkNavbar = document.getElementById("login-nav");
  const signupLinkNavbar = document.getElementById("signup-nav");
  const loginLinkNavbarM = document.getElementById("login-nav_m");
  const signupLinkNavbarM = document.getElementById("signup-nav_m");
  const LogCloseBtn = document.querySelector(
    ".LogOverlay__content--links_close"
  );
  const loginLinkOverlay = document.getElementById("login-overlay");
  const signupLinkOverlay = document.getElementById("signup-overlay");
  const loginLinkOverlayDiv = document.getElementById("login-overlay__div");
  const signupLinkOverlayDiv = document.getElementById("signup-overlay__div");
  const loginForm = document.querySelector(".LogOverlay__content--login");
  const signupForm = document.querySelector(".LogOverlay__content--signup");
  const openMobileMenu = document.getElementById("mobile_emnu-open");
  const closeMobileMenu = document.getElementById("mobile_emnu-close");
  const mobileOverlay = document.getElementById("mobile_overlay");
  searchBtn.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor behavior
    searchOverlay.classList.add("show"); // Show overlay
  });

  closeBtn.addEventListener("click", function (event) {
    event.preventDefault();
    searchOverlay.classList.remove("show"); // Hide overlay
  });
  // Show Log In form
  loginLinkNavbar.addEventListener("click", function (e) {
    e.preventDefault();
    logOverlay.classList.add("show");
    loginForm.classList.add("show");
    signupForm.classList.remove("show");
    signupLinkOverlayDiv.classList.remove("active");
    loginLinkOverlayDiv.classList.add("active");
    console.log("sdoijfsiklf;iosdnkflkn");
  });

  // Show Sign Up form
  signupLinkNavbar.addEventListener("click", function (e) {
    e.preventDefault();
    logOverlay.classList.add("show");
    signupForm.classList.add("show");
    loginForm.classList.remove("show");
    signupLinkOverlayDiv.classList.add("active");
    loginLinkOverlayDiv.classList.remove("active");
    console.log("sdoijfsiklf;iosdnkflkn");
  });
  loginLinkNavbarM.addEventListener("click", function (e) {
    e.preventDefault();
    logOverlay.classList.add("show");
    loginForm.classList.add("show");
    signupForm.classList.remove("show");
    signupLinkOverlayDiv.classList.remove("active");
    loginLinkOverlayDiv.classList.add("active");
    console.log("sdoijfsiklf;iosdnkflkn");
  });

  // Show Sign Up form
  signupLinkNavbarM.addEventListener("click", function (e) {
    e.preventDefault();
    logOverlay.classList.add("show");
    signupForm.classList.add("show");
    loginForm.classList.remove("show");
    signupLinkOverlayDiv.classList.add("active");
    loginLinkOverlayDiv.classList.remove("active");
    console.log("sdoijfsiklf;iosdnkflkn");
  });

  // Show Log In form from overlay
  loginLinkOverlay.addEventListener("click", function (e) {
    e.preventDefault();
    loginForm.classList.add("show");
    signupForm.classList.remove("show");
    signupLinkOverlayDiv.classList.remove("active");
    loginLinkOverlayDiv.classList.add("active");
  });

  // Show Sign Up form from overlay
  signupLinkOverlay.addEventListener("click", function (e) {
    e.preventDefault();
    signupForm.classList.add("show");
    loginForm.classList.remove("show");
    signupLinkOverlayDiv.classList.add("active");
    loginLinkOverlayDiv.classList.remove("active");
  });

  // Close overlay
  LogCloseBtn.addEventListener("click", function (e) {
    e.preventDefault();
    logOverlay.classList.remove("show");
  });
  openMobileMenu.addEventListener("click", function (e) {
    e.preventDefault();
    mobileOverlay.classList.add("show");
  });
  closeMobileMenu.addEventListener("click", function (e) {
    e.preventDefault();
    mobileOverlay.classList.remove("show");
  });
  const items = document.querySelectorAll(".carousel-item");
  const indicators = document.querySelectorAll(".indicator");
  let currentIndex = 0;
  function updateCarousel(index) {
    // Update active item
    items.forEach((item, i) => {
      item.classList.toggle("active", i === index);
    });

    // Update indicators
    indicators.forEach((indicator, i) => {
      indicator.classList.toggle("active", i === index);
    });

    // Move carousel
    document.querySelector(".carousel-inner").style.transform = `translateX(-${index * 100
      }%)`;
  }

  document.querySelector(".next").addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % items.length;
    updateCarousel(currentIndex);
  });

  document.querySelector(".prev").addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    updateCarousel(currentIndex);
  });

  indicators.forEach((indicator, i) => {
    indicator.addEventListener("click", () => {
      currentIndex = i;
      updateCarousel(currentIndex);
    });
  });

});
