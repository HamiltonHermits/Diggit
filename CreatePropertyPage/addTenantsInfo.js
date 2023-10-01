var addTenantModel = document.getElementById('addTenantModel');
var closeAddTenantButton = document.getElementById('closeAddTenantButton');
var emailInput = document.getElementById('emailInput');
var tenantList = document.getElementById('tenantList'); // Get the ul element
var errorDiv = document.getElementById('errorDiv'); // Get the error message div
var nextUniqueId = 1; // Initialize a unique ID counter

// Array to store email addresses
var emailArray = [];//this will be accessed when we do form submision

function openAddTenantModal(){
    addTenantModel.style.display = 'block';
}

function isValidEmail(email) {
    // A simple regular expression to check if the email is valid
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
}

function tenantExists(email) {//this doesnt make sense as the tenant might not be signed up yet, we should just add them irrespective
    return new Promise((resolve, reject) => {
        let url = "addTenant.php?email=" + email;

        // Make a GET request to map.php using fetch
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the response as JSON
            })
            .then(data => {
                console.log("tenant exists = " + data);
                // Resolve with true if tenant exists, and false if tenant does not exist
                resolve(data);
            })
            .catch(error => {
                console.error('Error:', error);
                reject(error);
            });
    });
}

function addEmail() {
    const email = emailInput.value.trim();
    if (email && !emailArray.includes(email)) {
        if (isValidEmail(email)) {
            console.log("inside add email, tenant exists = " + tenantExists(email));
            if (tenantExists(email)) {
                const listItem = document.createElement('li');
                listItem.textContent = email;
                listItem.id = 'item-' + nextUniqueId++; // Assign a unique ID
                tenantList.appendChild(listItem); // Append the list item to the ul
                emailArray.push(email); // Add email to the array
                emailInput.value = ''; // Clear the input field
                errorDiv.textContent = ''; // Clear any previous error message
            } else {
                errorDiv.textContent = 'This tenant does not exist. Please enter a valid email address.';
            }
        } else {
            errorDiv.textContent = 'Invalid email format. Please enter a valid email address.';
        }
    }
}

closeAddTenantButton.addEventListener('click', function () {
    addTenantModel.style.display = 'none';
    errorDiv.textContent = ''; // Clear any error message when closing the modal
});

window.addEventListener('click', function (event) {
    if (event.target == addTenantModel) {
        addTenantModel.style.display = 'none';
        errorDiv.textContent = ''; // Clear any error message when clicking outside the modal
    }
});
