// JavaScript to open and close the modal
var openRatingModalBtn = document.getElementById('openRatingModalBtn');
var ratingModal = document.getElementById('ratingModal');
var closeRatingModalBtn = document.getElementById('closeRatingModalBtn');

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
//this is what we gonna grab when we submit the form 
const selectedRatings = {};

// JavaScript to handle star rating selection
const starContainers = document.querySelectorAll('.star-rating');

starContainers.forEach((container) => {
    const stars = container.querySelectorAll('.star');
    const category = container.getAttribute('data-category');
    
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
// Get the form element
const ratingForm = document.getElementById('ratingForm');

// Add a submit event listener to the form
ratingForm.addEventListener('submit', (event) => {
    // Prevent the form from submitting by default
    event.preventDefault();

    // Check if any category has a rating of 0 (not rated)
    const categories = document.querySelectorAll('.rating-item');
    let isAllRated = true;

    categories.forEach((category) => {
        const categoryId = category.id;
        const rating = parseInt(category.querySelector('.star-rating').getAttribute('data-rating'));
        
        if (rating === 0) {
            // If any category is not rated, set the flag to false
            isAllRated = false;
            // You can add visual feedback for the user here if needed
            category.classList.add('unrated');
        } else {
            // Remove any previous visual feedback
            category.classList.remove('unrated');
        }
    });

    // If all categories are rated, submit the form
    if (isAllRated) {
        ratingForm.submit();
    } else {
        // Display a message to the user indicating that they need to rate all categories
        alert('Please rate all categories before submitting the form.');
    }
});
// Initialize an object to store the slider values
const sliderValues = {
    politeness: 3, // Default value for politeness
    repair: 3, // Default value for repair
    responseTime: 3, // Default value for response time
    overallLandlord: 3, // Default value for overall landlord rating
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
