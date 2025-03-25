document.addEventListener("DOMContentLoaded", function () {
    // Sidebar toggle functionality
    const sidebar = document.querySelector(".sidebar");
    const toggleButtons = document.querySelectorAll(".toggle-sidebar");

    toggleButtons.forEach(button => {
        button.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");
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
});
