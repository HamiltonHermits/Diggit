// Get references to the modal elements
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');

// Get references to the buttons that open and close the modals
var loginButton = document.getElementById('loginButton');
var closeLoginButton = document.getElementById('closeButton');
var signupButton = document.getElementById('signupButton');
var closeSignupButton = document.getElementById('closeSignupButton');
var searchbar = document.getElementById("searchbar");
var borderSearchBar = document.getElementById("borderSearchBar");
var dropdown = document.getElementById("dropdown");
var dropdownItem = document.getElementById("dropdownItem");
var counter;
var MAX_VIEW = 5;
var lastval_boolean = false;
//event listeners 
//makes the search text disapear after clicking in it
searchbar.addEventListener('click', function () {
    searchbar.placeholder = '';
    searchbar.style.textAlign = 'left';
    borderSearchBar.style.backgroundColor = "#564B40";
});
//Add event listerners to repopulate placeholder text
document.addEventListener('click', function (event) {
    var clickanywhere = event.target;

    if(clickanywhere !== searchbar && !searchbar.contains(clickanywhere)){
        searchbar.placeholder = 'Find your Digs..';
        searchbar.style.textAlign = 'center';
        borderSearchBar.style.backgroundColor = "#202024";
    }

});

function redirectToPage(apartment) {
    // Replace 'logged_in_page.php' with the actual URL of your logged-in page
    window.location.href = '../Backend_Files/logged_in_page.php';
}

// Add an event listener to detect changes in the search bar
searchbar.addEventListener("input", function() {
    // Get the search query from the input
    var query = searchbar.value;
    dropdown.style.borderBottom = "2px solid #564B40";
    borderSearchBar.style.borderRadius = "30px 30px 0px 0px"
    
    // Make an AJAX request to the server-side script
    fetch("../Backend_Files/search.php?query=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            // Clear previous dropdown items
            dropdown.innerHTML = "";
            
            // Check if there are no matching results
            if (data.length === 0) {
                var noResultItem = document.createElement("div");
                noResultItem.className = "no-result";
                noResultItem.textContent = "No results found";
                dropdown.appendChild(noResultItem);
            } else {
                // Populate the dropdown with search results, limiting to 5 items
                counter = 0;
                var lastVal = data[data.length - 1].location;
                data.forEach(function(apartment) {
                    
                    if (counter >= MAX_VIEW) {
                        return; // Exit the loop when reaching the limit
                    }
                    counter++;

                    var dropdownItem = document.createElement("div");
                    dropdownItem.className = "dropdown-item";
                    dropdownItem.id = "dropdownItem";
                    dropdownItem.title = apartment.name + " " + apartment.location;

                    var locationSpan = document.createElement("span");
                    locationSpan.className = "locationSpan";
                    locationSpan.id = "locationSpanId";
                    locationSpan.style.color = "#D9D9D9"; // Different color
                    locationSpan.textContent = apartment.location;
                    dropdownItem.textContent = apartment.name + '  -  '; // Display apartment names & locations
                    dropdownItem.appendChild(locationSpan);

                    // Add a click event listener to select the item when clicked
                    dropdownItem.addEventListener("click", function() {
                        // Set the search bar value to the selected item
                        searchbar.value = apartment.name + ", " + apartment.location;
                        // Hide the dropdown
                        redirectToPage();
                    });
                    //add a mouseover event listener to change the style of the dropdownitem
                    dropdownItem.addEventListener('mouseover', function() {
                        dropdownItem.style.backgroundColor = "#D9D9D9";
                        locationSpan.style.color = "#564B40";
                        dropdownItem.style.color = "#564B40";
                        dropdownItem.style.borderRadius = "30px 30px 30px 30px";
                        
                    });
                    //add a mouseout event listener to change the style of the dropdownitem
                    dropdownItem.addEventListener('mouseout', function() {
                        dropdownItem.style.backgroundColor = "#564B40";
                        locationSpan.style.color = "#D9D9D9";
                        dropdownItem.style.color = "#D9D9D9";

                    });
                    // Append the item to the dropdown
                    dropdown.appendChild(dropdownItem);
                });
            }

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
        borderSearchBar.style.borderRadius = "50px"
    }
});

// Add event listeners to open and close the login modal
if(loginButton){//added an if check as it wont exist if user is logged in
    loginButton.addEventListener('click', function () {
        loginModal.style.display = 'block';
    });
}
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
