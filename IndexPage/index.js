// Get references to the modal elements
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');

// Get references to the buttons that open and close the modals
var loginButton = document.getElementById('loginButton');
var closeLoginButton = document.getElementById('closeButton');
var signupButton = document.getElementById('signupButton');
var closeSignupButton = document.getElementById('closeSignupButton');
var searchbar = document.getElementById("searchbar");
var dropdown = document.getElementById("dropdown");

//event listeners 
//makes the search text disapear after clicking in it
searchbar.addEventListener('click', function () {
    searchbar.placeholder = '';
});
//Add event listerners to repopulate placeholder text
document.addEventListener('click', function (event) {
    var clickanywhere = event.target;

    if(clickanywhere !== searchbar && !searchbar.contains(clickanywhere)){
        searchbar.placeholder = 'Find your Digs..';
    }

});

function redirectToPage(apartment) {
    // Replace 'logged_in_page.php' with the actual URL of your logged-in page
    window.location.href = '../BackendFilesLogin/logged_in_page.php';
}

// Add an event listener to detect changes in the search bar
searchbar.addEventListener("input", function() {
    // Get the search query from the input
    var query = searchbar.value;

    // Make an AJAX request to the server-side script
    fetch("../BackendFilesLogin/search.php?query=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            // Clear previous dropdown items
            dropdown.innerHTML = "";

            // Populate the dropdown with search results
            data.forEach(function(apartment) {
                var dropdownItem = document.createElement("div");
                dropdownItem.className = "dropdown-item";
                dropdownItem.textContent = apartment.name; // Display apartment names

                // Add a click event listener to select the item when clicked
                dropdownItem.addEventListener("click", function() {
                    // Set the search bar value to the selected item
                    searchbar.value = apartment.name;
                    // Hide the dropdown
                    redirectToPage();
                });

                // Append the item to the dropdown
                dropdown.appendChild(dropdownItem);
            });

            // Show the dropdown
            dropdown.style.display = "block";
        })
        .catch(error => {
            console.error("Error:", error);
        });
});

// Hide the dropdown when clicking outside of it
document.addEventListener("click", function(event) {
    if (event.target !== searchbar && event.target !== dropdown) {
        dropdown.style.display = "none";
    }
});

// Add event listeners to open and close the login modal
loginButton.addEventListener('click', function () {
    loginModal.style.display = 'block';
});

closeLoginButton.addEventListener('click', function () {
    loginModal.style.display = 'none';
});

// Add event listener to open the signup modal
signupButton.addEventListener('click', function () {
    signupModal.style.display = 'block';

    // Hide the login modal when Signup is clicked
    loginModal.style.display = 'none';
});

closeSignupButton.addEventListener('click', function () {
    signupModal.style.display = 'none';
});

window.addEventListener('click', function (event) {
    if (event.target == loginModal) {
        loginModal.style.display = 'none';
    }
});
// Add an event listener to close the signup modal if the user clicks outside the modal
window.addEventListener('click', function (event) {
    if (event.target == signupModal) {
        signupModal.style.display = 'none';
        searchbar.placeholder = 'Find your Digs..';
    }
});
