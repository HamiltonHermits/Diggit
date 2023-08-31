// JavaScript to display/hide the login modal

// Get elements
const loginButton = document.getElementById("loginButton");
const loginModal = document.getElementById("loginModal");
const closeButton = document.getElementById("closeButton");

// Show the login modal when the login button is clicked
loginButton.addEventListener("click", () => {
    loginModal.style.display = "block";
});

// Close the login modal when the close button is clicked
closeButton.addEventListener("click", () => {
    loginModal.style.display = "none";
});

// Close the login modal if the user clicks outside of it
window.addEventListener("click", (event) => {
    if (event.target === loginModal) {
        loginModal.style.display = "none";
    }
});