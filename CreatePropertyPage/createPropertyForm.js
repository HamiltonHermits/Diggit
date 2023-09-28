// get the form elements
const titleInput = document.getElementById('newPropertyTitle');
const fileInput = document.getElementById('file');
const descriptionInput = document.getElementById('desc-text-field');
const searchbarInput = document.getElementById('searchbar');
const amenitysInput = arr2; // of type array
const tenantsInput = emailArray; // of type array

// if save property button is pressed
document.getElementById('save-property').addEventListener('click', function () {
    // check if all the input fields are filled out 
    // titleInput.value.trim() !== "" && fileInput.files.length !== 0 
    // && descriptionInput.value.trim() !== "" && searchbarInput.value.trim() !== "" 
    // && amenitysInput.length !== 0 && tenantsInput.length !== 0
    if (true) {
        if (confirm('Are you sure you want to add property')) {
            // formData = {
            //     title: titleInput.value,
            //     file: fileInput.files[0],
            //     desc: descriptionInput.value,
            //     searchbar: searchbarInput.value,
            //     amenitys: amenitysInput,
            //     tenants: tenantsInput
            // }
            formData = new FormData();
            formData.append('title', titleInput.value);
            formData.append('file', fileInput.files[0]);
            formData.append('desc', descriptionInput.value);
            formData.append('searchbar', searchbarInput.value);
            // formData.append('amenities', amenitysInput);
            // formData.append('tenants', tenantsInput);
            
            // console.log(formData); 
    
            //Make the AJAX request
            fetch("createProperty.php", {
                method: "POST",
                body: formData,
            })
                .then(response => {
                    // if (response.ok) {
                    //     // Handle a successful response (e.g., show a success message)
                    //     return response.json(); // Parse the JSON response
                    // } else if(response.error) {
                    //     console.error(error);
                    // } else {
                    //     // Handle errors (e.g., show an error message)
                    //     console.error("Error submitting rating");
                    //     throw new Error("Problem with response");
                    // }
                    if (response.ok) {
                        // Handle a successful response
                        return response.json(); // Parse the JSON response
                    } else {
                        // Handle errors
                        return response.json().then(errorData => {
                            throw new Error(errorData.error); // Throw an error with the error message
                        });
                    }
                })
                .then(data => {
                    if (data && data.message) {
                        console.log("Message from server:", data.message); // Log the specific message from the JSON response
                    } else {
                        console.error("No message found in the JSON response");
                    }
                })
                .catch(error => {
                    // Handle network errors
                    console.error("Network error:", error);
                });
        }
    } else {
        alert("You have not filled out all the input fields");
    }
});

//Make the AJAX request
// fetch("process_ratings.php", {
//     method: "POST",
//     body: formData,
// })
//     .then(response => {
//         if (response.ok) {
//             // Handle a successful response (e.g., show a success message)
//             return response.json(); // Parse the JSON response
//         } else {
//             // Handle errors (e.g., show an error message)
//             console.error("Error submitting rating");
//             throw new Error("Problem with response");
//         }
//     })
//     .then(data => {
//         if (data && data.message) {
//             console.log("Message from server:", data.message); // Log the specific message from the JSON response
//         } else {
//             console.error("No message found in the JSON response");
//         }
//     })
//     .catch(error => {
//         // Handle network errors
//         console.error("Network error:", error);
    // });




//firstly im going to grab each element that the form needs

//property title input
// var newPropertyTitleInput = document.getElementById('newPropertyTitle');
//addimage button 
// var addImageButton = document.getElementById('addImage');
//the actual location of the image 
// var imageFile = document.getElementById('file');

//im not sure how this works but for now im just gonna keep map here
// var map = document.getElementById('map');

//I need to get the values of every checklist and see if it is set or not. 

//now i need to grab the list of Tenants from the html


