$(document).ready(function () {

    // Register GSAP ScrollTrigger
    gsap.registerPlugin(ScrollTrigger);

    // ==========================================
    // 1. Initial Page Load Sequence (Timeline)
    // ==========================================
    const heroTl = gsap.timeline();

    heroTl
        .from(".pr-logo", { y: -30, opacity: 1, duration: 0.8, ease: "power3.out" })
        .from(".pr-nav a", { y: 0, opacity: 1, stagger: 0.1, duration: 0.6 }, "-=0.6")
        .from(".pr-actions", { y: 0, opacity: 1, duration: 0.6 }, "-=0.4")
        .from(".hero-title", { y: 50, opacity: 1, duration: 1, ease: "power4.out" }, "-=0.2")
        .from(".hero-desc", { y: 30, opacity: 1, duration: 0.8 }, "-=0.6")
        .from(".hero-btns", { y: 20, opacity: 1, duration: 0.8 }, "-=0.6")
        .from(".hero-visual", { x: 50, opacity: 1, duration: 1.2, ease: "power2.out" }, "-=1.0");


    // ==========================================
    // 2. Scroll-Linked Header (Blur Effect)
    // ==========================================
    ScrollTrigger.create({
        start: "top -50",
        end: 99999,
        toggleClass: { className: "scrolled", targets: ".pr-header" }
    });

    // ==========================================
    // 3. Staggered Grid Reveals
    // ==========================================

    // Helper function for grids
    function animateGrid(selector, itemClass) {
        gsap.from(selector + " " + itemClass, {
            scrollTrigger: {
                trigger: selector,
                start: "top 80%",
                toggleActions: "play none none reverse"
            },
            // y: 5 0,
            // opacity: 0,
            duration: 0.8,
            stagger: 0.15, // The magic sauce: items appear one by one
            ease: "power3.out"
        });
    }

    animateGrid(".cards-grid", ".bank-card-item");
    animateGrid(".products-grid", ".product-box");
    animateGrid(".knowledge-grid", ".knowledge-box");
    animateGrid(".features-grid", ".feature-box");
    animateGrid(".footer-grid", ".footer-col"); // Even the footer staggers!

    // ==========================================
    // 4. About Section Reveal
    // ==========================================
    gsap.from(".about-wrapper", {
        scrollTrigger: {
            trigger: ".about-section",
            start: "top 80%"
        },
        scale: 0.95,
        opacity: 0,
        duration: 1,
        ease: "power2.out"
    });

    // ==========================================
    // 5. Glow Orb Scrubbing (Footer CTA)
    // ==========================================
    gsap.to(".glow-orb", {
        scrollTrigger: {
            trigger: ".cta-section",
            start: "top bottom",
            end: "bottom top",
            scrub: 1 // Moves with scroll
        },
        scale: 1.2,
        opacity: 0.8
    });

    // ==========================================
    // 6. Hero 3D Mouse Parallax (Optimized)
    // ==========================================
    if (window.innerWidth > 991) {
        document.addEventListener("mousemove", (e) => {
            const mouseX = (e.clientX / window.innerWidth - 0.5) * 15;
            const mouseY = (e.clientY / window.innerHeight - 0.5) * 15;

            gsap.to(".hero-card-img", {
                rotationY: -15 + mouseX,
                rotationX: 10 - mouseY,
                duration: 1,
                ease: "power2.out"
            });
        });
    }

    console.log("GSAP Premium Animation Suite Loaded.");
});
