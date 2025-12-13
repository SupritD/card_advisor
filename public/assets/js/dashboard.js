const sidebar = document.getElementById("sidebar");
const topbar = document.getElementById("topbar");
const content = document.getElementById("content");
const toggleSidebar = document.getElementById("toggleSidebar");

// Toggle Sidebar
toggleSidebar.addEventListener("click", (e) => {
    e.stopPropagation();

    // Desktop >= 992px
    if (window.innerWidth >= 992) {
        sidebar.classList.toggle("minimized");
        topbar.classList.toggle("minimized");
        content.classList.toggle("minimized");
        return;
    }

    // Mobile
    sidebar.classList.toggle("show");
});

// Prevent immediate close when clicking inside sidebar
sidebar.addEventListener("click", (e) => {
    e.stopPropagation();
});

// Close mobile sidebar when clicking outside
document.addEventListener("click", () => {
    if (window.innerWidth < 992) {
        sidebar.classList.remove("show");
    }
});

// Sidebar Dropdowns
document.querySelectorAll(".menu-dropdown").forEach((drop) => {
    const btn = drop.querySelector(".dropdown-toggle-btn");

    btn.addEventListener("click", (e) => {
        e.stopPropagation();

        // Close all other dropdowns
        document.querySelectorAll(".menu-dropdown.open").forEach((d) => {
            if (d !== drop) d.classList.remove("open");
        });

        drop.classList.toggle("open");
    });
});
