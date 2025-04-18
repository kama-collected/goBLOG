//Added by kama
function toggleText(button) {
    const preview = button.previousElementSibling.previousElementSibling;
    const fullText = button.previousElementSibling;

    if (fullText.style.display === "none") {
        preview.style.display = "none";
        fullText.style.display = "inline";
        button.textContent = "See less...";
    } else {
        preview.style.display = "inline";
        fullText.style.display = "none";
        button.textContent = "See more...";
    }
}

// Make it available globally
window.toggleText = toggleText;
