var borderSearchBar = document.getElementById("borderSearchBar");
var counter;
var MAX_VIEW = 5;
var lastval_boolean = false;

// Get allparentContainers
const parentContainers = document.querySelectorAll(".parent-container");

// Function to check if an element is in the viewport
function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= - 300 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight + 300 || document.documentElement.clientHeight + 300) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

function updateActivePageIndicator() {
    parentContainers.forEach(function(page) { // loop through each parent page
        const target = page.dataset.target; // associated sidebar element for this current parent page
        const sidebarElement = document.getElementById(target); // get the sidebar element

        if (isElementInViewport(page)) { // if the parent page is in the viewport
            sidebarElement.classList.add("current-page-bg-effect"); // add the background effect to sidebar element
        } else {
            sidebarElement.classList.remove("current-page-bg-effect");
        }
    });
}

//makes the search text disapear after clicking in it
searchbar.addEventListener('click', function () {
    searchbar.placeholder = '';
    searchbar.style.textAlign = 'left';
    // borderSearchBar.style.backgroundColor = "#564B40";
});
//Add event listerners to repopulate placeholder text
document.addEventListener('click', function (event) {
    var clickanywhere = event.target;

    if(clickanywhere !== searchbar && !searchbar.contains(clickanywhere)){
        searchbar.placeholder = 'Find your Digs..';
        searchbar.style.textAlign = 'center';
        // borderSearchBar.style.backgroundColor = "#202024";
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
    dropdown.style.backgroundColor = "#202024";
    // borderSearchBar.style.borderRadius = "30px 30px 0px 0px"
    
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
                        dropdownItem.style.border = "#AD5511 2px solid"
                        // dropdownItem.style.backgroundColor = "#D9D9D9";
                        // locationSpan.style.color = "#564B40";
                        // dropdownItem.style.color = "#564B40";
                        // dropdownItem.style.borderRadius = "30px 30px 30px 30px";
                        
                    });
                    //add a mouseout event listener to change the style of the dropdownitem
                    dropdownItem.addEventListener('mouseout', function() {
                        // dropdownItem.style.backgroundColor = "#564B40";
                        dropdownItem.style.border = "none"
                        // locationSpan.style.color = "#D9D9D9";
                        // dropdownItem.style.color = "#D9D9D9";

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
        searchbar.style.textAlign = 'left';
    }
});

//////////////////////////////////////////////////////////////////////////
// Map implementation

var map = L.map('map');
var latitude = -33.3089706;
var longitude = 26.5209919;
var propName = "The Greens";

map.setView([latitude, longitude], 15.5); //coords + zoom level

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([latitude, longitude]).addTo(map); //marker

marker.bindPopup(`${propName}`).openPopup();

//////////////////////////////////////////////////////////////////////////

// Listen for scroll events
window.addEventListener("scroll", updateActivePageIndicator);

// Initial check (in case user starts midway down the page)
updateActivePageIndicator();
