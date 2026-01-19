const DESKTOP_BREAKPOINT = 500;

function setDefaultSidebarState() {
  const w = window.innerWidth;

  if (w >= DESKTOP_BREAKPOINT) {
    sidebar.classList.add("minimized");
    sidebar.classList.remove("show");
    topbar.classList.add("minimized");
    content.classList.add("minimized");
  } else {
    sidebar.classList.remove("minimized");
    sidebar.classList.remove("show");
    topbar.classList.remove("minimized");
    content.classList.remove("minimized");
  }
}

setDefaultSidebarState();
window.addEventListener("resize", setDefaultSidebarState);

toggleSidebar.addEventListener("click", (e) => {
  e.stopPropagation();
  const w = window.innerWidth;

  if (w >= DESKTOP_BREAKPOINT) {
    sidebar.classList.toggle("minimized");
    topbar.classList.toggle("minimized");
    content.classList.toggle("minimized");
  } else {
    sidebar.classList.toggle("show");
  }
});
