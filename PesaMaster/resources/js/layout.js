document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const toggleButtons = document.querySelectorAll(".toggle-sidebar");
    const toggleIcon = document.querySelector(".toggle-sidebar i");

    toggleButtons.forEach(button => {
        button.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");

            // Toggle between chevron-left and chevron-right
            if (sidebar.classList.contains("collapsed")) {
                toggleIcon.classList.remove("fa-chevron-left");
                toggleIcon.classList.add("fa-chevron-right");
            } else {
                toggleIcon.classList.remove("fa-chevron-right");
                toggleIcon.classList.add("fa-chevron-left");
            }
        });
    });
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

