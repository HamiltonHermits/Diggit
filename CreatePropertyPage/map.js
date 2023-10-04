var latitudeGlobal = 0;
var longitudeGlobal = 0;

// only initialse a map if it doesn't already exist
if (typeof map === 'undefined') {
    console.log("inside undefined thing");
    var map = L.map('map');
    console.log("map created");
    generateMapDynamic(-32.5, 25, 5.3);

    // latitudeGlobal = 0;
    // longitudeGlobal = 0;
    console.log("lat long = inside top thing");
    console.log(latitudeGlobal, longitudeGlobal);
}

var markerLayer = L.layerGroup();
markerLayer.addTo(map); // add the marker layer to the map
var markerAdded = false;

var manualEntry = false; //boolean to check if user has manually entered address



//make map visible if a location is found
// document.querySelector(".bottom-container").style.visibility = "visible";

// generateMapDynamic(-32.5, 25, 5.3);

//default function to generate a map dyamically based on which location the user picks
function generateMapDynamic(latitude, longitude, zoom) {
    console.log("generateMapDynamic");
    //if zoom undefined then set to 15.5
    if (typeof zoom === 'undefined') {
        zoom = 15.5;
    }
    
    map.setView([latitude, longitude], zoom); //coords + zoom level
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    
    // var marker = L.marker([latitude, longitude]).addTo(map); //marker
    console.log("lat long =");
    console.log(latitudeGlobal, longitudeGlobal);
}

// if the user has decided to manually enter their address
function generateMapIfNoLocation(latitude, longitude) {
    map.setView([latitude, longitude], 0);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
}

// Function to add a marker to the map
function addMarker(e) {
    if (true) { // if user manually entered address)
        if (markerAdded) {
            markerLayer.clearLayers(); // Remove the existing marker if it exists
        }

        var marker = L.marker(e.latlng).addTo(markerLayer);
        // get lat and long of the marker
        latitudeGlobal = e.latlng.lat;
        longitudeGlobal = e.latlng.lng;
        console.log("You clicked the map at " + e.latlng);
        markerAdded = true;
    }
}

function addMarkerToMap(latitude, longitude) {
    console.log("we made it to addMarkerToMap");
    // L.marker([latitude, longitude]).addTo(markerLayer);
    // append text tothe marker
    L.marker([latitude, longitude]).addTo(markerLayer).bindPopup("Property was originally added here").openPopup();
    generateMapDynamic(latitude, longitude, 15.5);
    latitudeGlobal = latitude;
    longitudeGlobal = longitude;

    // map.setView([latitude, longitude], 5.3);
}


// If the user decides to manually enter their address
// Add the click event listener to the map
map.on('click', addMarker);


var address = document.querySelector("#address");
var results = document.querySelector("#coord-results");
var addressArr = []; 

//if search map button is clicked or enter is pressed then find address
document.querySelector("#search-map-btn").addEventListener("click", findAddress);
document.querySelector("#address").addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
        findAddress();
    }
});

function showAddress() {
    results.innerHTML  = ' ';



    if (addressArr.length > 0) {
        addressArr.forEach(element => {
            manualEntry = false; //boolean to check if user has manually entered address

            //create location input element of type radio
            let locationContainer = document.createElement("div");
            locationContainer.className = "locationContainer";
            locationContainer.style = "border: 1px solid #1e1e1e; background-color: #29292c; border-radius: 5px; margin: 2%; padding: 2%;";

            let radio = document.createElement("input");
            radio.type = "radio";
            radio.className = "location";
            radio.name = "location";
            radio.value = element.display_name+","+element.lat+","+element.lon;

            let locationLabel = document.createElement("label");
            locationLabel.htmlFor = "location";
            locationLabel.innerHTML = element.display_name;
            locationContainer.appendChild(radio);
            locationContainer.appendChild(locationLabel);
            results.appendChild(locationContainer);

            //on location element moverover
            locationContainer.addEventListener('mouseover', function() {
                //add styling
            });

            // on location element mouseout
            locationContainer.addEventListener('mouseout', function() {
                //add styling
            });

            //if location result is clicked event listener
            locationContainer.addEventListener("click", function() {
                console.log("location clicked");
                //check the radio button
                radio.checked = true;

                //pass in the lat and long of the location to the map
                generateMapDynamic(element.lat, element.lon);
                
            });
        });

        // create div
        let suggestion = document.createElement("div");
        suggestion.style = "display: inline-block;";
        suggestion.className = "suggestion";
        suggestion.innerHTML = "If you can't find your address, click the map to pin your property.";
        results.appendChild(suggestion);
    } else {
        manualAddressEntry();
    }   
}

function manualAddressEntry() {
    manualEntry = true;
        
    //set map visibility to hidden
    // document.querySelector(".bottom-container").style.visibility = "hidden";
    //let user manually type in address and select point on the map
    results.innerHTML  = "<p><span style='color: red;'>Location no present in database</span></p>";
    results.innerHTML  += "<span>If you want a map of your property displayed, please select a point on the map:</span><br>";

    //set map visibility to hidden
    // document.querySelector(".bottom-container").style.visibility = "visible";
    generateMapDynamic(-32.5, 25, 5.3);
}

function findAddress() {
    var url = "https://nominatim.openstreetmap.org/search?format=json&limit=3&q=" + address.value;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            addressArr = data;
            showAddress(); // Move this inside the 'then' block to ensure addressArr is populated before calling showAddress
        })
        .catch(err => console.log(err));
}