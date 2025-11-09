// Global animations utility
export function initAnimations() {
    // Fade in on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-fadeInUp");
                fadeObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll(".animate-on-scroll").forEach((el) => {
        fadeObserver.observe(el);
    });

    // Counter animation
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = formatNumber(target);
                clearInterval(timer);
            } else {
                element.textContent = formatNumber(Math.floor(start));
            }
        }, 16);
    }

    function formatNumber(num) {
        if (num >= 1000) {
            return (num / 1000).toFixed(1) + "k";
        }
        return Math.floor(num).toString();
    }

    // Animate counters when visible
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                const target = parseInt(
                    entry.target.dataset.target ||
                        entry.target.textContent.replace(/[^0-9]/g, "")
                );
                if (target) {
                    entry.target.dataset.animated = "true";
                    animateCounter(entry.target, target);
                }
            }
        });
    }, observerOptions);

    document.querySelectorAll("[data-counter]").forEach((el) => {
        counterObserver.observe(el);
    });

    // Stagger animation for lists
    function staggerAnimation(elements, delay = 100) {
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.classList.add("animate-fadeInUp");
            }, index * delay);
        });
    }

    // Apply stagger to list items
    document.querySelectorAll(".stagger-list").forEach((list) => {
        const items = list.querySelectorAll("li, .stagger-item");
        if (items.length > 0) {
            const listObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (
                        entry.isIntersecting &&
                        !entry.target.dataset.staggered
                    ) {
                        entry.target.dataset.staggered = "true";
                        staggerAnimation(Array.from(items));
                    }
                });
            }, observerOptions);
            listObserver.observe(list);
        }
    });
}

// Initialize on DOM ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initAnimations);
} else {
    initAnimations();
}
