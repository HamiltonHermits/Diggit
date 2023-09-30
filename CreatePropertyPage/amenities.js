
var addMenityButton = document.getElementById('addAmenities');
var amenityModal = document.getElementById('ammenityModal');
var addMoreButton = document.getElementById('addMoreButton');
var closeAmenityButton = document.getElementById('closeAmenityButton');
var amenityTable = document.getElementById("ammenityTable");
var submitAmmenityBtn = document.getElementById("submitAmenitiesBtn");


//listen for the submitAmenity button to be clicked
var arrayOfAmenityIds = [];
submitAmmenityBtn.addEventListener('click', function () {
    var input = amenityTable.getElementsByTagName("input");
    var names = amenityTable.getElementsByClassName("name");
    arrayOfAmenityIds = [];
    for (let i = 0; i < names.length; i++) {
        if(input[i].checked){
            // if not in array add it
            if (!arrayOfAmenityIds.includes(names[i].id)) {
                arrayOfAmenityIds.push(names[i].id);
            }
        }
    }
    amenityModal.style.display = 'none';
    addMenityButton.style.display = 'none';
    console.log(arrayOfAmenityIds);
});

closeAmenityButton.addEventListener('click', function () {
    amenityModal.style.display = 'none';
});
addMoreButton.addEventListener('click', function () {
    amenityModal.style.display = 'block';
});
// submitAmmenityBtn.addEventListener('click', function () {
//     // var checkBoxes = amenityTable.getElementsByTagName("INPUT");
//     var names = amenityTable.getElementsByClassName("name");
//     // arr = [];
//     // arr2 = [];

//     names.forEach(amenity => {
//         if (amenity.checked) {
//             console.log(amenity.id);
//             arr2.push(amenity.id);
//         }
//     });

//     console.log("arr2 pelase work " + arr2);

//     //     for (let i = 0; i < checkBoxes.length; i++) {
//     //         if(checkBoxes[i].checked){
//     //             arr.push(i)
//     //     }
//     // }
//     // count = 0;
//     // for (let i = 0; i < names.length; i++) {
//     //     if(arr.includes(i)){
//     //         // push the id of the element into the array
//     //         arr2.push(names[i].id);
//     //     }
//     // }
//     // use arr2 in the createPropertyForm.js
//     // console.log(arr2);
//         amenityModal.style.display = 'block';
//     });

if(addMenityButton){
    addMenityButton.addEventListener('click', function () {
    amenityModal.style.display = 'block';
    });
    window.addEventListener('click', function (event) {
        if (event.target == amenityModal) {
            amenityModal.style.display = 'none';
        }
    });
}