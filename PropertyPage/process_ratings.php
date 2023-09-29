<?php
require_once('../Backend_Files/database_connect.php');
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize a response array
    $response = array();

    // Get the data sent via POST
    $propertyId = isset($_POST['propertyId']) ? $_POST['propertyId'] : '';
    $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
    $propertyReview = isset($_POST['property_review']) ? $_POST['property_review'] : '';
    //star ratings
    $cleanliness = isset($_POST['cleanliness']) ? $_POST['cleanliness'] : '';
    $noise = isset($_POST['noise']) ? $_POST['noise'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $safety = isset($_POST['safety']) ? $_POST['safety'] : '';
    $affordability = isset($_POST['affordability']) ? $_POST['affordability'] : '';
    $overallRating = isset($_POST['overallRating']) ? $_POST['overallRating'] : '';
     //slider rating
    $politenessRating = isset($_POST['politenessRating']) ? $_POST['politenessRating'] : '';
    $repairRating = isset($_POST['repairRating']) ? $_POST['repairRating'] : '';
    $responseTimeRating = isset($_POST['responseTimeRating']) ? $_POST['responseTimeRating'] : '';
    $overallLandlordRating = isset($_POST['overallLandlordRating']) ? $_POST['overallLandlordRating'] : '';

    $requiredFields = [
        'propertyId',
        'userId',
        'property_review',
        'cleanliness',
        'noise',
        'location',
        'safety',
        'affordability',
        'overallRating',
        'politenessRating',
        'repairRating',
        'responseTimeRating',
        'overallLandlordRating',
    ];
    
    $allFieldsSet = true;
    
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $allFieldsSet = false;
            break; // If any required field is not set or empty, break out of the loop.
        }
    }
    if ($allFieldsSet) {
        // All required fields are set and not empty
        // You can proceed with processing the data here
        // Example: $propertyId = $_POST['propertyId'];
    } else {
        // Handle the case where not all required fields are set
        echo "Not all required fields are set.";
    }

    // Handle the star ratings and slider ratings
    // Convert the response array to a single string
    // if(!isset($propertyId)&&) ;
    
    // try{//sql query for adding a review
    //     $query = "INSERT INTO review (`prop_id`, `politeness_rating`, `written_review`, `cleanliness_rating`,
    //      `noise_rating`, `location_rating`, `saftey_rating`, `affordability_rating`, `repair_quality_rating`, 
    //      `response_time_rating`, `user_id`, `avg_prop_review`, `overall_property_rating`)
    //     VALUES ('$propertyId','$starRatings[$category]')
    //     ";
    //     $result = mysqli_query($conn, $query);
    //     $row = mysqli_fetch_assoc($result);
    //     $something = $row['prop_id'];

    // }catch(Exception $e){
    //     http_response_code(400); // Bad Request
    //     echo json_encode(["error" => $e->getMessage()]);

    // }

    // For demonstration purposes, we'll just create a response array
    $response['success'] = true;
    $response['message'] = 'this ran $propertyId successfully'.$something;

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle non-POST requests or direct access to this script
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method Not Allowed';
}
