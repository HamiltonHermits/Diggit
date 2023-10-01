// get the form elements
const titleInput = document.getElementById('newPropertyTitle');
const fileInput = document.getElementById('file');
const descriptionInput = document.getElementById('desc-text-field');
const addressInput = document.getElementById('address');


// if save property button is pressed
document.getElementById('save-property').addEventListener('click', function () {
    const amenitysInput = arrayOfAmenityIds; // of type array
    const tenantsInput = emailArray; // of type array

    let lat = latitudeGlobal;
    let long = longitudeGlobal;

    console.log(titleInput.value.trim() !== "", fileInput.files.length !== 0, descriptionInput.value.trim() !== "", addressInput.value.trim() !== "", lat != 0, long != 0, amenitysInput.length !== 0, tenantsInput.length !== 0);
        
    // check if all the input fields are filled out 
    if (titleInput.value.trim() !== "" && fileInput.files.length !== 0 
        && descriptionInput.value.trim() !== "" && addressInput.value.trim() !== ""
        && lat != 0 && long != 0 && amenitysInput.length !== 0 && tenantsInput.length !== 0) {

        if (confirm('Are you sure you want to add property')) {
            // Create a FormData object, passing the form as a parameter
            formData = new FormData();
            formData.append('title', titleInput.value);
            console.log(fileInput.files);
            if (fileInput.files.length > 0) {
                for (var i = 0; i < fileInput.files.length; i++) {
                    formData.append('images[]', fileInput.files[i]);
                }
            }
            // formData.append('file', fileInput.files);
            formData.append('desc', descriptionInput.value);
            formData.append('address', addressInput.value);
            formData.append('lat', latitudeGlobal);
            formData.append('long', longitudeGlobal);
            formData.append('amenities', amenitysInput);
            formData.append('tenants', tenantsInput);
 
            //Make the AJAX request
            fetch("createProperty.php", {
                method: "POST",
                body: formData,
            })
            .then(response => {
                if (response.ok) {
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
                    alert("Form submitted successfully");

                     window.location.href = '../PropertyPage/property.php?id='+data.prop_id;
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