var borderSearchBar = document.getElementById("borderSearchBar");
var counter;
var MAX_VIEW = 5;
var lastval_boolean = false;

// Get allparentContainers
// const parentContainers = document.querySelectorAll(".parent-container");
document.getElementById("sort-comments").addEventListener("change", function() {
    var selectedValue = this.value;
    window.location.href = "property.php?sort=" + selectedValue;
});

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

function redirectToPage(apartID) {
    // Go to property page and pass apartment ID has query parameter
    window.location.href = `../PropertyPage/property.php?id=${apartID}`;
}

searchbar.addEventListener('input', function () {

    var query = searchbar.value;
    dropdown.style.borderBottom = '2px solid #564B40';
    borderSearchBar.style.borderRadius = '30px 30px 0px 0px';
    dropdownThere = true;

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
                noResultItem.style.display = 'flex';
                noResultItem.style.justifyContent = 'center';
                dropdown.appendChild(noResultItem);
            } else {
                // Limit the loop to iterate only three times or up to the number of search results
                for (var i = 0; i < Math.min(data.length, MAX_VIEW); i++) {
                    var apartment = data[i];
                    //console.log(apartment.prop_id);
                    // Create a new dropdown item element
                    const dropdownItem = document.createElement('div');
                    dropdownItem.className = 'dropdown-item';
                    dropdownItem.id = 'dropdownItem';
                    streetNumName = apartment.street_num + ' ' + apartment.street_name;
                    dropdownItem.title = apartment.prop_name + ' ' + streetNumName;
                    dropdownItem.textContent = apartment.prop_name + '  -  ' + streetNumName; // Display apartment names & locations

                    // Event listeners for click, mouseover, and mouseout
                    dropdownItem.addEventListener('click', function () {
                        console.log(apartment.prop_id);
                        searchbar.value = apartment.prop_name + ', ' + streetNumName;
                        
                        console.log(searchbar.value);
                        //redirectToPage(apartment.prop_id);
                    });

                    dropdownItem.addEventListener('mouseover', function () {
                        dropdownItem.style.backgroundColor = '#D9D9D9';
                        dropdownItem.style.color = '#564B40';
                        dropdownItem.style.borderRadius = '30px 30px 30px 30px';
                    });

                    dropdownItem.addEventListener('mouseout', function () {
                        dropdownItem.style.backgroundColor = '#564B40';
                        dropdownItem.style.color = '#D9D9D9';
                    });

                    dropdown.appendChild(dropdownItem);
                }
            }

            // Add "Add Property" link as the last item
            const addPropertyItem = document.createElement('a');
            addPropertyItem.className = 'dropdown-item add-property';
            addPropertyItem.href = '../CreatePropertyPage/create.php';
            addPropertyItem.textContent = 'Add a Property';


            // Center the text within the div
            addPropertyItem.style.display = 'flex';
            addPropertyItem.style.justifyContent = 'center';


            // Remove hyperlink underline and blue color
            addPropertyItem.style.textDecoration = 'none';
            addPropertyItem.style.backgroundColor = '#ad5511';
            addPropertyItem.style.color = '#d9d9d9';
            addPropertyItem.style.borderRadius = '30px 30px 30px 30px';
            // Event listeners for mouseover and mouseout
            addPropertyItem.addEventListener('mouseover', function () {
                addPropertyItem.style.backgroundColor = '#D9D9D9';
                addPropertyItem.style.color = '#564B40';
                addPropertyItem.style.borderRadius = '30px 30px 30px 30px';
            });

            addPropertyItem.addEventListener('mouseout', function () {
                addPropertyItem.style.backgroundColor = '#ad5511';
                addPropertyItem.style.color = '#d9d9d9';
            });

            dropdown.appendChild(addPropertyItem);

            dropdown.style.display = 'block'; // Show the dropdown
        })
        .catch((error) => {
            console.error('Error:', error);
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


// get property id from query param
const urlParams = new URLSearchParams(window.location.search);
const param1Value = urlParams.get('id');

let url = 'map.php' + '?id=' + param1Value;

// Make a GET request to map.php using fetch
fetch(url)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse the response as JSON
    })
    .then(data => {
        console.log(data);
        //data is an associative array
        let latitude = data[0].lat;
        let longitude = data[0].long;
        let propName = data[0].prop_name;
        
        map.setView([latitude, longitude], 15.5); //coords + zoom level

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map); //marker

        marker.bindPopup(`${propName}`).openPopup();
    })
    .catch(error => console.error('Error:', error));

//////////////////////////////////////////////////////////////////////////

