var borderSearchBar = document.getElementById("borderSearchBar");

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

// Add an event listener to detect changes in the search bar
searchbar.addEventListener("input", function() {
    // Get the search query from the input
    var query = searchbar.value;
    dropdown.style.borderBottom = "2px solid #564B40";
    borderSearchBar.style.borderRadius = "30px 30px 0px 0px"
    
    
    // Make an AJAX request to the server-side script
    fetch("./testSearch.php?query=" + encodeURIComponent(query))
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
