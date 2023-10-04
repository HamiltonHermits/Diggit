var borderSearchBar = document.getElementById("borderSearchBar");
var counter;
var MAX_VIEW = 5;
var lastval_boolean = false;
var openModalBtnDashboard = document.getElementById("openModalBtnDashboard");
var sidebarOuter = document.getElementById("outer-sidebar");
var sidebar = document.getElementById("inner-sidebar");
var deleteComment = document.getElementById("deleteComment");


deleteComment.addEventListener('click', () => {
    location.reload();
 
});

// openModalBtnDashboard.addEventListener('click', () => {
//   window.location.href = "../IndexPage/index.php";
// });
//to disable the sliders
var sliderDisplay = document.getElementsByClassName("sliderDisplay");

// for (var i = 0; i < sliderDisplay.length; i++) {
//   sliderDisplay[i].disabled = true;
// }


// Function to populate stars based on data-rating
function populateStars() {
  const starContainers = document.querySelectorAll('.star-rating-display');

  starContainers.forEach((container) => {
    const rating = parseInt(container.getAttribute('data-rating'));

    // Get all the stars in the container
    const stars = container.querySelectorAll('.star');

    // Loop through the stars and set them based on the rating
    stars.forEach((star, index) => {
      if (index < rating) {
        star.innerHTML = '&#9733;'; // Filled star
      } else {
        star.innerHTML = '&#9734;'; // Not filled star
      }
    });
  });
}
// Call the function to populate stars on page load
window.addEventListener('load', populateStars);
// Get allparentContainers
// const parentContainers = document.querySelectorAll(".parent-container");
document.getElementById("sort-comments").addEventListener("change", function () {
  var selectedValue = this.value;
  window.location.href = "property.php?id=" + pageId + "&sort=" + selectedValue;
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
  if (n > slides.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = slides.length }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[slideIndex - 1].style.display = "block";

}


// comment 





