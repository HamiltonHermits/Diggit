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
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
}

function addEmail() {
    var email = emailInput.value.trim();
    if (email) {
        if (isValidEmail(email)) {
            const listItem = document.createElement('li');
            listItem.textContent = email;
            listItem.id = 'item-' + nextUniqueId++; // Assign a unique ID
            tenantList.appendChild(listItem); // Append the list item to the ul
            emailArray.push(email); // Add email to the array
            emailInput.value = ''; // Clear the input field
            errorDiv.textContent = ''; // Clear any previous error message
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
