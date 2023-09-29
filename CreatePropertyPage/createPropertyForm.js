// get the form elements
const titleInput = document.getElementById('newPropertyTitle');
const fileInput = document.getElementById('file');
const descriptionInput = document.getElementById('desc-text-field');
const addressInput = document.getElementById('address');
const lat = latitudeGlobal;
const long = longitudeGlobal;
const amenitysInput = arr2; // of type array
const tenantsInput = emailArray; // of type array


// if save property button is pressed
document.getElementById('save-property').addEventListener('click', function () {
    // check if all the input fields are filled out 
    // titleInput.value.trim() !== "" && fileInput.files.length !== 0 
    // && descriptionInput.value.trim() !== "" && searchbarInput.value.trim() !== "" 
    // && amenitysInput.length !== 0 && tenantsInput.length !== 0
    if (titleInput.value.trim() !== "" && fileInput.files.length !== 0 
        && descriptionInput.value.trim() !== "" && addressInput.value.trim() !== ""
        && lat != 0 && long != 0 
        && amenitysInput.length !== 0 && tenantsInput.length !== 0) {
        if (confirm('Are you sure you want to add property')) {
            // Create a FormData object, passing the form as a parameter
            formData = new FormData();
            formData.append('title', titleInput.value);
            formData.append('file', fileInput.files[0]);
            formData.append('desc', descriptionInput.value);
            formData.append('address', addressInput.value);
            formData.append('lat', latitudeGlobal);
            formData.append('long', longitudeGlobal);
 
            //Make the AJAX request
            fetch("createProperty.php", {
                method: "POST",
                body: formData,
            })
            .then(response => {
                if (response.ok) {
                    // Handle a successful response (e.g., show a success message)
                    return response.json(); // Parse the JSON response
                } else {
                    // Handle errors (e.g., show an error message)
                    return response.json().then(errorData => {
                        console.error("Error from server:", errorData.error); // Log the error message from the server
                        throw new Error("Problem with response");
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