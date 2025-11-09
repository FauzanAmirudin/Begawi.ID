// Testimonial carousel functionality
class TestimonialCarousel {
    constructor() {
        this.carousel = document.querySelector(".testimonial-carousel .flex");
        this.prevBtn = document.querySelector(".carousel-prev");
        this.nextBtn = document.querySelector(".carousel-next");
        this.cards = document.querySelectorAll(".testimonial-card");
        this.currentIndex = 0;
        this.cardWidth = 0;
        this.autoPlayInterval = null;

        this.init();
    }

    init() {
        if (!this.carousel) return;

        this.calculateCardWidth();
        this.bindEvents();
        this.startAutoPlay();

        // Recalculate on window resize
        window.addEventListener("resize", () => {
            this.calculateCardWidth();
        });
    }

    calculateCardWidth() {
        if (this.cards.length > 0) {
            this.cardWidth = this.cards[0].offsetWidth + 24; // Include gap
        }
    }

    bindEvents() {
        if (this.prevBtn) {
            this.prevBtn.addEventListener("click", () => {
                this.prev();
            });
        }

        if (this.nextBtn) {
            this.nextBtn.addEventListener("click", () => {
                this.next();
            });
        }

        // Touch/swipe support
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        this.carousel.addEventListener("touchstart", (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
            this.stopAutoPlay();
        });

        this.carousel.addEventListener("touchmove", (e) => {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
            const diffX = startX - currentX;

            if (Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    this.next();
                } else {
                    this.prev();
                }
                isDragging = false;
            }
        });

        this.carousel.addEventListener("touchend", () => {
            isDragging = false;
            this.startAutoPlay();
        });

        // Pause autoplay on hover
        this.carousel.addEventListener("mouseenter", () => {
            this.stopAutoPlay();
        });

        this.carousel.addEventListener("mouseleave", () => {
            this.startAutoPlay();
        });
    }

    next() {
        this.currentIndex = (this.currentIndex + 1) % this.cards.length;
        this.updateCarousel();
    }

    prev() {
        this.currentIndex =
            (this.currentIndex - 1 + this.cards.length) % this.cards.length;
        this.updateCarousel();
    }

    updateCarousel() {
        const translateX = -this.currentIndex * this.cardWidth;
        this.carousel.style.transform = `translateX(${translateX}px)`;
    }

    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => {
            this.next();
        }, 5000);
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
}

// Initialize carousel when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    new TestimonialCarousel();
});
