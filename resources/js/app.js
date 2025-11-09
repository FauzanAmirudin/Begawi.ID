import "./bootstrap";
import "./components/navbar";
import "./components/hero-animations";
import "./components/stats-counter";
import "./components/testimonial-carousel";
import "./animations";

// Alpine.js
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    initializeApp();
});

function initializeApp() {
    // Smooth scrolling for anchor links
    initSmoothScrolling();

    // Initialize theme toggle
    initThemeToggle();

    // Initialize scroll animations
    initScrollAnimations();

    // Initialize template gallery filtering
    initTemplateFiltering();

    // Initialize quick dock
    initQuickDock();

    // Initialize mobile navigation
    initMobileNavigation();
}

// Smooth scrolling
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
}

// Theme toggle functionality
function initThemeToggle() {
    const themeToggle = document.getElementById("themeToggle");
    const currentTheme = localStorage.getItem("theme") || "light";

    // Set initial theme
    document.documentElement.setAttribute("data-theme", currentTheme);

    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            const currentTheme =
                document.documentElement.getAttribute("data-theme");
            const newTheme = currentTheme === "dark" ? "light" : "dark";

            document.documentElement.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);

            // Update icon
            const icon = themeToggle.querySelector("svg");
            if (newTheme === "dark") {
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>';
            } else {
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>';
            }
        });
    }
}

// Scroll animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-fadeInUp");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements with animation classes
    document.querySelectorAll(".animate-on-scroll").forEach((el) => {
        observer.observe(el);
    });
}

// Template filtering
function initTemplateFiltering() {
    const filterButtons = document.querySelectorAll(".category-filter");
    const templateCards = document.querySelectorAll(".template-card");

    filterButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const category = button.getAttribute("data-category");

            // Update active button
            filterButtons.forEach((btn) => {
                btn.classList.remove(
                    "active",
                    "bg-gradient-accent",
                    "text-white"
                );
                btn.classList.add(
                    "bg-white",
                    "border-gray-300",
                    "text-gray-700"
                );
            });

            button.classList.add("active", "bg-gradient-accent", "text-white");
            button.classList.remove(
                "bg-white",
                "border-gray-300",
                "text-gray-700"
            );

            // Filter templates
            templateCards.forEach((card) => {
                const cardCategory = card.getAttribute("data-category");
                if (category === "all" || cardCategory === category) {
                    card.style.display = "block";
                    card.classList.add("animate-fadeInUp");
                } else {
                    card.style.display = "none";
                }
            });
        });
    });
}

// Quick dock functionality
function initQuickDock() {
    const quickDock = document.getElementById("quickDock");
    let isVisible = true;
    let lastScrollY = window.scrollY;

    window.addEventListener("scroll", () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > lastScrollY && currentScrollY > 100) {
            // Scrolling down
            if (isVisible) {
                quickDock.style.transform = "translateX(100px)";
                quickDock.style.opacity = "0.5";
                isVisible = false;
            }
        } else {
            // Scrolling up
            if (!isVisible) {
                quickDock.style.transform = "translateX(0)";
                quickDock.style.opacity = "1";
                isVisible = true;
            }
        }

        lastScrollY = currentScrollY;
    });
}

// Mobile navigation
function initMobileNavigation() {
    const mobileMenuToggle = document.getElementById("mobileMenuToggle");
    const mobileMenu = document.getElementById("mobileMenu");

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");

            // Toggle icon
            const icon = mobileMenuToggle.querySelector("svg path");
            if (mobileMenu.classList.contains("hidden")) {
                icon.setAttribute("d", "M4 6h16M4 12h16M4 18h16");
            } else {
                icon.setAttribute("d", "M6 18L18 6M6 6l12 12");
            }
        });
    }
}

// Utility functions
window.scrollToTop = function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

window.showNotification = function (message, type = "success") {
    // Create notification element
    const notification = document.createElement("div");
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === "success"
            ? "bg-emerald-600 text-white"
            : type === "error"
            ? "bg-red-600 text-white"
            : "bg-blue-600 text-white"
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove("translate-x-full");
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add("translate-x-full");
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
};
