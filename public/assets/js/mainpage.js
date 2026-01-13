document.body.classList.add('loaded');
gsap.registerPlugin(ScrollTrigger);

// Header animation
gsap.from(".banner-title", {
  y: -50,
  opacity: 0,
  duration: 1,
  ease: "power3.out"
});

gsap.from(".banner-subtitle", {
  y: 30,
  opacity: 0,
  duration: 1,
  delay: 0.3,
  ease: "power3.out"
});

// Image animation
gsap.from(".banner-image", {
  x: -100,
  opacity: 0,
  duration: 1.2,
  ease: "power3.out",
  scrollTrigger: {
    trigger: ".banner-content",
    start: "top 80%"
  }
});

// Info card animation
gsap.from(".info-card", {
  x: 100,
  opacity: 0,
  duration: 1.2,
  ease: "power3.out",
  scrollTrigger: {
    trigger: ".banner-content",
    start: "top 80%"
  }
});

// Buttons stagger animation
gsap.from(".button-group a", {
  y: 20,
  opacity: 0,
  duration: 0.8,
  stagger: 0.15,
  scrollTrigger: {
    trigger: ".button-group",
    start: "top 90%"
  }
});
