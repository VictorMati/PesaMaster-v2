// Enhanced JavaScript
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const toggleButtons = document.querySelectorAll(".toggle-sidebar");
    const toggleIcon = document.querySelector(".toggle-sidebar i");

    // Toggle Sidebar
    toggleButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.stopPropagation();
            sidebar.classList.toggle("collapsed");
            toggleIcon.classList.toggle("fa-chevron-left");
            toggleIcon.classList.toggle("fa-chevron-right");
        });
    });

    // Close tooltips when clicking outside
    document.addEventListener("click", function (e) {
        if (!sidebar.contains(e.target)) {
            document.querySelectorAll(".tooltip").forEach(tooltip => {
                tooltip.style.opacity = "0";
            });
        }
    });

    // Mobile hover simulation
    if (window.matchMedia("(hover: none)").matches) {
        document.querySelectorAll(".sidebar-nav ul li").forEach(item => {
            item.addEventListener("click", function () {
                this.querySelector(".tooltip").style.opacity = "0";
            });
        });
    }
});


// Add this to your layout.js
document.addEventListener('DOMContentLoaded', function() {
    const profile = document.querySelector('.profile');
    const profileImg = document.querySelector('.profile-img');

    // Toggle menu on click (mobile friendly)
    profileImg.addEventListener('click', function(e) {
        e.stopPropagation();
        profile.classList.toggle('active');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!profile.contains(e.target)) {
            profile.classList.remove('active');
        }
    });

    // Hover functionality for desktop
    if (window.matchMedia("(hover: hover)").matches) {
        profile.addEventListener('mouseenter', function() {
            profile.classList.add('active');
        });

        profile.addEventListener('mouseleave', function() {
            profile.classList.remove('active');
        });
    }
});
    // Logout confirmation
    const logoutLinks = document.querySelectorAll("[data-logout]");
    logoutLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            if (confirm("Are you sure you want to log out?")) {
                document.getElementById("logout-form").submit();
            }
        });
    });

    // Search bar auto-clear
    const searchInput = document.querySelector(".search-bar");
    if (searchInput) {
        searchInput.addEventListener("focus", function () {
            this.value = "";
        });
    }

