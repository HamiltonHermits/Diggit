
var addMenityButton = document.getElementById('addAmenities');
var amenityModal = document.getElementById('ammenityModal');
var addMoreButton = document.getElementById('addMoreButton');
var closeAmenityButton = document.getElementById('closeAmenityButton');
var amenityTable = document.getElementById("ammenityTable");
var submitAmmenityBtn = document.getElementById("submitAmenitiesBtn");
const amenitiesContainer = document.getElementsByClassName("amenities-container")[0];
const addAmenitiesOverlay = document.getElementsByClassName("add-amenities-overlay")[0];


//listen for the submitAmenity button to be clicked
let totalArrayOfAmenityNames = []; // this array will hold all the amenities selected even if user clics add more
var arrayOfAmenityIds = [];
submitAmmenityBtn.addEventListener('click', function () {
    addAmenitiesOverlay.style.display = 'none';
    console.log("totalarray = ");
    console.log(totalArrayOfAmenityNames);
    let arrayOfAmenityNames = []; // array holds amenities selected in the modal, will be deleted when modal closes
    var input = amenityTable.getElementsByTagName("input");
    var names = amenityTable.getElementsByClassName("name");
    arrayOfAmenityIds = [];
    for (let i = 0; i < names.length; i++) {
        if(input[i].checked){
            // if not in array add it
            if (!totalArrayOfAmenityNames.includes(names[i].id)) {
                arrayOfAmenityIds.push(names[i].id);
                arrayOfAmenityNames.push(names[i].innerHTML);
                totalArrayOfAmenityNames.push(names[i].id);
            }
        }
    }
    amenityModal.style.display = 'none';
    addMenityButton.style.display = 'none';
    console.log(arrayOfAmenityIds);
    console.log(arrayOfAmenityNames);

    // calc the number of amenities selected
    const numAmenities = arrayOfAmenityIds.length;
    // const numColumns = Math.min(3, numAmenities); // set a maximum of 3 columns

    // calcthe number of rows needed to accommodate all amenities
    // const numRows = Math.ceil(numAmenities / numColumns);
    // console.log("numColumns = " + numColumns + " numRows = " + numRows);

    // const numColumns = (numAmenities % 8) ; 

    // when submit button clicked change the display of the amenities container to grid 
    amenitiesContainer.style.display = "grid";
    amenitiesContainer.style.gridTemplateColumns = `repeat(auto-fill, minmax(35%, 1fr))`;

    // populate the table with the amenities (checked radio inputs)
    // iterate through the array of amenities
    for (let index = 0; index < arrayOfAmenityIds.length; index++) {
        // create a new div element
        let amenity = document.createElement("div");
        amenity.style = "text-align: center; border: 1px solid #ccc; border-radius: 5px; margin: 5%; padding: 1%;"
        amenity.classList.add("amenity");
        amenity.id = arrayOfAmenityIds[index];
        amenity.innerHTML = arrayOfAmenityNames[index];
        amenitiesContainer.appendChild(amenity);    
    }
});

closeAmenityButton.addEventListener('click', function () {
    amenityModal.style.display = 'none';
});
addMoreButton.addEventListener('click', function () {
    amenityModal.style.display = 'block';
});

if(addMenityButton){
    addMenityButton.addEventListener('click', function () {
        amenityModal.style.display = 'block';

        console.log("in the add amenity button click event");
    });
    window.addEventListener('click', function (event) {
        if (event.target == amenityModal) {
            amenityModal.style.display = 'none';


            console.log("in the window click event");

        }
    });
}