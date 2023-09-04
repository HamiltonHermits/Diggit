// Get references to the modal elements
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');

// Get references to the buttons that open and close the modals
var loginButton = document.getElementById('loginButton');
var closeLoginButton = document.getElementById('closeButton');
var signupButton = document.getElementById('signupButton');
var closeSignupButton = document.getElementById('closeSignupButton');
var searchbar = document.getElementById('searchbar');

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

searchbar.addEventListener("input", function() {
    // Get the search query from the input
    var query = searchbar.value;

    // Make an AJAX request to the server-side script
    fetch("../BackendFilesLogin/search.php?query=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            // Handle the received search results (data) here

            // Clear previous search results
            //resultsContainer.innerHTML = "";

            if (data.length === 0) {
                // No results found
                // resultsContainer.innerHTML = "<p>No results found.</p>";
                console.log("No results found");
            } else {
                // Display each search result
                console.log("Some results were found");
                // data.forEach(function(apartment) {

                //     var resultItem = document.createElement("div");
                //     resultItem.className = "result-item";

                //     // Populate the result item with apartment information
                //     resultItem.innerHTML = `
                //         <h3>${apartment.name}</h3>
                //         <p>Location: ${apartment.location}</p>
                //     `;

                //     // Append the result item to the results container
                //     resultsContainer.appendChild(resultItem);
                // });
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
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
