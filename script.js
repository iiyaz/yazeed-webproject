// 1. Toggle Dark / Light Mode
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
    const btn = document.getElementById("themeToggle");
    if (document.body.classList.contains("dark-mode")) {
        btn.innerText = "Light Mode";
    } else {
        btn.innerText = "Dark Mode";
    }
}

// 2. Filter Projects by Category
function filterProjects(category, buttonElement) {
    const cards = document.querySelectorAll(".project-card");
    const buttons = document.querySelectorAll(".filter-btn");

    // Update active button styling
    buttons.forEach(btn => btn.classList.remove("active"));
    buttonElement.classList.add("active");

    // Show or hide project cards
    cards.forEach(card => {
        const cardCategory = card.getAttribute("data-category");
        if (category === "all" || cardCategory === category) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

// 3. Client-Side Form Validation (from Lab 4)
function validateContactForm() {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (name === "" || email === "" || message === "") {
        alert("All fields are required!");
        return false;
    }

    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    return true;
}
