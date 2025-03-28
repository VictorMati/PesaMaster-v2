document.addEventListener("DOMContentLoaded", function () {
    const heroTextElement = document.querySelector("#hero p");

    if (!heroTextElement) return; // Prevent errors if element is missing

    const texts = [
        "Manage Your Finances Easily with PesaMaster.",
        "Track Transactions and Budget Smartly.",
        "Secure and Reliable Finance Management.",
        "Your Business, Your Control."
    ];

    let currentIndex = 0;
    let letterIndex = 0;
    let isDeleting = false;

    function animateText() {
        const currentText = texts[currentIndex];

        if (isDeleting) {
            heroTextElement.textContent = currentText.substring(0, letterIndex - 1);
            letterIndex--;

            if (letterIndex === 0) {
                isDeleting = false;
                currentIndex = (currentIndex + 1) % texts.length;
                setTimeout(animateText, 1000); // Pause before new text
            } else {
                setTimeout(animateText, 100);
            }
        } else {
            heroTextElement.textContent = currentText.substring(0, letterIndex + 1);
            letterIndex++;

            if (letterIndex === currentText.length) {
                isDeleting = true;
                setTimeout(animateText, 3000); // Pause before deleting
            } else {
                setTimeout(animateText, 100);
            }
        }
    }

    setTimeout(animateText, 2000); // Initial delay before animation starts
});
