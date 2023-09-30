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

// Images slideshow
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("propertyImage");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";

}