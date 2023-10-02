// get the form elements
const titleInput = document.getElementById('newPropertyTitle');
const fileInput = document.getElementById('file');
const descriptionInput = document.getElementById('desc-text-field');
const addressInput = document.getElementById('address');
const notFilledOutYet = document.getElementById('notFilledOutYet');
const closeNotFilledOutYet = document.getElementById('closeNotFilledOutYet');
const formFilledOutModal = document.getElementById('formFilledOutModal');
const closeFormFilledOutModal = document.getElementById('closeFormFilledOutModal');
const selectedImagesDivNeedThis = document.getElementById('selectedImages');







// if save property button is pressed
document.getElementById('save-property').addEventListener('click', function () {
    const imageFileNames = [];
    const imageParagraphs = selectedImagesDivNeedThis.querySelectorAll('p');
    imageParagraphs.forEach(function (paragraph) {
        const fileName = paragraph.textContent.trim();
        imageFileNames.push(fileName);
    });
    // console.log(imageFileNames);


    const amenitysInput = arrayOfAmenityIds; // of type array

    // Initialize an empty array to store the items
    let itemList = [];

    // Select the <ul> element by its ID
    const ul = document.getElementById('tenantList');

    // Iterate through the list items
    for (let i = 0; i < ul.children.length; i++) {
        const listItem = ul.children[i];

        // Exclude the button text by selecting only the text node children
        const textNodes = Array.from(listItem.childNodes).filter(node => node.nodeType === Node.TEXT_NODE);

        // Extract and concatenate the text content from text nodes
        const text = textNodes.map(node => node.textContent.trim()).join(' ');

        // Push the text content into the array
        itemList.push(text);
    }

    const tenantsInput = itemList; // of type array
    // console.log(tenantsInput);
    console.log(amenitysInput);
    let lat = latitudeGlobal;
    let long = longitudeGlobal;
    const filesGiven = false;
    if(fileInput.files.length > 0 || imageFileNames>0)    filesGiven = true ;

    console.log(titleInput.value.trim() !== "", filesGiven, descriptionInput.value.trim() !== "", addressInput.value.trim() !== "", lat != 0, long != 0, amenitysInput.length !== 0, tenantsInput.length !== 0);

    // check if all the input fields are filled out 
    if (titleInput.value.trim() !== "" && filesGiven !== 0
        && descriptionInput.value.trim() !== "" && addressInput.value.trim() !== ""
        && lat != 0 && long != 0 && amenitysInput.length !== 0 && tenantsInput.length !== 0) {
        //got rid of confirm looks tacky
        if (true) {
            // Create a FormData object, passing the form as a parameter
            formData = new FormData();
            formData.append('title', titleInput.value);
            console.log(fileInput.files);
            if (fileInput.files.length > 0) {
                //if it is a file
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
                        // Handle errors
                        return response.json().then(errorData => {
                            console.error("Error from server:", errorData.error); // Log the error message from the server
                            throw new Error("Problem with response");
                        });
                    }
                })
                .then(data => {
                    if (data && data.message) {
                        formFilledOutModal.style.display = 'block';
                        // alert("Form submitted successfully");
                        setTimeout(function () {
                            // Redirect to the desired URL
                            window.location.href = '../PropertyPage/property.php?id=' + data.prop_id;
                        }, 1500);
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
        notFilledOutYet.style.display = 'block';
        // alert("You have not filled out all the input fields");
    }
});
closeFormFilledOutModal.addEventListener('click', function () {
    formFilledOutModal.style.display = 'none';
});

closeNotFilledOutYet.addEventListener('click', function () {
    notFilledOutYet.style.display = 'none';
});
window.addEventListener('click', function (event) {
    if (event.target == notFilledOutYet) {
        notFilledOutYet.style.display = 'none';
    }
    if (event.target == formFilledOutModal) {
        formFilledOutModal.style.display = 'none';
    }
});
