// Navbar scroll behavior
let lastScrollY = 0;
const navbar = document.getElementById("navbar");

window.addEventListener("scroll", () => {
    const currentScrollY = window.scrollY;

    if (currentScrollY > 100) {
        navbar.classList.add("bg-white/95", "shadow-lg");
        navbar.classList.remove("glassmorphism");
    } else {
        navbar.classList.remove("bg-white/95", "shadow-lg");
        navbar.classList.add("glassmorphism");
    }

    // Hide/show navbar on scroll
    if (currentScrollY > lastScrollY && currentScrollY > 200) {
        navbar.style.transform = "translateY(-100%)";
    } else {
        navbar.style.transform = "translateY(0)";
    }

    lastScrollY = currentScrollY;
});

// Active link highlighting
const navLinks = document.querySelectorAll('nav a[href^="/"]');
const currentPath = window.location.pathname;

navLinks.forEach((link) => {
    if (link.getAttribute("href") === currentPath) {
        link.classList.add("text-emerald-600", "font-semibold");
    }
});
