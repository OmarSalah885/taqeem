document.addEventListener("DOMContentLoaded", function () {
  // === DOM Elements ===
  const searchBtn = document.getElementById("search-btn");
  const closeBtn = document.getElementById("close-btn");
  const searchOverlay = document.getElementById("search-overlay");

  const logOverlay = document.querySelector(".LogOverlay");
  const loginForm = document.querySelector(".LogOverlay__content--login");
  const signupForm = document.querySelector(".LogOverlay__content--signup");
  const LogCloseBtn = document.querySelector(".LogOverlay__content--links_close");

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

  const openMobileMenu = document.getElementById("mobile_emnu-open");
  const closeMobileMenu = document.getElementById("mobile_emnu-close");
  const mobileOverlay = document.getElementById("mobile_overlay");

  const items = document.querySelectorAll(".carousel-item");
  const indicators = document.querySelectorAll(".indicator");
  const carouselInner = document.querySelector(".carousel-inner");

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

  // === Login/Signup Toggle Logic ===
  function showLoginForm() {
    if (!logOverlay || !loginForm || !signupForm || !loginLinkOverlayDiv || !signupLinkOverlayDiv) return;
    logOverlay.classList.add("show");
    loginForm.classList.add("show");
    signupForm.classList.remove("show");
    loginLinkOverlayDiv.classList.add("active");
    signupLinkOverlayDiv.classList.remove("active");
  }

  function showSignupForm() {
    if (!logOverlay || !loginForm || !signupForm || !loginLinkOverlayDiv || !signupLinkOverlayDiv) return;
    logOverlay.classList.add("show");
    signupForm.classList.add("show");
    loginForm.classList.remove("show");
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

  // === Carousel Logic ===
  let currentIndex = 0;

  function updateCarousel(index) {
    if (!carouselInner || items.length === 0 || indicators.length === 0) return;

    items.forEach((item, i) => {
      item.classList.toggle("active", i === index);
    });

    indicators.forEach((indicator, i) => {
      indicator.classList.toggle("active", i === index);
    });

    carouselInner.style.transform = `translateX(-${index * 100}%)`;
  }

  document.querySelector(".next")?.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % items.length;
    updateCarousel(currentIndex);
  });

  document.querySelector(".prev")?.addEventListener("click", () => {
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
