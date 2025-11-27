const hamburgerEl = document.getElementById("hamburger-menu");
const sidebarEl = document.getElementById("sidebar");
const backdrop = document.getElementById("backdrop");
const closeSidebarEl = document.getElementById("close-sidebar");

// function for sidebar toggle with lenis scroll control
const toggleSidebar = () => {
	sidebarEl.classList.toggle("sidebar-open");
	backdrop.classList.toggle("hidden");

	// Adjust sidebar position based on visibility
	if (sidebarEl.classList.contains("sidebar-open")) {
		// non active lenis scroll
		lenis.stop();
		sidebarEl.style.left = "0";
	} else {
		// active lenis scroll
		lenis.start();
		sidebarEl.style.left = "-100%";
	}
};

// Toggle sidebar visibility on hamburger menu click
hamburgerEl.addEventListener("click", toggleSidebar);

// Close sidebar on backdrop click
backdrop.addEventListener("click", toggleSidebar);

// Close sidebar on close button click
closeSidebarEl.addEventListener("click", toggleSidebar);

// Close sidebar on escape key press
document.addEventListener("keydown", function (event) {
	if (event.key === "Escape") {
		sidebarEl.classList.remove("sidebar-open");
		backdrop.classList.add("hidden");
		sidebarEl.style.left = "-100%";
		// active lenis scroll
		lenis.start();
	}
});
