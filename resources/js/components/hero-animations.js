// Hero section animations
document.addEventListener("DOMContentLoaded", function () {
    const heroSection = document.querySelector(".hero-section");
    if (!heroSection) return;

    // Animate hero elements on load
    const heroTitle = heroSection.querySelector("h1");
    const heroSubtitle = heroSection.querySelector("p");
    const heroButtons = heroSection.querySelectorAll("a, button");

    if (heroTitle) {
        heroTitle.style.opacity = "0";
        heroTitle.style.transform = "translateY(30px)";
        setTimeout(() => {
            heroTitle.style.transition = "all 0.8s ease-out";
            heroTitle.style.opacity = "1";
            heroTitle.style.transform = "translateY(0)";
        }, 100);
    }

    if (heroSubtitle) {
        heroSubtitle.style.opacity = "0";
        heroSubtitle.style.transform = "translateY(20px)";
        setTimeout(() => {
            heroSubtitle.style.transition = "all 0.8s ease-out";
            heroSubtitle.style.opacity = "1";
            heroSubtitle.style.transform = "translateY(0)";
        }, 300);
    }

    heroButtons.forEach((button, index) => {
        button.style.opacity = "0";
        button.style.transform = "translateY(20px)";
        setTimeout(() => {
            button.style.transition = "all 0.6s ease-out";
            button.style.opacity = "1";
            button.style.transform = "translateY(0)";
        }, 500 + index * 100);
    });

    // Parallax effect for hero background
    window.addEventListener("scroll", () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = heroSection.querySelectorAll(".parallax");
        parallaxElements.forEach((element) => {
            const speed = element.dataset.speed || 0.5;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });

    // Floating animation for decorative elements
    const floatingElements = heroSection.querySelectorAll(".animate-float");
    floatingElements.forEach((element) => {
        const randomDelay = Math.random() * 2;
        const randomDuration = 3 + Math.random() * 2;
        element.style.animationDelay = `${randomDelay}s`;
        element.style.animationDuration = `${randomDuration}s`;
    });
});
