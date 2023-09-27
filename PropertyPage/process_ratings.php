<?php
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize a response array
    $response = array();

    // Get the data sent via POST
    $propertyId = isset($_POST['propertyId']) ? $_POST['propertyId'] : '';
    $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
    $propertyReview = isset($_POST['property_review']) ? $_POST['property_review'] : '';
    
    // Handle the star ratings and slider ratings
    $starRatings = array();
    $sliderRatings = array();

    // Loop through the POST data to find star and slider ratings
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'star-') === 0) {
            // This is a star rating
            $category = substr($key, 5); // Remove "star-" prefix
            $starRatings[$category] = $value;
        } elseif (strpos($key, 'slider-') === 0) {
            // This is a slider rating
            $category = substr($key, 7); // Remove "slider-" prefix
            $sliderRatings[$category] = $value;
        }
    }

    // You can now process the data as needed, e.g., insert it into a database

    // For demonstration purposes, we'll just create a response array
    $response['success'] = true;
    $response['message'] = 'this ran $propertyId successfully'.$userId;

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle non-POST requests or direct access to this script
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method Not Allowed';
}
?>
