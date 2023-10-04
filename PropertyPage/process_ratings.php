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
    // Star ratings
    $cleanliness = isset($_POST['cleanliness']) ? $_POST['cleanliness'] : '';
    $noise = isset($_POST['noise']) ? $_POST['noise'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
    $safety = isset($_POST['safety']) ? $_POST['safety'] : '';
    $affordability = isset($_POST['affordability']) ? $_POST['affordability'] : '';
    $overallRating = isset($_POST['overallRating']) ? $_POST['overallRating'] : '';
    // Slider ratings
    $politenessRating = isset($_POST['politenessRating']) ? $_POST['politenessRating'] : '';
    $repairRating = isset($_POST['repairRating']) ? $_POST['repairRating'] : '';
    $responseTimeRating = isset($_POST['responseTimeRating']) ? $_POST['responseTimeRating'] : '';
    $overallLandlordRating = isset($_POST['overallLandlordRating']) ? $_POST['overallLandlordRating'] : '';

    $checkIfIsset = isset($_POST['propertyId']) && isset($_POST['userId']) && isset($_POST['property_review']) && isset($_POST['cleanliness'])&&
    isset($_POST['noise']) && isset($_POST['location']) && isset($_POST['safety']) && isset($_POST['affordability']) && isset($_POST['overallRating'])
    && isset($_POST['politenessRating']) && isset($_POST['repairRating']) && isset($_POST['responseTimeRating']) && isset($_POST['overallLandlordRating']);

    $currentDate = date("Y-m-d");

    if (!empty($propertyId) && !empty($userId) && $checkIfIsset) {
        try {
            // Prepare a SQL statement with placeholders for binding values to stop sql injection
            $stmt = $conn->prepare("INSERT INTO review (
                prop_id, 
                politeness_rating,
                written_review,
                cleanliness_rating,
                noise_rating,
                location_rating, 
                saftey_rating, 
                affordability_rating, 
                repair_quality_rating, 
                response_time_rating, 
                user_id, 
                overall_tenant_rating, 
                date_reviewed,
                overall_property_rating
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Bind the parameters
            $stmt->bind_param("ssssssssssssss", $propertyId, $politenessRating, $propertyReview, $cleanliness, 
            $noise, $location, $safety, $affordability, $repairRating, $responseTimeRating, $userId, $overallLandlordRating, $currentDate, $overallRating);

            // Execute the statement
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['prop_id'] = $propertyId;
                $response['message'] = 'Review added successfully';
            } else {
                $response['success'] = false;
                $response['message'] = 'Failed to add review';
            }

            // Close the statement
            $stmt->close();
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => $e->getMessage()]);
        }

    } else {
        $response['success'] = false;
        $response['message'] = 'Property ID and/or User ID are not provided or not everything is sett';
    }
    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Handle non-POST requests or direct access to this script
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method Not Allowed';
}
