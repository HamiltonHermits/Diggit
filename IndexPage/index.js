// Get references to the modal elements
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');
var profileModal = document.getElementById("profileModal");
var changePasswordModal = document.getElementById("changePasswordModal");
var confirmDeleteModal = document.getElementById('confirmDeleteModal');

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

var openModalBtn = document.getElementById("openModalBtn");
var closeModalBtn = document.getElementById("closeModalBtn");
var openChangePasswordModalBtn = document.getElementById("changePasswordBtn");
var changePasswordModal = document.getElementById("changePasswordModal");
var closeChangePasswordModalBtn = document.getElementById("closeChangePasswordModalBtn");

var deleteProfileBtn = document.getElementById("deleteProfileBtn");
var closeDeleteModalBtn = document.getElementById("closeDeleteModalBtn");
var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

//makes the search text disapear after clicking in it
searchbar.addEventListener('click', function () {
    searchbar.placeholder = '';
    searchbar.style.textAlign = 'left';
    borderSearchBar.style.backgroundColor = "#564B40";
});
//Add event listerners to repopulate placeholder text
document.addEventListener('click', function (event) {
    var clickanywhere = event.target;

    if (clickanywhere !== searchbar && !searchbar.contains(clickanywhere)) {
        searchbar.placeholder = 'Find your Digs..';
        searchbar.style.textAlign = 'center';
        borderSearchBar.style.backgroundColor = "#202024";
    }

});

function redirectToPage(apartID) {
    // Go to property page and pass apartment ID has query parameter
    window.location.href = `../PropertyPage/property.php?id=${apartID}`;
}

// Add an event listener to detect changes in the search bar
searchbar.addEventListener("input", function () {
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
                data.forEach(function (apartment) {

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
                    dropdownItem.addEventListener("click", function () {
                        // Set the search bar value to the selected item
                        searchbar.value = apartment.name + ", " + apartment.location;
                        // Hide the dropdown
                        redirectToPage(apartment.ID);
                    });
                    //add a mouseover event listener to change the style of the dropdownitem
                    dropdownItem.addEventListener('mouseover', function () {
                        dropdownItem.style.backgroundColor = "#D9D9D9";
                        locationSpan.style.color = "#564B40";
                        dropdownItem.style.color = "#564B40";
                        dropdownItem.style.borderRadius = "30px 30px 30px 30px";

                    });
                    //add a mouseout event listener to change the style of the dropdownitem
                    dropdownItem.addEventListener('mouseout', function () {
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
document.addEventListener("click", function (event) {
    if (event.target !== searchbar && event.target !== dropdown) {
        dropdown.style.display = "none";
        borderSearchBar.style.borderRadius = "50px"
    }
});

//add event listeners to open and close profile
if (openModalBtn) {
    openModalBtn.addEventListener('click', function () {
        profileModal.style.display = "block";
    });
}
closeModalBtn.addEventListener('click', function () {
    profileModal.style.display = "none";
});
//add event listeners to open and close change password
openChangePasswordModalBtn.addEventListener("click", function () {
    changePasswordModal.style.display = "block";
    profileModal.style.display = "none";
});

closeChangePasswordModalBtn.addEventListener("click", function () {
    changePasswordModal.style.display = "none";
});

// Add event listeners to open and close the login modal
if (loginButton) {//added an if check as it wont exist if user is logged in
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

//add event listnere to open/close confirm delete modal
deleteProfileBtn.addEventListener("click", function () {
    confirmDeleteModal.style.display = "block";

});

closeDeleteModalBtn.addEventListener("click", function () {
    confirmDeleteModal.style.display = "none";
});

cancelDeleteBtn.addEventListener("click", function () {
    confirmDeleteModal.style.display = "none";
});

//add event listener to close modals if clicked outside 
window.addEventListener('click', function (event) {
    if (event.target == loginModal) {
        loginModal.style.display = 'none';
    }
    if (event.target == profileModal) {
        profileModal.style.display = 'none';
    }
    if (event.target == signupModal) {
        signupModal.style.display = 'none';
        searchbar.placeholder = 'Find your Digs..';
    }
    if (event.target == changePasswordModal) {
        changePasswordModal.style.display = 'none';
    }
    if (event.target == confirmDeleteModal) {
        confirmDeleteModal.style.display = 'none';
    }
});

