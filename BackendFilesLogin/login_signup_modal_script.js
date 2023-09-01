// Get references to the modal elements
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');

// Get references to the buttons that open and close the modals
var loginButton = document.getElementById('loginButton');
var closeLoginButton = document.getElementById('closeButton');
var signupButton = document.getElementById('signupButton');
var closeSignupButton = document.getElementById('closeSignupButton');

// Add event listeners to open and close the login modal
loginButton.addEventListener('click', function() {
    loginModal.style.display = 'block';
});

closeLoginButton.addEventListener('click', function() {
    loginModal.style.display = 'none';
});

// Add event listener to open the signup modal
signupButton.addEventListener('click', function() {
    signupModal.style.display = 'block';
    
    // Hide the login modal when Signup is clicked
    loginModal.style.display = 'none';
});

closeSignupButton.addEventListener('click', function() {
    signupModal.style.display = 'none';
});

// Add an event listener to close the signup modal if the user clicks outside the modal
window.addEventListener('click', function(event) {
    if (event.target == signupModal) {
        signupModal.style.display = 'none';
    }
});