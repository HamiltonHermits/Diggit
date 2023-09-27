// JavaScript to open and close the modal
var openRatingModalBtn = document.getElementById('openRatingModalBtn');
var ratingModal = document.getElementById('ratingModal');
var closeRatingModalBtn = document.getElementById('closeRatingModalBtn');
var divWithIds = document.getElementById('modalFoot');//this is not scuffed at all i promise
var userId = divWithIds.getAttribute('data-user-id');
var pageId = divWithIds.getAttribute('data-page-id');

// console.log(userId," ",pageId);

// Open the modal
closeRatingModalBtn.addEventListener('click', () => {
    ratingModal.style.display = 'none';
});
// Open the modal
openRatingModalBtn.addEventListener('click', () => {
    ratingModal.style.display = 'block';
});


// Close the modal if the user clicks outside the modal content
window.addEventListener('click', (event) => {
    if (event.target == ratingModal) {
        ratingModal.style.display = 'none';
    }
});

// Initialize an object to store the slider values
const sliderValues = {
    politeness: 0, // Default value for politeness
    repairRating: 0, // Default value for repair
    responseTimeRating: 0, // Default value for response time
    overallLandlordRating: 0, // Default value for overall landlord rating
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
    const words = text.trim().split(/\s+/); // Split text into words
    const wordCount = words.length;

    // Update the word count display
    wordCountDisplay.textContent = `${wordCount}/250`;

    // Limit the textarea to 250 words
    if (wordCount > 250) {
        const truncatedText = words.slice(0, 250).join(' ');
        reviewTextarea.value = truncatedText;
        wordCountDisplay.textContent = `250/250`;
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

            // Toggle the filled and hollow states
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('filled');
                } else {
                    s.classList.remove('filled');
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
        }

        // Add slider ratings
        const sliderElements = document.querySelectorAll('.slider');
        sliderElements.forEach((slider) => {
            const category = slider.parentElement.id;
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
                    // Handle a successful response (e.g., show a success message)
                    return response.json(); // Parse the JSON response
                } else {
                    // Handle errors (e.g., show an error message)
                    console.error("Error submitting rating");
                    throw new Error("Problem with response");
                }
            })
            .then(data => {
                if (data && data.message) {
                    console.log("Message from server:", data.message); // Log the specific message from the JSON response
                } else {
                    console.error("No message found in the JSON response");
                }
            })
            .catch (error => {
            // Handle network errors
            console.error("Network error:", error);
        });
    } else {
    // Display a message to the user indicating that they need to rate all categories
    alert('Please rate all categories before submitting the form.PropertyRating:'+isAllRated+" Landlord"+isAllRatedLandLord);
    
}
});
