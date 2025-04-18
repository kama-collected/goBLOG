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

function toggleMenu(icon) {
    const menu = icon.nextElementSibling;
    menu.classList.toggle('hidden');
    
    // Optional: close all other menus
    document.querySelectorAll('.menu').forEach(m => {
        if (m !== menu) m.classList.add('hidden');
    });
}

// Close the menu if clicked outside
document.addEventListener('click', function (e) {
    const isMenu = e.target.closest('.menu-wrapper');
    if (!isMenu) {
        document.querySelectorAll('.menu').forEach(menu => menu.classList.add('hidden'));
    }
});

window.toggleMenu = toggleMenu;