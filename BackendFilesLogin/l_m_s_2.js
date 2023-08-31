// Get elements
const loginButton = document.getElementById("loginButton");
const loginModal = document.getElementById("loginModal");
const closeButton = document.getElementById("closeButton");
const loginForm = document.getElementById("loginForm");

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

// Add an event listener for form submission
loginForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting traditionally

    // Get the form data (username and password)
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Send a POST request to your server
    fetch("login.php", {
        method: "POST",
        body: JSON.stringify({ username: username, password: password }),
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then(response => response.json())
    .then(data => {
        // Check the response for login success or failure
        if (data.success) {
            // Login was successful, you can close the modal or take other actions
            loginModal.style.display = "none"; // Close the modal
            window.location.href = "dashboard.php"; // Redirect to the dashboard or other page
        } else {
            // Login failed, display an error message to the user
            displayErrorMessage(data.error); // You should implement this function
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});