var searchbar = document.getElementById('searchbar');
var borderSearchBar = document.getElementById('borderSearchBar');
var dropdown = document.getElementById('dropdown');
var dropdownItem = document.getElementById('dropdownItem');
var counter;
var MAX_VIEW = 3;
var lastval_boolean = false;
var searchBarCheck = true;
var dropdownThere = false;
var filterOption = null;


// Function to redirect to property page
function redirectToPage(apartID) {
    window.location.href = `../PropertyPage/property.php?id=${apartID}`;
}

function handleApartmentClick(apartment) {
    return function () {
        //console.log(apartment.prop_id);
        searchbar.value = apartment.prop_name;
        redirectToPage(apartment.prop_id);
    };
}
// Event listener to handle clicks in the search bar
searchbar.addEventListener('click', function () {
    searchbar.placeholder = '';
    searchbar.style.textAlign = 'left';
    borderSearchBar.style.backgroundColor = '#564B40';
    if (dropdown && dropdownThere) {
        dropdown.style.display = 'block'; // Show the dropdown
        dropdown.style.borderBottom = '2px solid #564B40';
        borderSearchBar.style.borderRadius = '30px 30px 0px 0px';
    }
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


searchbar.addEventListener('input', function () {

    var query = searchbar.value;
    dropdown.style.borderBottom = '2px solid #564B40';
    borderSearchBar.style.borderRadius = '30px 30px 0px 0px';
    dropdownThere = true;

    // Make an AJAX request to the server-side script with the query string and filter option
    fetch('../Backend_Files/search.php?query=' + query + '&filterOption=' + filterOption)
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
                    console.log(apartment);
                    //console.log(apartment.prop_id);
                    // Create a new dropdown item element
                    const dropdownItem = document.createElement('div');
                    dropdownItem.className = 'dropdown-item';
                    dropdownItem.id = 'dropdownItem';
                    var streetNumName = "";
                    if (apartment.address && apartment.address.trim() !== "") {
                        streetNumName = apartment.address;
                    }
                    dropdownItem.title = apartment.prop_name + (streetNumName ? ' ' + streetNumName : '');

                    // add the overall property rating to textConent
                    dropdownItem.textContent = apartment.prop_name + (streetNumName ? '  -  ' + streetNumName : '');

                    // if overall_property_rating exists in the apartment object, add it to the textContent
                    if (apartment.overall_property_rating) {
                        dropdownItem.textContent += '  -  ' + apartment.overall_property_rating + ' ★';
                    }
                    


                    // Event listeners for click, mouseover, and mouseout

                    dropdownItem.addEventListener('click', handleApartmentClick(apartment));


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

// Event listener to hide the dropdown when clicking outside of it
document.addEventListener('click', function (event) {
    if (event.target !== searchbar && event.target !== dropdown) {
        dropdown.style.display = 'none';
        borderSearchBar.style.borderRadius = '50px';
    }
});

// get dash div
const dash = document.getElementById('dash');
const outerSidebar = document.getElementById('outer-index-sidebar-container');
const closeSidebarBtn = document.getElementById('close-sidebar-btn');

// // sidebar 
dash.addEventListener('click', function () {
    console.log('dash clicked');
    outerSidebar.style.display = 'block';
});

closeSidebarBtn.addEventListener('click', function (event) {
        outerSidebar.style.display = 'none';
});

// document.addEventListener('DOMContentLoaded', function() {
//     const dashElement = document.getElementById('dash');
//     const sidebarContainer = document.getElementById('outer-index-sidebar-container');

//     // Function to open sidebar
//     function openSidebar() {
//         console.log("open sidebar");
//         sidebarContainer.style.display = 'block';
//     }

//     // Function to close sidebar
//     function closeSidebar() {
//         sidebarContainer.style.display = 'none';
//     }

//     // Click event for 'dash' element
//     dashElement.addEventListener('click', openSidebar);

//     // Click event for window (to close sidebar when clicking outside)
//     window.addEventListener('click', function(event) {
//         if (event.target !== sidebarContainer && event.target !== dashElement) {
//             closeSidebar();
//         }
//     });
// });

// document.addEventListener('DOMContentLoaded', function() {
//     const dashElement = document.getElementById('dash');
//     const sidebarContainer = document.getElementById('outer-index-sidebar-container');

//     // Function to open sidebar
//     function openSidebar() {
//         sidebarContainer.style.display = 'block';
//     }

//     // Function to close sidebar
//     function closeSidebar() {
//         sidebarContainer.style.display = 'none';
//     }

//     // Click event for 'dash' element
//     dashElement.addEventListener('click', openSidebar);

//     // Click event for the whole document
//     document.addEventListener('click', function(event) {
//         if (!sidebarContainer.contains(event.target) && event.target !== dashElement) {
//             closeSidebar();
//         }
//     });
// });



// FILTER SEARCH

// document.addEventListener('DOMContentLoaded', function() {
//     // Add an event listener for the filter button click
//     document.getElementById('filterButton').addEventListener('click', function() {
//         // Get the selected filter option and sort option
//         var filterOption = document.getElementById('filterSelect').value;
//         var sortOption = document.querySelector('input[name="sortOption"]:checked').value;

//         console.log(filterOption);
//         console.log(sortOption);

//         // Define the URL for the AJAX query
//         var url = 'filterSearch.php';

//         // Define the parameters for the fetch request
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    const filterSelect = document.getElementById('filterSelect');

    // Event listener for the filter select
    filterSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        filterOption = selectedValue; //set global filter option var to selected value      
        console.log(filterOption);
    });
});


