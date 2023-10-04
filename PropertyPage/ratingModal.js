// JavaScript to open and close the modal
var openRatingModalBtn = document.getElementById('openRatingModalBtn');
var ratingModal = document.getElementById('ratingModal');
var closeRatingModalBtn = document.getElementById('closeRatingModalBtn');
var userId = ratingModal.getAttribute('data-user-id');
var pageId = ratingModal.getAttribute('data-page-id');
var openRatingModalBtnButItsNot = document.getElementById('openRatingModalBtnButItsNot');
var notLoggedInModalSomethingElse = document.getElementById('notLoggedInModalSomethingElse');
var loginButtonPropertyPage = document.getElementById('loginButtonPropertyPage');
// console.log(userId," ",pageId);
var closeNotLoggedInModalSomethingElse = document.getElementById('closeNotLoggedInModalSomethingElse');
var notATenantModal = document.getElementById('notATenantModal');
var closeNotATenantModal = document.getElementById('closeNotATenantModal');
var openWhoopsNotAllowed = document.getElementById('openWhoopsNotAllowed');

//im trying to give feedback to user
var ratingSuccessfulModal = document.getElementById('ratingSuccessfulModal');
var closeRatingSuccessfulModal = document.getElementById('closeRatingSuccessfulModal');

var ratingUnsuccModal = document.getElementById('ratingUnsuccModal');
var closeRatingUnsuccModal = document.getElementById('closeRatingUnsuccModal');

closeRatingUnsuccModal.addEventListener('click', () => {
    ratingUnsuccModal.style.display = 'none';
});
window.addEventListener('click', (event) => {

    if (event.target == ratingUnsuccModal) {
        ratingUnsuccModal.style.display = 'none';
    }
});

if (openWhoopsNotAllowed) {
    openWhoopsNotAllowed.addEventListener('click', () => {
        openWhoopsNotAllowed.style.display = 'none';
        notATenantModal.style.display = 'block';
    });
}

if (notATenantModal) {
    closeNotATenantModal.addEventListener('click', () => {
        notATenantModal.style.display = 'none';
    });
    window.addEventListener('click', (event) => {

        if (event.target == notATenantModal) {
            notATenantModal.style.display = 'none';
            openWhoopsNotAllowed.style.display = 'block';
        }
    });
}
//event listeners for when the user is not logged in 
if (openRatingModalBtnButItsNot) {
    closeNotLoggedInModalSomethingElse.addEventListener('click', () => {
        notLoggedInModalSomethingElse.style.display = 'none';
    });
    openRatingModalBtnButItsNot.addEventListener('click', () => {
        notLoggedInModalSomethingElse.style.display = 'block';
    });
    window.addEventListener('click', (event) => {

        if (event.target == notLoggedInModalSomethingElse) {
            notLoggedInModalSomethingElse.style.display = 'none';
        }
    });
}

//event listeners for when the user is logged in 
if (openRatingModalBtn) {
    openRatingModalBtn.addEventListener('click', () => {
        ratingModal.style.display = 'block';
        openRatingModalBtn.style.display = 'none';
    });
    closeRatingModalBtn.addEventListener('click', () => {
        ratingModal.style.display = 'none';
        openRatingModalBtn.style.display = 'block';
    });
    window.addEventListener('click', (event) => {
        if (event.target == ratingModal) {
            ratingModal.style.display = 'none';
            openRatingModalBtn.style.display = 'block';
        }
    });
}
if (loginButtonPropertyPage) {//we are clicking the login button on create page 
    loginButtonPropertyPage.addEventListener('mouseenter', function () {
        loginButtonPropertyPage.style.backgroundColor = '#d9d9d9'; // Change to the hover color
        loginButtonPropertyPage.style.color = '#202024';
    });

    loginButtonPropertyPage.addEventListener('mouseleave', function () {
        loginButtonPropertyPage.style.backgroundColor = '#ad5511'; // Change back to the normal color
        loginButtonPropertyPage.style.color = '#d9d9d9';
    });

    loginButtonPropertyPage.addEventListener('click', function () {//make sure that when you click the button login comes up
        loginModal.style.display = 'block';
        notLoggedInModalSomethingElse.style.display = 'none';
    });
}



// Initialize an object to store the slider values
const sliderValues = {
    politenessRating: 1, // Default value for politeness
    repairRating: 1, // Default value for repair
    responseTimeRating: 1, // Default value for response time
    overallLandlordRating: 1, // Default value for overall landlord rating
};

// JavaScript to update slider values, store them, and log them
const sliderElements = document.querySelectorAll('.slider');

sliderElements.forEach((slider) => {
    const category = slider.parentElement.id; // Get the category name
    slider.value = sliderValues[category]; // Set the slider value from the stored object

    slider.addEventListener('input', () => {
        const value = parseInt(slider.value); // Get the updated value
        sliderValues[category] = value; // Update the stored value

        // Set the --value custom property for the slider track
        slider.style.setProperty('--value', `${(value - 1) * 25}%`);

        console.log(`Category: ${category}, Value: ${value}`); // Log the value
    });
});
//write a review js 
// Get the textarea element and word count display element
const reviewTextarea = document.getElementById('reviewTextarea');
const wordCountDisplay = document.getElementById('wordCount');

// Add an input event listener to the textarea
reviewTextarea.addEventListener('input', () => {
    const text = reviewTextarea.value;

    const wordCount = text.length;

    // Update the word count display
    wordCountDisplay.textContent = `${wordCount}/500`;

    // Limit the textarea to 250 words
    if (wordCount > 500) {
        const truncatedText = words.slice(0, 250).join(' ');
        reviewTextarea.value = truncatedText;
        wordCountDisplay.textContent = `500/250`;
    }
});

// Initialize an object to store selected ratings for each category
const selectedRatings = {};

// JavaScript to handle star rating selection
const starContainers = document.querySelectorAll('.star-rating');

// Initialize selectedRatings with default values for each category
starContainers.forEach((container) => {
    const category = container.getAttribute('data-category');
    selectedRatings[category] = 0;

    const stars = container.querySelectorAll('.star');
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = index + 1; // Rating starts from 1, not 0
            container.setAttribute('data-rating', rating); // Update the data-rating attribute

            // Toggle between filled and not filled stars
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.innerHTML = '&#9733;'; // Filled star
                } else {
                    s.innerHTML = '&#9734;'; // Not filled star
                }
            });

            // Update the selected rating for the category
            selectedRatings[category] = rating;

            // Log the selected rating to the console
            console.log(`Selected rating for ${category}: ${rating}`);
        });
    });
});



ratingForm.addEventListener('submit', (event) => {
    // Prevent the form from submitting by default
    event.preventDefault();

    let isAllRated = true;


    for (const somethingElse in selectedRatings) {
        if (selectedRatings.hasOwnProperty(somethingElse) && selectedRatings[somethingElse] === 0) {
            // If any category is not rated (has a value of 0), set the flag to false
            isAllRated = false;
            // You can add visual feedback for the user here if needed
            console.log(`somethingElse "${somethingElse}" is not rated.`);

        }
    }
    let isAllRatedLandLord = true;

    for (const category in sliderValues) {
        if (sliderValues[category] === 0) {
            isAllRatedLandLord = false; // If any slider has a value of 0, set isAllRated to false
            break; // No need to continue checking once one slider is not chosen
        }
    }


    // If all categories are rated, add star ratings, slider ratings, and review textarea to formData and submit via AJAX
    if (isAllRated && userId != "" && isAllRatedLandLord) {
        // Get form data
        const formData = new FormData(ratingForm);

        // Add star ratings from the selectedRatings object
        for (const category in selectedRatings) {
            formData.append(category, selectedRatings[category]);
            console.log(category);
        }

        // Add slider ratings (ATTEMPTING TO CALC Overall Rating)
        const sliderElements = document.querySelectorAll('.slider');
        sliderElements.forEach((slider) => {

            const category = slider.parentElement.id;
            console.log(category);
            const value = slider.value;
            formData.append(category, value);
        });



        // Add review textarea
        const reviewTextarea = document.getElementById('reviewTextarea');
        formData.append('property_review', reviewTextarea.value);

        formData.append('propertyId', pageId);//this is gotten at the top

        formData.append('userId', userId);//this shouldnt work if its not set




        // Make the AJAX request
        fetch("process_ratings.php", {
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
                    ratingSuccessfulModal.style.display = 'block';
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {

                    ratingUnsuccModal.style.display = 'block';

                    console.error("No message found in the JSON response");
                }
            })
            .catch(error => {
                // Handle network errors
                console.error("Network error:", error);
            });
    } else {
        // Display a message to the user indicating that they need to rate all categories
        alert('Please rate all categories before submitting the form.PropertyRating:' + isAllRated + " Landlord" + isAllRatedLandLord);

    }
});
