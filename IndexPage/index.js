// Get references to the modal elements
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');
var profileModal = document.getElementById('profileModal');
var changePasswordModal = document.getElementById('changePasswordModal');
var confirmDeleteModal = document.getElementById('confirmDeleteModal');

// Get references to the buttons that open and close the modals
var loginButton = document.getElementById('loginButton');
var closeLoginButton = document.getElementById('closeButton');
var signupButton = document.getElementById('signupButton');
var closeSignupButton = document.getElementById('closeSignupButton');
var searchbar = document.getElementById('searchbar');
var borderSearchBar = document.getElementById('borderSearchBar');
var dropdown = document.getElementById('dropdown');
var dropdownItem = document.getElementById('dropdownItem');
var counter;
var MAX_VIEW = 2;
var lastval_boolean = false;

var openModalBtn = document.getElementById('openModalBtn');
var closeModalBtn = document.getElementById('closeModalBtn');
var openChangePasswordModalBtn = document.getElementById('changePasswordBtn');
var closeChangePasswordModalBtn = document.getElementById('closeChangePasswordModalBtn');
var backButtonSignup = document.getElementById('backToLoginButton');
var backButtonProfile = document.getElementById('backToProfile');

var deleteProfileBtn = document.getElementById('deleteProfileBtn');
var closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
var cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

// Function to redirect to property page
function redirectToPage(apartID) {
    window.location.href = `../PropertyPage/property.php?id=${apartID}`;
}

// Event listener to handle clicks in the search bar
searchbar.addEventListener('click', function () {
    searchbar.placeholder = '';
    searchbar.style.textAlign = 'left';
    borderSearchBar.style.backgroundColor = '#564B40';
});

// Event listener to repopulate placeholder text
document.addEventListener('click', function (event) {
    var clickanywhere = event.target;

    if (clickanywhere !== searchbar && !searchbar.contains(clickanywhere)) {
        searchbar.placeholder = 'Find your Digs..';
        searchbar.style.textAlign = 'center';
        borderSearchBar.style.backgroundColor = '#202024';
    }
});

// Add an event listener to detect changes in the search bar
searchbar.addEventListener('input', function () {
    var query = searchbar.value;
    dropdown.style.borderBottom = '2px solid #564B40';
    borderSearchBar.style.borderRadius = '30px 30px 0px 0px';

    // Make an AJAX request to the server-side script
    fetch('../Backend_Files/search.php?query=' + encodeURIComponent(query))
        .then((response) => response.json())
        .then((data) => {
            dropdown.innerHTML = ''; // Clear previous dropdown items

            if (data.length === 0) {
                // Handle no matching results
                var noResultItem = document.createElement('div');
                noResultItem.className = 'no-result';
                noResultItem.textContent = 'No results found';
                dropdown.appendChild(noResultItem);
            } else {
                // Populate the dropdown with search results (limit to MAX_VIEW items)
                counter = 0;
                data.forEach(function (apartment) {
                    if (counter == MAX_VIEW) {
                        // Add "Add Property" link as the last item
                        var addPropertyItem = document.createElement('a');
                        addPropertyItem.className = 'dropdown-item add-property';
                        addPropertyItem.href = '../CreatePropertyPage/create.php'; // Temporary URL
                        addPropertyItem.textContent = 'Add a Property';

                        // Event listeners for mouseover and mouseout
                        addPropertyItem.addEventListener('mouseover', function () {
                            addPropertyItem.style.backgroundColor = '#D9D9D9';
                            addPropertyItem.style.color = '#564B40';
                            addPropertyItem.style.borderRadius = '30px 30px 30px 30px';
                        });

                        addPropertyItem.addEventListener('mouseout', function () {
                            addPropertyItem.style.backgroundColor = '#564B40';
                            addPropertyItem.style.color = '#D9D9D9';
                        });

                        dropdown.appendChild(addPropertyItem);

                        return; // Exit the loop when reaching the limit
                    }
                    counter++;

                    // Create a new dropdown item element
                    var dropdownItem = document.createElement('div');
                    dropdownItem.className = 'dropdown-item';
                    dropdownItem.id = 'dropdownItem';
                    dropdownItem.title = apartment.name + ' ' + apartment.location;

                    // Create a span element for location
                    var locationSpan = document.createElement('span');
                    locationSpan.className = 'locationSpan';
                    locationSpan.id = 'locationSpanId';
                    locationSpan.style.color = '#D9D9D9'; // Different color
                    locationSpan.textContent = apartment.location;
                    dropdownItem.textContent = apartment.name + '  -  '; // Display apartment names & locations
                    dropdownItem.appendChild(locationSpan);

                    // Event listeners for click, mouseover, and mouseout
                    dropdownItem.addEventListener('click', function () {
                        searchbar.value = apartment.name + ', ' + apartment.location;
                        redirectToPage(apartment.ID);
                    });

                    dropdownItem.addEventListener('mouseover', function () {
                        dropdownItem.style.backgroundColor = '#D9D9D9';
                        locationSpan.style.color = '#564B40';
                        dropdownItem.style.color = '#564B40';
                        dropdownItem.style.borderRadius = '30px 30px 30px 30px';
                    });

                    dropdownItem.addEventListener('mouseout', function () {
                        dropdownItem.style.backgroundColor = '#564B40';
                        locationSpan.style.color = '#D9D9D9';
                        dropdownItem.style.color = '#D9D9D9';
                    });

                    dropdown.appendChild(dropdownItem);
                });
            }

            dropdown.style.display = 'block'; // Show the dropdown
        })
        .catch((error) => {
            console.error('Error:', error);
        });
});

// Event listener to hide the dropdown when clicking outside of it
document.addEventListener('click', function (event) {
    if (event.target !== searchbar && event.target !== dropdown) {
        dropdown.style.display = 'none';
        borderSearchBar.style.borderRadius = '50px';
    }
});

// Event listeners to open and close profile
if (openModalBtn) {
    openModalBtn.addEventListener('click', function () {
        profileModal.style.display = 'block';
    });
}

backButtonProfile.addEventListener('click', function () {
    changePasswordModal.style.display = 'none';
    confirmDeleteModal.style.display = 'none';
    profileModal.style.display = 'block';
});

backButtonSignup.addEventListener('click', function () {
    signupModal.style.display = 'none';
    loginModal.style.display = 'block';
});

closeModalBtn.addEventListener('click', function () {
    profileModal.style.display = 'none';
});

// Event listeners to open and close change password modal
openChangePasswordModalBtn.addEventListener('click', function () {
    changePasswordModal.style.display = 'block';
    profileModal.style.display = 'none';
});

closeChangePasswordModalBtn.addEventListener('click', function () {
    changePasswordModal.style.display = 'none';
});

// Event listeners to open and close the login modal
if (loginButton) {
    loginButton.addEventListener('click', function () {
        loginModal.style.display = 'block';
    });
}
closeLoginButton.addEventListener('click', function () {
    loginModal.style.display = 'none';
});

// Event listener to open the signup modal
signupButton.addEventListener('click', function () {
    signupModal.style.display = 'block';
    loginModal.style.display = 'none'; // Hide the login modal when Signup is clicked
});

closeSignupButton.addEventListener('click', function () {
    signupModal.style.display = 'none';
});

// Event listeners to open/close confirm delete modal
deleteProfileBtn.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'block';
});

closeDeleteModalBtn.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'none';
});

cancelDeleteBtn.addEventListener('click', function () {
    confirmDeleteModal.style.display = 'none';
});

// Event listener to close modals if clicked outside
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
